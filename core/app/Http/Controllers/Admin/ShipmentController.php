<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use App\Models\ShipmentStatusHistory;
use App\Models\WebmasterSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShipmentController extends Controller
{
    public function index()
    {
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        if (@Auth::user()->permissionsGroup->view_status) {
            $shipment = Shipment::with(['company', 'user', 'addressTo.country', 'addressFrom.country', 'addressTo.city', 'addressFrom.city'])->where('created_by', '=', Auth::user()->id)
                ->paginate(config('smartend.backend_pagination'));
        } else {
            $shipment = Shipment::with(['company', 'user', 'addressTo.country', 'addressFrom.country', 'addressTo.city', 'addressFrom.city'])->paginate(config('smartend.backend_pagination'));
        }
        // dd($shipment);
        return view('admin.shipment.index', compact('shipment', 'GeneralWebmasterSections'));
    }



    public function updateStatus(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'status' => 'required|in:new,accepted,in_transit,delivered,rejected,closed',
            'remarks' => 'nullable|string|max:255',
            'rejection_reason' => 'nullable|string|max:255',
        ]);

        try {
            // Start the transaction
            DB::beginTransaction();

            // Find the shipment by its ID
            $shipment = Shipment::findOrFail($id);

            // Update the shipment status
            $shipment->status = $request->input('status');
            // Update the rejection reason
            $shipment->rejection_reason = $request->input('reason');
            $shipment->save();

            // Record the status change in the ShipmentStatusHistory model
            $history = ShipmentStatusHistory::create([
                'shipment_id' => $shipment->id,
                'status' => $shipment->status,
                'changed_by' => auth()->user()->id, // Capture the user who made the change
                'changed_at' => now(), // Automatically set the timestamp of status change
                'remarks' => $shipment->rejection_reason, // Optional remarks
            ]);

            // Commit the transaction after both operations succeed
            DB::commit();

            // Set a session flash message for success
            session()->flash('status', 'success');
            session()->flash('message', 'Status Updated Successfully');

            // Return a success response
            return response()->json(['status' => 'success', 'message' => 'Status updated successfully.']);
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();

            // Set a session flash message for error
            session()->flash('status', 'error');
            session()->flash('message', 'حدث خطأ ما، يرجى إعادة المحاولة');

            // Return an error response with the exception message
            return response()->json(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
        }
    }
}
