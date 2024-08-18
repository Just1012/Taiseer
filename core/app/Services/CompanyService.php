<?php

namespace App\Services;

use App\Models\Country; // Ensure you're using the correct model
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Helpers\Helper; // Assuming you have a Helper class for image processing
use App\Models\Company;
use App\Models\CompanyActivitySelect;
use App\Models\CompanyCountry;
use App\Models\TypeActivityCompany;
use Illuminate\Support\Facades\DB; // Add this to your imports

use Exception;

class CompanyService
{
    protected $uploadPath = 'uploads/companies/'; // Define your upload path

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
                'typeActivity_id.required' => 'At least one activity type must be selected.',
                'about_*.required' => 'The about field is required in all active languages.',
            ];

            // Validate request data
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Handle file uploads
            $fileFinalNames = [];
            $filesToUpload = ['logo', 'cover', 'BL_image', 'id_front_image'];
            foreach ($filesToUpload as $fileInput) {
                if ($request->hasFile($fileInput)) {
                    $file = $request->file($fileInput);
                    $fileFinalName = time() . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();
                    $path = public_path($this->uploadPath);

                    // Ensure the directory exists
                    if (!File::exists($path)) {
                        File::makeDirectory($path, 0755, true);
                    }

                    // Move the uploaded file
                    $file->move($path, $fileFinalName);

                    // Resize & optimize
                    Helper::imageResize($path . $fileFinalName);
                    Helper::imageOptimize($path . $fileFinalName);

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

            // Assign country and activity type
            $typeActivities = $request->input('typeActivity_id', []); // No need for json_decode
            $countries = $request->input('country_id', []); // No need for json_decode

            // Iterate through the selected type activities
            foreach ($typeActivities as $typeActivityID) {
                // Create TypeActivityCompany records for each type activity
                TypeActivityCompany::create([
                    'company_id' => $company->id,
                    'type_activity_id' => $typeActivityID,
                ]);
            }

            // Iterate through the selected countries
            foreach ($countries as $countryID) {
                // Assuming there’s a CountryCompany model to associate companies and countries
                CompanyCountry::create([
                    'company_id' => $company->id,
                    'country_id' => $countryID,
                ]);
            }

            foreach ($typeActivities as $typeActivityID) {
                // Assuming there’s a CountryCompany model to associate companies and countries
                CompanyActivitySelect::create([
                    'company_id' => $company->id,
                    'type_activity_id' => $typeActivityID,
                ]);
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('errorMessage', __('backend.error'));
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
