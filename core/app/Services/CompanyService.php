<?php

namespace App\Services;

use App\Models\Country; // Ensure you're using the correct model
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Helpers\Helper; // Assuming you have a Helper class for image processing
use App\Models\Company;
use App\Models\CompanyActivitySelect;
use App\Models\CompanyCity;
use App\Models\CompanyCountry;
use App\Models\TypeActivityCompany;
use Illuminate\Support\Facades\DB; // Add this to your imports

use Exception;

class CompanyService
{
    private $uploadPath = 'uploads/companies/'; // Define your upload path

    public function storeCompany($request)
    {
        DB::beginTransaction(); // Start the transaction

        try {
            // Define validation rules
            $rules = [
                'name_*' => 'required|string|max:255', // validate for all language name fields
                'email' => 'required|email|max:255',
                'code' => 'required|numeric',
                'phone' => 'required|numeric',
                'BL' => 'required|numeric',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'BL_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'id_front_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'about_*' => 'required|string', // validate for about field in all languages

                'country_id' => 'required|array',
                'country_id.*' => 'exists:countries,id',

                'city_id' => 'required|array',
                'city_id.*' => 'exists:cities,id',

                'typeActivity_id' => 'required|array',
                'typeActivity_id.*' => 'exists:type_activities,id',
            ];

            // Define custom messages
            $messages = [
                'name_*.required' => 'The company name in all active languages is required.',
                'email.required' => 'The email is required.',
                'email.email' => 'Please provide a valid email address.',
                'code.required' => 'The country code is required.',
                'phone.required' => 'The phone number is required.',
                'BL.required' => 'The license number is required.',
                'logo.image' => 'The logo must be an image.',
                'logo.mimes' => 'The logo must be a file of type: jpeg, png, jpg, gif.',
                'country_id.required' => 'At least one country must be selected.',
                'city_id.required' => 'At least one city must be selected.',
                'typeActivity_id.required' => 'At least one activity type must be selected.',
                'about_*.required' => 'The about field is required in all active languages.',
            ];

            // Validate request data
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                DB::rollBack(); // Rollback the transaction if validation fails
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Handle file uploads
            $fileFinalNames = [];
            $filesToUpload = ['logo', 'cover', 'BL_image', 'id_front_image'];
            foreach ($filesToUpload as $fileInput) {
                if ($request->hasFile($fileInput)) {
                    $file = $request->file($fileInput);
                    $fileFinalName = time() . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();
                    $path = $this->uploadPath;

                    // Ensure the directory exists
                    if (!File::exists($path)) {
                        File::makeDirectory($path, 0755, true);
                    }

                    // Move the uploaded file
                    $file->move($path, $fileFinalName);

                    // Resize & optimize
                    Helper::imageResize($path . '/' . $fileFinalName);
                    Helper::imageOptimize($path . '/' . $fileFinalName);

                    $fileFinalNames[$fileInput] = $fileFinalName;
                }
            }

            // Create new company instance
            $company = new Company();

            // Assign values for all languages
            foreach (Helper::languagesList() as $ActiveLanguage) {
                $company->{"name_" . $ActiveLanguage->code} = $request->{"name_" . $ActiveLanguage->code};
                $company->{"about_" . $ActiveLanguage->code} = $request->{"about_" . $ActiveLanguage->code};
            }

            // Assign other company fields
            $company->email = $request->email;
            $company->code = $request->code;
            $company->phone = $request->phone;
            $company->BL = $request->BL;
            $company->company_status_id = 1;

            // Assign uploaded files if they exist
            foreach ($fileFinalNames as $field => $filename) {
                $company->{$field} = $filename;
            }

            // Save the company
            $company->save();

            // Handle country associations
            $countries = $request->input('country_id', []);
            foreach ($countries as $countryID) {
                CompanyCountry::create([
                    'company_id' => $company->id,
                    'country_id' => $countryID,
                ]);
            }

            // Handle city associations
            $cities = $request->input('city_id', []);
            foreach ($cities as $cityID) {
                CompanyCity::create([
                    'company_id' => $company->id,
                    'city_id' => $cityID,
                ]);
            }

            // Handle type activities associations
            $typeActivities = $request->input('typeActivity_id', []);

            foreach ($typeActivities as $index => $typeActivityID) {
                $info_ar = $request->input("info_ar.$index") ?? null;
                $info_en = $request->input("info_en.$index") ?? null;


                TypeActivityCompany::create([
                    'company_id' => $company->id,
                    'type_activity_id' => $typeActivityID,
                    'info_ar' => $info_ar,
                    'info_en' => $info_en,

                ]); // Bulk insert with timestamps
            }


            foreach ($typeActivities as $typeActivityID) {
                CompanyActivitySelect::create([
                    'company_id' => $company->id,
                    'type_activity_id' => $typeActivityID,
                ]); // Bulk insert with timestamps
            }



            DB::commit(); // Commit the transaction
            return true;
        } catch (Exception $e) {
            DB::rollBack(); // Rollback the transaction on exception
            return redirect()->back()->with('errorMessage', __('backend.error'));
        }
    }

    public function updateCompany($request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'about_en' => 'nullable|string',
            'about_ar' => 'nullable|string',
            'email' => 'required|email|max:255',
            'code' => 'required|string|max:50',
            'phone' => 'nullable|string|max:20',
            'BL' => 'nullable|string|max:50',
            'country_id' => 'nullable|array',
            'country_id.*' => 'exists:countries,id',
            'city_id' => 'nullable|array',
            'city_id.*' => 'exists:cities,id',
            'typeActivity_id' => 'nullable|array',
            'typeActivity_id.*' => 'exists:type_activities,id',
            'info_ar.*' => 'nullable|string',
            'info_en.*' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'BL_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'id_front_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::beginTransaction(); // Start the transaction

        try {
            // Find the company by ID
            $company = Company::findOrFail($id);

            // Handle file uploads
            $fileFinalNames = [];
            $filesToUpload = ['logo', 'cover', 'BL_image', 'id_front_image'];

            foreach ($filesToUpload as $fileInput) {
                if ($request->hasFile($fileInput)) {
                    $file = $request->file($fileInput);
                    $fileFinalName = time() . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();
                    $path = $this->uploadPath;

                    // Ensure the directory exists
                    if (!File::exists($path)) {
                        File::makeDirectory($path, 0755, true);
                    }

                    // Move the uploaded file
                    $file->move($path, $fileFinalName);

                    // Resize & optimize
                    Helper::imageResize($path . '/' . $fileFinalName);
                    Helper::imageOptimize($path . '/' . $fileFinalName);

                    $fileFinalNames[$fileInput] = $fileFinalName;
                }
            }

            // Update company fields for all languages
            foreach (Helper::languagesList() as $ActiveLanguage) {
                $company->{"name_" . $ActiveLanguage->code} = $request->input("name_" . $ActiveLanguage->code);
                $company->{"about_" . $ActiveLanguage->code} = $request->input("about_" . $ActiveLanguage->code);
            }

            // Update other company fields
            $company->email = $request->email;
            $company->code = $request->code;
            $company->phone = $request->phone;
            $company->BL = $request->BL;
            $company->company_status_id = $company->company_status_id ?? 1;

            // Assign uploaded files if they exist
            foreach ($fileFinalNames as $field => $filename) {
                $company->{$field} = $filename;
            }

            // Save the updated company
            $company->save();

            // Update country associations (sync to avoid duplicates)
            $countries = $request->input('country_id', []);
            $company->countries()->sync($countries); // Sync the country IDs directly

            // Update city associations (sync to avoid duplicates)
            $city = $request->input('city_id', []);
            $company->cities()->sync($city); // Sync the city IDs directly

            // Update type activities associations
            $typeActivities = $request->input('typeActivity_id', []);
            foreach ($typeActivities as $index => $typeActivityID) {
                $info_ar = $request->input("info_ar.$index") ?? null;
                $info_en = $request->input("info_en.$index") ?? null;

                TypeActivityCompany::updateOrCreate(
                    [
                        'company_id' => $company->id,
                        'type_activity_id' => $typeActivityID,
                    ],
                    [
                        'info_ar' => $info_ar,
                        'info_en' => $info_en,
                    ]
                );
            }

            DB::commit(); // Commit the transaction

            return true;
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback the transaction on error

            // Log the error for debugging

            // Return false and a user-friendly error message
            return response()->json(['error' => 'Failed to update company. Please try again.'], 500);
        }
    }
    public function getCompany()
    {
        // Placeholder for future implementation
    }

    public function updateStatus($category)
    {
        // Placeholder for future implementation
    }
}
