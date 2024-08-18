<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Models\Country;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Models\WebmasterSection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


class CountryController extends Controller
{
    private $uploadPath = "uploads/topics/";
    public function index()
    {
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        if (@Auth::user()->permissionsGroup->view_status) {
            $country = Country::with('currency')->where('created_by', '=', Auth::user()->id)->paginate(config('smartend.backend_pagination'));
        } else {
            $country = Country::with('currency')->paginate(config('smartend.backend_pagination'));
        }
        return view('admin.country.index', compact("country", "GeneralWebmasterSections"));
    }

    public function create()
    {
        //
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        $currency = Currency::all();
        return view("admin.country.create", compact("GeneralWebmasterSections", "currency"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request data
        $this->validate($request, [
            'flag' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // image validation with size limit
            'currency_id' => 'required|integer|exists:currencies,id', // currency validation
            'name_*' => 'required|string|max:255', // validate for all language name fields
        ], [
            'flag.image' => 'The flag must be an image.',
            'flag.mimes' => 'The flag must be a file of type: jpeg, png, jpg, gif.',
            'flag.max' => 'The flag may not be greater than 2MB.',
            'currency_id.required' => 'The currency is required.',
            'currency_id.integer' => 'The currency must be a valid integer.',
            'currency_id.exists' => 'The selected currency is invalid.',
            'name_*.required' => 'The country name in all active languages is required.',
            'name_*.string' => 'The country name must be a valid string.',
            'name_*.max' => 'The country name may not be greater than 255 characters.'
        ]);
        // Start of Upload Files
        $formFileName = "image";
        $fileFinalName = "";
        if ($request->$formFileName != "") {
            $fileFinalName = time() . rand(
                1111,
                9999
            ) . '.' . $request->file($formFileName)->getClientOriginalExtension();
            $path = $this->uploadPath;
            $request->file($formFileName)->move($path, $fileFinalName);
            // resize & optimize
            Helper::imageResize($path . $fileFinalName);
            Helper::imageOptimize($path . $fileFinalName);
        }
        // End of Upload Files

        $country = new Country();

        foreach (Helper::languagesList() as $ActiveLanguage) {
            $country->{"name_" . $ActiveLanguage->code} = $request->{"name_" . $ActiveLanguage->code};
        }
        $country->currency_id = $request->currency_id;

        if ($fileFinalName != "") {
            $country->flag = $fileFinalName;
        }

        $country->save();
        return redirect()->route('country.index')->with('doneMessage', __('backend.addDone'));
    }

    public function edit($id)
    {
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        $country = Country::find($id);
        $currency = Currency::all();

        return view("admin.country.edit", compact("country", "currency", "GeneralWebmasterSections"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $this->validate($request, [
            'flag' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // image validation with size limit
            'currency_id' => 'required|integer|exists:currencies,id', // currency validation
            'name_*' => 'required|string|max:255', // validate for all language name fields
        ], [
            'flag.image' => 'The flag must be an image.',
            'flag.mimes' => 'The flag must be a file of type: jpeg, png, jpg, gif.',
            'flag.max' => 'The flag may not be greater than 2MB.',
            'currency_id.required' => 'The currency is required.',
            'currency_id.integer' => 'The currency must be a valid integer.',
            'currency_id.exists' => 'The selected currency is invalid.',
            'name_*.required' => 'The country name in all active languages is required.',
            'name_*.string' => 'The country name must be a valid string.',
            'name_*.max' => 'The country name may not be greater than 255 characters.'
        ]);

        // Find the country by ID
        $country = Country::find($id);
        if (!empty($country)) {
            // Start of Upload Files
            $formFileName = "image";
            $fileFinalName = "";
            if ($request->hasFile($formFileName)) {
                // Delete the existing image if it's not the default
                if ($country->image != "" && $country->image != "nav-bg.png") {
                    File::delete($this->uploadPath . $country->image);
                }

                // Generate new file name and move the uploaded file
                $fileFinalName = time() . rand(1111, 9999) . '.' . $request->file($formFileName)->getClientOriginalExtension();
                $path = $this->uploadPath;
                $request->file($formFileName)->move($path, $fileFinalName);

                // Resize & optimize the image
                Helper::imageResize($path . $fileFinalName);
                Helper::imageOptimize($path . $fileFinalName);
            }

            // If the image deletion flag is set, delete the existing image
            if ($request->image_delete == 1) {
                if (!empty($country->image) && $country->image != "nav-bg.png") {
                    File::delete($this->uploadPath . $country->image);
                }
                $country->image = "";
            }

            // Update the country's name in all languages
            foreach (Helper::languagesList() as $ActiveLanguage) {
                $country->{"name_" . $ActiveLanguage->code} = $request->{"name_" . $ActiveLanguage->code};
            }
            // Update the currency ID
            $country->currency_id = $request->currency_id;
            // Update the flag if a new file was uploaded
            if (!empty($fileFinalName)) {
                $country->flag = $fileFinalName;
            }
            $country->save();

            return redirect()->route('country.index')
                ->with('doneMessage', __('backend.saveDone'));
        } else {
            // If country not found, redirect to the index page
            return redirect()->back();
        }
    }

    public function updateStatus($id)
    {
        // Find the TypeActivity by ID
        $typeActivity = Country::find($id);

        if ($typeActivity) {
            // Toggle the status: if it's 0, make it 1; otherwise, make it 0
            $typeActivity->status = $typeActivity->status == 0 ? 1 : 0;

            // Save the updated status
            $typeActivity->save();

            return redirect()->back()->with(
                'doneMessage',
                __('backend.saveDone')
            );
        } else {
            // If TypeActivity not found, redirect back with an error message
            return redirect()->back()->with(
                'errorMessage',
                __('backend.itemNotFound')
            );
        }
    }
}
