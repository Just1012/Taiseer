<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\City;
use App\Models\Country;
use App\Models\WebmasterSection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class CityController extends Controller
{
    private $uploadPath = "uploads/topics/";
    public function index()
    {
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        if (@Auth::user()->permissionsGroup->view_status) {
            $city = City::with('country')->where('created_by', '=', Auth::user()->id)
                ->paginate(config('smartend.backend_pagination'));
        } else {
            $city = City::with('country')->paginate(config('smartend.backend_pagination'));
        }
        return view('admin.city.index', compact("city", "GeneralWebmasterSections"));
    }

    public function create()
    {
        //
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        $country = Country::all();
        return view("admin.city.create", compact("GeneralWebmasterSections", "country"));
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
            'country_id' => 'required|integer|exists:countries,id', // currency validation
            'title_*' => 'required|string|max:255', // validate for all language name fields
        ], [
            'country_id.required' => 'The country is required.',
            'country_id.integer' => 'The country must be a valid integer.',
            'country_id.exists' => 'The selected country is invalid.',
            'title_*.required' => 'The country name in all active languages is required.',
            'title_*.string' => 'The country name must be a valid string.',
            'title_*.max' => 'The country name may not be greater than 255 characters.'
        ]);

        $city = new City();
        foreach (Helper::languagesList() as $ActiveLanguage) {
            $city->{"title_" . $ActiveLanguage->code} = $request->{"title_" . $ActiveLanguage->code};
        }
        $city->country_id = $request->country_id;

        $city->save();
        return redirect()->route('city.index')->with('doneMessage', __('backend.addDone'));
    }

    public function edit($id)
    {
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        $city = City::find($id);
        $country = Country::all();

        return view("admin.city.edit", compact("country", "city", "GeneralWebmasterSections"));
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
            'country_id' => 'required|integer|exists:currencies,id', // currency validation
            'title_*' => 'required|string|max:255', // validate for all language title fields
        ], [
            'flag.image' => 'The flag must be an image.',
            'flag.mimes' => 'The flag must be a file of type: jpeg, png, jpg, gif.',
            'flag.max' => 'The flag may not be greater than 2MB.',
            'country_id.required' => 'The country is required.',
            'country_id.integer' => 'The country must be a valid integer.',
            'country_id.exists' => 'The selected country is invalid.',
            'title_*.required' => 'The country title in all active languages is required.',
            'title_*.string' => 'The country title must be a valid string.',
            'title_*.max' => 'The country title may not be greater than 255 characters.'
        ]);

        // Find the country by ID
        $city = City::find($id);
        if (!empty($city)) {

            foreach (Helper::languagesList() as $ActiveLanguage) {
                $city->{"title_" . $ActiveLanguage->code} = $request->{"title_" . $ActiveLanguage->code};
            }
            // Update the currency ID
            $city->country_id = $request->country_id;
            $city->save();

            return redirect()->route('city.index')
                ->with('doneMessage', __('backend.saveDone'));
        } else {
            // If country not found, redirect to the index page
            return redirect()->back();
        }
    }

    public function updateStatus($id)
    {
        $city = City::find($id);
        if ($city) {
            $city->status = $city->status == 0 ? 1 : 0;
            $city->save();
            return redirect()->back()->with(
                'doneMessage',
                __('backend.saveDone')
            );
        } else {
            // If city not found, redirect back with an error message
            return redirect()->back()->with(
                'errorMessage',
                __('backend.itemNotFound')
            );
        }
    }
}
