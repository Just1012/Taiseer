<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\WebmasterSection;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Support\Facades\Auth;

class CurrencyController extends Controller
{
    private $uploadPath = "uploads/topics/";
    public function index()
    {
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        if (@Auth::user()->permissionsGroup->view_status) {
            $currency = Currency::where('created_by', '=', Auth::user()->id)->paginate(config('smartend.backend_pagination'));
        } else {
            $currency = Currency::paginate(config('smartend.backend_pagination'));
        }
        return view('admin.currency.index', compact("currency", "GeneralWebmasterSections"));
    }

    public function create()
    {
        //
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        return view("admin.currency.create", compact("GeneralWebmasterSections"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:10',
        ], [
            'name.required' => 'The currency name is required.',
            'name.string' => 'The currency name must be a valid string.',
            'name.max' => 'The currency name must not exceed 255 characters.',

            'symbol.required' => 'The currency symbol is required.',
            'symbol.string' => 'The currency symbol must be a valid string.',
            'symbol.max' => 'The currency symbol must not exceed 10 characters.',
        ]);
        $currency = new Currency();
        $currency->name = $request->name;
        $currency->symbol = $request->symbol;
        $currency->save();
        return redirect()->route('currency.index')->with('doneMessage', __('backend.addDone'));
    }

    public function edit($id)
    {
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        $currency = Currency::find($id);
        return view("admin.currency.edit", compact("currency", "GeneralWebmasterSections"));
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
        $request->validate([
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:10',
        ], [
            'name.required' => 'The currency name is required.',
            'name.string' => 'The currency name must be a valid string.',
            'name.max' => 'The currency name must not exceed 255 characters.',

            'symbol.required' => 'The currency symbol is required.',
            'symbol.string' => 'The currency symbol must be a valid string.',
            'symbol.max' => 'The currency symbol must not exceed 10 characters.',
        ]);
        $currency = Currency::find($id);
        $currency->name = $request->name;
        $currency->symbol = $request->symbol;
        $currency->save();
        return redirect()->route('currency.index')->with(__('backend.saveDone'));
    }

    public function updateStatus($id)
    {
        // Find the TypeActivity by ID
        $typeActivity = Currency::find($id);

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
