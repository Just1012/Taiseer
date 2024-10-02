<?php

namespace App\Http\Controllers\APIs;

use App\Models\Address;
use App\Models\Shipment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Payments\PaymentFactory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ShipmentController extends Controller
{
    public function storeShipment(Request $request)
    {
        // Begin a database transaction
        DB::beginTransaction();
        try {
            $validatedData = $request->validate([
                'company_id' => 'nullable|exists:companies,id',
                'shipment_type' => 'required|in:specific,general',
                'content_description' => 'required|string|max:255',
                'expected_delivery_date' => 'required|date',

                'from_address_line' => 'required|string|max:255',
                'from_country_id' => 'required|exists:countries,id',
                'from_city_id' => 'required|exists:cities,id',
                'from_area' => 'nullable|string|max:255',
                'from_latitude' => 'required|numeric|between:-90,90',
                'from_longitude' => 'required|numeric|between:-180,180',

                'to_address_line' => 'required|string|max:255',
                'to_country_id' => 'required|exists:countries,id',
                'to_city_id' => 'required|exists:cities,id',
                'to_area' => 'nullable|string|max:255',
                'to_latitude' => 'required|numeric|between:-90,90',
                'to_longitude' => 'required|numeric|between:-180,180',

                'receiver_name' => 'required|string|max:255',
                'receiver_phone' => 'required|string|max:20',
                'payment_method' => 'required|in:cash,online',
                'amount' => 'required|numeric|min:0',
            ], [
                // Custom error messages for company_id
                'company_id.exists' => 'The selected company does not exist.',

                // Custom error messages for shipment_type
                'shipment_type.required' => 'Please specify the shipment type.',
                'shipment_type.in' => 'The shipment type must be either specific or general.',

                // Custom error messages for content_description
                'content_description.required' => 'Please provide a description of the shipment content.',
                'content_description.max' => 'The content description cannot exceed 255 characters.',

                // Custom error messages for expected_delivery_date
                'expected_delivery_date.required' => 'Please provide the expected delivery date.',
                'expected_delivery_date.date' => 'Please provide a valid date for the expected delivery date.',

                // Custom error messages for from_address_line
                'from_address_line.required' => 'Please provide the sender\'s address line.',
                'from_address_line.max' => 'The sender\'s address line may not exceed 255 characters.',

                // Custom error messages for from_country_id
                'from_country_id.required' => 'Please select the sender\'s country.',
                'from_country_id.exists' => 'The selected sender\'s country is invalid.',

                // Custom error messages for from_city_id
                'from_city_id.required' => 'Please select the sender\'s city.',
                'from_city_id.exists' => 'The selected sender\'s city is invalid.',

                // Custom error messages for from_latitude
                'from_latitude.required' => 'Please provide the latitude of the sender\'s location.',
                'from_latitude.numeric' => 'The latitude must be a valid number.',
                'from_latitude.between' => 'The latitude must be between -90 and 90 degrees.',

                // Custom error messages for from_longitude
                'from_longitude.required' => 'Please provide the longitude of the sender\'s location.',
                'from_longitude.numeric' => 'The longitude must be a valid number.',
                'from_longitude.between' => 'The longitude must be between -180 and 180 degrees.',

                // Custom error messages for to_address_line
                'to_address_line.required' => 'Please provide the receiver\'s address line.',
                'to_address_line.max' => 'The receiver\'s address line may not exceed 255 characters.',

                // Custom error messages for to_country_id
                'to_country_id.required' => 'Please select the receiver\'s country.',
                'to_country_id.exists' => 'The selected receiver\'s country is invalid.',

                // Custom error messages for to_city_id
                'to_city_id.required' => 'Please select the receiver\'s city.',
                'to_city_id.exists' => 'The selected receiver\'s city is invalid.',

                // Custom error messages for to_latitude
                'to_latitude.required' => 'Please provide the latitude of the receiver\'s location.',
                'to_latitude.numeric' => 'The latitude must be a valid number.',
                'to_latitude.between' => 'The latitude must be between -90 and 90 degrees.',

                // Custom error messages for to_longitude
                'to_longitude.required' => 'Please provide the longitude of the receiver\'s location.',
                'to_longitude.numeric' => 'The longitude must be a valid number.',
                'to_longitude.between' => 'The longitude must be between -180 and 180 degrees.',

                // Custom error messages for receiver_name
                'receiver_name.required' => 'Please provide the receiver\'s name.',
                'receiver_name.max' => 'The receiver\'s name may not exceed 255 characters.',

                // Custom error messages for receiver_phone
                'receiver_phone.required' => 'Please provide the receiver\'s phone number.',
                'receiver_phone.max' => 'The receiver\'s phone number may not exceed 20 characters.',

                // Custom error messages for payment_method
                'payment_method.required' => 'Please select a payment method.',
                'payment_method.in' => 'The payment method must be either cash or online.',

                // Custom error messages for amount
                'amount.required' => 'Please specify the payment amount.',
                'amount.numeric' => 'The payment amount must be a valid number.',
                'amount.min' => 'The payment amount must be at least 0.',
            ]);

            // Create the 'from' and 'to' addresses
            $fromAddress = Address::create([
                'user_id' => auth()->user()->id,
                'address_line' => $validatedData['from_address_line'],
                'country_id' => $validatedData['from_country_id'],
                'city_id' => $validatedData['from_city_id'],
                'area' => $validatedData['from_area'],
                'latitude' => $validatedData['from_latitude'],
                'longitude' => $validatedData['from_longitude'],
            ]);

            $toAddress = Address::create([
                'user_id' => auth()->user()->id,
                'address_line' => $validatedData['to_address_line'],
                'country_id' => $validatedData['to_country_id'],
                'city_id' => $validatedData['to_city_id'],
                'area' => $validatedData['to_area'],
                'latitude' => $validatedData['to_latitude'],
                'longitude' => $validatedData['to_longitude'],
            ]);

            // Generate a unique tracking number
            $trackingNumber = 'TRK-' . strtoupper(uniqid());

            // Create the shipment
            $shipment = Shipment::create([
                'user_id' => auth()->user()->id,
                'company_id' => $validatedData['company_id'] ?? null,
                'shipment_type' => $validatedData['shipment_type'],
                'content_description' => $validatedData['content_description'],
                'expected_delivery_date' => $validatedData['expected_delivery_date'],
                'from_address_id' => $fromAddress->id,
                'to_address_id' => $toAddress->id,
                'receiver_name' => $validatedData['receiver_name'],
                'receiver_phone' => $validatedData['receiver_phone'],
                'status' => 'new',
                'payment_method' => $validatedData['payment_method'],
                'tracking_number' => $trackingNumber,
            ]);

            // Process the payment using the PaymentFactory
            $payment = PaymentFactory::initialize(
                $validatedData['payment_method'],
                $validatedData['amount'],
                $shipment,
                auth()->user()->id,  // Pass the user_id
                $validatedData['payment_method']  // Pass the payment method
            );
            $paymentResult = $payment->pay();

            // Commit the transaction
            DB::commit();

            // Return a success response
            return response()->json([
                'message' => 'Shipment created and payment processed successfully',
                'shipment' => $shipment,
                // 'transaction' => $transaction,
                'payment_message' => $paymentResult
            ], 201);
        } catch (\Exception $e) {
            // If any error occurs, rollback the entire transaction
            DB::rollBack();

            // Return an error response
            return response()->json([
                'status' => 'error',
                'message' => 'Transaction failed: ' . $e->getMessage(),
            ], 400);
        }
    }
}


// {
//     "company_id": 1,
//     "shipment_type": "specific",
//     "content_description": "Electronic gadgets and accessories",
//     "expected_delivery_date": "2024-10-15",

//     "from_address_line": "123 Main Street",
//     "from_country_id": 1,
//     "from_city_id": 10,
//     "from_area": "Downtown",
//     "from_latitude": 40.712776,
//     "from_longitude": -74.005974,

//     "to_address_line": "456 Another Street",
//     "to_country_id": 2,
//     "to_city_id": 20,
//     "to_area": "Suburbs",
//     "to_latitude": 34.052235,
//     "to_longitude": -118.243683,

//     "receiver_name": "John Doe",
//     "receiver_phone": "+1234567890",
//     "payment_method": "cash"
//     "amount": 150.00
// }
