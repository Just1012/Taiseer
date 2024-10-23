<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Exception;
use App\Services\CompanyService;


use Illuminate\Http\Request;

class CompanyController extends Controller
{
    protected $CompanyService;
    public function __construct(CompanyService $CompanyService)
    {
        $this->CompanyService = $CompanyService;
    }
    public function companyRegister(Request $request)
    {

        $result = $this->CompanyService->storeCompany($request);

          return apiResponse($result);
    }
    public function getCompanies(Request $request)
    {
        // Start building the query for fetching companies
        $query = Company::with(['typeActivityCompanies.typeActivities'])
            ->withCount('followers'); // This will add a followers_count column


        // Check if the filter parameter is passed in the request
        if ($request->has('filter') && $request->filter == 'top') {
            // Apply ordering by average rating (or similar criteria)
            $query->withAvg('rating', 'rate') // Get average rating in query
                ->orderBy('rating_avg_rate', 'desc'); // Order by top rating
        }

        // Paginate the results
        $companies = $query->paginate();

        // Modify the company data
        $companies->map(function ($company) {
            // Loop through each typeActivityCompany
            $company->typeActivityCompanies->map(function ($typeActivityCompany) {
                // If info_ar is empty, take it from typeActivities->info_ar
                if (empty($typeActivityCompany->info_ar)) {
                    $typeActivityCompany->info_ar = $typeActivityCompany->typeActivities->info_ar;
                }

                // If info_en is empty, take it from typeActivities->info_en
                if (empty($typeActivityCompany->info_en)) {
                    $typeActivityCompany->info_en = $typeActivityCompany->typeActivities->info_en;
                }

                return $typeActivityCompany;
            });

            // Calculate average rating
            if ($company->rating->isNotEmpty()) {
                $company->average_rating = $company->rating->avg('rate'); // Calculate the average
            } else {
                $company->average_rating = null; // No ratings, so set as null or 0
            }
            // Remove the rating attribute to skip it in the response
            unset($company->rating);

            return $company;
        });

        // Return the response
        return apiResponse([
            'status' => 200,
            'message' => 'Companies retrieved successfully.',
            'data' => $companies,
        ]);
    }

    public function getCompaniesDetails($id)
    {
        try {
            // Start building the query for fetching a specific company
            $query = Company::with(['typeActivityCompanies.typeActivities', 'rating.user'])
                ->withCount('followers') // Add a followers_count column
                ->where('id', $id); // Filter by the provided ID

            // Check if the filter parameter is passed in the request
            if (request()->has('filter') && request()->filter == 'top') {
                // Apply ordering by average rating (or similar criteria)
                $query->withAvg('rating', 'rate') // Get average rating in query
                    ->orderBy('rating_avg_rate', 'desc'); // Order by top rating
            }

            // Get the specific company
            $company = $query->first();

            // Check if the company is found
            if (!$company) {
                return apiResponse([
                    'status' => 404,
                    'message' => 'Company not found.',
                    'data' => null,
                ]);
            }

            // Modify the company data
            $company->typeActivityCompanies->map(function ($typeActivityCompany) {
                // If info_ar is empty, take it from typeActivities->info_ar
                if (empty($typeActivityCompany->info_ar)) {
                    $typeActivityCompany->info_ar = $typeActivityCompany->typeActivities->info_ar;
                }

                // If info_en is empty, take it from typeActivities->info_en
                if (empty($typeActivityCompany->info_en)) {
                    $typeActivityCompany->info_en = $typeActivityCompany->typeActivities->info_en;
                }

                return $typeActivityCompany;
            });

            // Calculate average rating
            if ($company->rating->isNotEmpty()) {
                $company->average_rating = $company->rating->avg('rate'); // Calculate the average
            } else {
                $company->average_rating = null; // No ratings, set as null or 0
            }

            // Return the response with the specific company details
            return apiResponse([
                'status' => 200,
                'message' => 'Company retrieved successfully.',
                'data' => $company,
            ]);
        } catch (Exception $e) {
            // Handle any unexpected errors
            return apiResponse([
                'status' => 500,
                'message' => 'An error occurred while retrieving the company.',
                'error' => $e->getMessage(),
            ]);
        }
    }
}
