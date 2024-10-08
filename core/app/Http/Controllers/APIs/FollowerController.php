<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\Follower;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function getFollower($companyId)
    {
        // Fetch paginated followers for the specified company
        $followers = Follower::with('user')->where('company_id', $companyId)->latest()->paginate();
        // Check if the paginated result is empty
        if ($followers->isEmpty()) {
            return response()->json([
                'status' => 200, // Keep the status 200
                'message' => 'No followers for this Company', // Change message only
                'data' => $followers // Return the empty paginated result
            ], 200);
        }

        // Return the paginated followers
        return response()->json([
            'status' => 200,
            'message' => 'followers retrieved successfully',
            'data' => $followers
        ], 200);
    }
    public function storeFollower(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'company_id' => 'required|exists:companies,id',
        ]);

        try {
            $userId = auth()->user()->id;
            $companyId = $validatedData['company_id'];

            // Check if the user is already following the company
            $existingFollower = Follower::where('user_id', $userId)
                ->where('company_id', $companyId)
                ->first();

            if ($existingFollower) {
                // If user is already following, unfollow (delete the record)
                $existingFollower->delete();

                return response()->json([
                    'status' => 200,
                    'message' => 'You have un followed the company successfully',
                ], 200);
            }

            // If not following, create a new follower (follow)
            $follower = new Follower();
            $follower->user_id = $userId;
            $follower->company_id = $companyId;
            $follower->save();

            return response()->json([
                'status' => 200,
                'message' => 'You have followed the company successfully',
                'data' => $follower
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while processing the request',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
