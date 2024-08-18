<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\WebmasterSection;
use App\Services\CompanyService;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\TypeActivity;
use Illuminate\Support\Facades\Auth;

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
        return view('admin.companies.index',compact('company','GeneralWebmasterSections'));
    }
    public function create()
    {
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        $country = Country::all();
        $typeActivity = TypeActivity::all();
        return view('admin.companies.create',compact('GeneralWebmasterSections','country','typeActivity'));
    }


    public function store(Request $request)
    {
        $result = $this->CompanyService->storeCompany($request);
        return redirect()->route('company.index') ;
    }
    public function edit(Company $category)
    {
        // return view('dashboard.categories.create', ['type_page'=>'','data'=>$category]);
    }

    // public function updateStatus(Category $category)
    // {
    //     $result=$this->CategoryServices->updateStatus($category);
    //     return response()->json([
    //         'message' => $result,
    //         'status' => '200'
    //     ]);
    // }
}
