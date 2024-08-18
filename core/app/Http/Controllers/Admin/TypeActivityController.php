<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Models\TypeActivity;
use Illuminate\Http\Request;
use App\Models\WebmasterSection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class TypeActivityController extends Controller
{
    private $uploadPath = "uploads/topics/";
    public function index()
    {
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        if (@Auth::user()->permissionsGroup->view_status) {
            $typeActivity = TypeActivity::where('created_by', '=', Auth::user()->id)->paginate(config('smartend.backend_pagination'));
        } else {
            $typeActivity = TypeActivity::paginate(config('smartend.backend_pagination'));
        }
        return view('admin.typeActivity.index', compact("typeActivity", "GeneralWebmasterSections"));
    }

    public function create()
    {
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        return view("admin.typeActivity.create", compact("GeneralWebmasterSections"));
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
            'name_*' => 'required|string|max:255', // validate for all language name fields
            'image_front' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // front image validation
            'image_back' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // back image validation
            'info_*' => 'required|string', // validate for all language info fields
        ], [
            'name_*.required' => 'The name in all active languages is required.',
            'name_*.string' => 'The name must be a valid string.',
            'name_*.max' => 'The name must not exceed 255 characters.',
            'image_front.image' => 'The front image must be an image file.',
            'image_back.image' => 'The back image must be an image file.',
            'info_*.required' => 'The information in all active languages is required.',
        ]);
        // Start of Upload Files
        $fileFrontName = '';
        if ($request->hasFile('image_front')) {
            $fileFrontName = time() . rand(1111, 9999) . '.' . $request->file('image_front')->getClientOriginalExtension();
            $path = $this->uploadPath;
            $request->file('image_front')->move($path, $fileFrontName);
            // Resize & optimize
            Helper::imageResize($path . $fileFrontName);
            Helper::imageOptimize($path . $fileFrontName);
        }
        $fileBackName = '';
        if ($request->hasFile('image_back')) {
            $fileBackName = time() . rand(1111, 9999) . '.' . $request->file('image_back')->getClientOriginalExtension();
            $path = $this->uploadPath;
            $request->file('image_back')->move($path, $fileBackName);
            // Resize & optimize
            Helper::imageResize($path . $fileBackName);
            Helper::imageOptimize($path . $fileBackName);
        }
        // Create new TypeActivity instance
        $typeActivity = new TypeActivity();

        foreach (Helper::languagesList() as $ActiveLanguage) {
            $typeActivity->{"name_" . $ActiveLanguage->code} = $request->{"name_" . $ActiveLanguage->code};
            $typeActivity->{"info_" . $ActiveLanguage->code} = $request->{"info_" . $ActiveLanguage->code};
        }
        // Save uploaded image paths if they exist
        if (!empty($fileFrontName)) {
            $typeActivity->image_front = $fileFrontName;
        }
        if (!empty($fileBackName)) {
            $typeActivity->image_back = $fileBackName;
        }
        // Save the activity type
        $typeActivity->save();
        return redirect()->route('typeActivity.index')->with('doneMessage', __('backend.addDone'));
    }

    public function edit($id)
    {
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        $typeActivity = TypeActivity::find($id);
        return view("admin.typeActivity.edit", compact("typeActivity", "GeneralWebmasterSections"));
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
            'name_*' => 'required|string|max:255', // validate for all language name fields
            'image_front' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // front image validation
            'image_back' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // back image validation
            'info_*' => 'required|string', // validate for all language info fields
        ], [
            'name_*.required' => 'The name in all active languages is required.',
            'name_*.string' => 'The name must be a valid string.',
            'name_*.max' => 'The name must not exceed 255 characters.',
            'image_front.image' => 'The front image must be an image file.',
            'image_back.image' => 'The back image must be an image file.',
            'info_*.required' => 'The information in all active languages is required.',
        ]);

        // Find the TypeActivity by ID
        $typeActivity = TypeActivity::find($id);
        if (!empty($typeActivity)) {
            // Handle Front Image Upload
            $fileFrontName = $typeActivity->image_front; // Keep current image if no new one is uploaded
            if ($request->hasFile('image_front')) {
                // Delete the existing front image if it exists
                if (!empty($typeActivity->image_front) && $typeActivity->image_front != "nav-bg.png") {
                    File::delete($this->uploadPath . $typeActivity->image_front);
                }

                // Save new front image
                $fileFrontName = time() . rand(1111, 9999) . '.' . $request->file('image_front')->getClientOriginalExtension();
                $path = $this->uploadPath;
                $request->file('image_front')->move($path, $fileFrontName);

                // Resize & optimize the new front image
                Helper::imageResize($path . $fileFrontName);
                Helper::imageOptimize($path . $fileFrontName);
            }

            // Handle Back Image Upload
            $fileBackName = $typeActivity->image_back; // Keep current image if no new one is uploaded
            if ($request->hasFile('image_back')) {
                // Delete the existing back image if it exists
                if (!empty($typeActivity->image_back) && $typeActivity->image_back != "nav-bg.png") {
                    File::delete($this->uploadPath . $typeActivity->image_back);
                }

                // Save new back image
                $fileBackName = time() . rand(1111, 9999) . '.' . $request->file('image_back')->getClientOriginalExtension();
                $request->file('image_back')->move($path, $fileBackName);

                // Resize & optimize the new back image
                Helper::imageResize($path . $fileBackName);
                Helper::imageOptimize($path . $fileBackName);
            }

            // If the image deletion flag is set, delete the existing front or back image
            if ($request->image_delete_front == 1) {
                if (!empty($typeActivity->image_front) && $typeActivity->image_front != "nav-bg.png") {
                    File::delete($this->uploadPath . $typeActivity->image_front);
                }
                $fileFrontName = ""; // Set to empty if the image is deleted
            }

            if ($request->image_delete_back == 1) {
                if (!empty($typeActivity->image_back) && $typeActivity->image_back != "nav-bg.png") {
                    File::delete($this->uploadPath . $typeActivity->image_back);
                }
                $fileBackName = ""; // Set to empty if the image is deleted
            }

            // Update the TypeActivity's name and info in all languages
            foreach (Helper::languagesList() as $ActiveLanguage) {
                $typeActivity->{"name_" . $ActiveLanguage->code} = $request->{"name_" . $ActiveLanguage->code};
                $typeActivity->{"info_" . $ActiveLanguage->code} = $request->{"info_" . $ActiveLanguage->code};
            }

            // Update the images and save
            $typeActivity->image_front = $fileFrontName;
            $typeActivity->image_back = $fileBackName;
            $typeActivity->save();

            return redirect()->route('typeActivity.index')
                ->with('doneMessage', __('backend.saveDone'));
        } else {
            // If TypeActivity not found, redirect to the index page
            return redirect()->route('typeActivity.index')
                ->with('errorMessage', __('backend.itemNotFound'));
        }
    }

    public function updateStatus($id)
    {
        // Find the TypeActivity by ID
        $typeActivity = TypeActivity::find($id);

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
