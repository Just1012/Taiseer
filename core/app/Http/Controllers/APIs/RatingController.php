<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Auth;

class RatingController extends Controller
{
    public function getRating(Request $request)
    {
        try {
            // Validate that either company_id or shipment_id is provided, and both must exist if given
            $request->validate([
                'company_id' => 'nullable|exists:companies,id', // company_id is optional
                'shipment_id' => 'nullable|exists:shipments,id', // shipment_id is optional
            ]);

            // Fetch the company_id and shipment_id from the request
            $companyId = $request->company_id;
            $shipmentId = $request->shipment_id;

            // Initialize the query for ratings
            $query = Rating::query();

            // Add condition for company_id if provided
            if ($companyId) {
                $query->where('company_id', $companyId);
            }

            // Add condition for shipment_id if provided
            if ($shipmentId) {
                $query->where('shipment_id', $shipmentId);
            }

            // If neither company_id nor shipment_id is provided, return a validation error
            if (!$companyId && !$shipmentId) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Either company_id or shipment_id must be provided.',
                ], 400);
            }

            // Fetch the paginated results
            $ratings = $query->latest()->paginate();

            // Check if the paginated result is empty
            if ($ratings->isEmpty()) {
                return response()->json([
                    'status' => 200, // Keep the status 200
                    'message' => 'No Ratings found', // Change message only
                    'data' => $ratings, // Return the empty paginated result
                ], 200);
            }

            // Return the paginated ratings
            return response()->json([
                'status' => 200,
                'message' => 'Ratings retrieved successfully',
                'data' => $ratings,
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation error
            return response()->json([
                'status' => 400,
                'message' => 'Validation error',
                'errors' => $e->errors(), // Return validation errors
            ], 400);
        }
    }
    public function storeRating(Request $request)
    {
        $validatedData = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'shipment_id' => 'required|exists:shipments,id',
            'rate' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        try {

            $shipment = Shipment::findOrFail($validatedData['shipment_id']);
            if ($shipment->user_id == Auth::user()->id) {
                $shipment->rating = $validatedData['rate'];
                $shipment->save();

                $rating = new Rating();
                $rating->user_id = auth()->user()->id;
                $rating->company_id = $validatedData['company_id'];
                $rating->shipment_id = $validatedData['shipment_id'];
                $rating->rate = $validatedData['rate'];
                $rating->comment = $validatedData['comment'] ?? null;
                $rating->save();

                return response()->json([
                    'status' => 200,
                    'message' => 'Rating stored successfully',
                    'data' => $rating
                ], 200);
            }else{
                return response()->json([
                    'status' => 403,
                    'message' => 'Not Your Shipping',
                ], 403);
            }
        } catch (\Exception $e) {

            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while storing the rating',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
