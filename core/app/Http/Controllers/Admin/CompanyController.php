<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\WebmasterSection;
use App\Services\CompanyService;
use App\Http\Controllers\Controller;
use App\Models\CompanyStatus;
use App\Models\Country;
use App\Models\TypeActivity;
use Illuminate\Support\Facades\Auth;

use function PHPSTORM_META\type;

class CompanyController extends Controller
{
    protected $CompanyService;

    public function __construct(CompanyService $CompanyService)
    {
        $this->CompanyService = $CompanyService;
    }

    public function index()
    {
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        if (@Auth::user()->permissionsGroup->view_status) {
            $company = Company::where('created_by', '=', Auth::user()->id)->paginate(config('smartend.backend_pagination'));
        } else {
            $company = Company::paginate(config('smartend.backend_pagination'));
        }
        return view('admin.companies.index', compact('company', 'GeneralWebmasterSections'));
    }
    public function create()
    {
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        $country = Country::all();
        $typeActivity = TypeActivity::all();
        return view('admin.companies.create', compact('GeneralWebmasterSections', 'country', 'typeActivity'));
    }


    public function store(Request $request)
    {
        $result = $this->CompanyService->storeCompany($request);
        return redirect()->route('company.index');
    }
    public function edit(Company $company, $id)
    {
        $company = $company::find($id);

        $type = $company->typeActivityCompanies;
        $countries = $company->country;
        foreach ($type as $value) {
            $value->placeholder_ar    = $value->typeActivities->info_ar;
            $value->placeholder_en   = $value->typeActivities->info_en;
        }

        $country = Country::all();
        $typeActivity = TypeActivity::all();
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        return view('admin.companies.edit', compact('company', 'country', 'typeActivity', 'GeneralWebmasterSections', 'type', 'countries'));
    }

    public function update(Request $request, $id)
{
    // Call the updateCompany method and pass the request and the company ID
    $result = $this->CompanyService->updateCompany($request, $id);

    // Redirect to the company index route with a success message
    return redirect()->route('company.index')->with('success', 'Company updated successfully!');
}




    public function updateStatus(Request $request, $id)
    {
        try {
            // Find the company by ID
            $company = Company::findOrFail($id);

            // Update the status
            $company->company_status_id = $request->input('status');
            // Save the changes to the database
            $company->save();

            // Retrieve the appropriate status message based on the status ID
            $statusMessage = CompanyStatus::where('id', $company->company_status_id)->first();

            // Get the current locale
            $locale = app()->getLocale();

            // If no message is found, fall back to defaults
            if ($statusMessage) {
                // Check if the locale is Arabic and return the correct message
                $message = ($locale == 'ar') ? $statusMessage->name_ar : $statusMessage->name_en;
            } else {
                // Default message if no status found
                $message = "حالة غير معروفة";
            }

            // Set a session flash message for success
            session()->flash('status', 'success');
            session()->flash('message', $message);

            // Redirect back to the previous page
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            // Set a session flash message for error
            session()->flash('status', 'error');
            session()->flash('message', 'حدث خطأ ما، يرجى إعادة المحاولة');

            // Return an error response
            return response()->json(['status' => 'error']);
        }
    }
}
