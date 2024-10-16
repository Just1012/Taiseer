<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\OtpAttempts;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use Redirect;
use Helper;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/admin';
    public function __construct()
    {
        $this->middleware('guest');
    }


    public function createOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => ['required', 'string', 'min:11', 'max:15', 'unique:users'],
        ]);

        if ($validator->fails()) {
            return apiResponse([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ]);
        }

        $otpCode = rand(1000, 9999);
        OtpAttempts::create([
            'phone_number' => $request->phone,
            'otp_code' => $otpCode,
            'is_successful' => false,
            'attempted_at' => now(),
        ]);

        $result = [
            'status' => 200,
            'message' => 'OTP sent successfully! Please verify using the OTP sent.',
        ];

        return apiResponse($result);
    }

    public function registerUser(Request $request)
    {
        // Step 1: Validate the request data
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'min:11', 'max:15', 'unique:users'],
            'otp' => ['required', 'string', 'size:4'],  // Adjust OTP length to 6 digits
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Step 2: Check if validation fails
        if ($validator->fails()) {
            return apiResponse([
                'status' => 422,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ]);
        }

        // Step 3: Verify OTP
        $otp = OtpAttempts::where('phone_number', $request->phone)->latest()->first();
        if (!$otp || $otp->otp_code != $request->otp) {
            return apiResponse([
                'status' => 422,
                'message' => 'Invalid OTP',
            ]);
        }

        // Mark the OTP as successful
        $otp->is_successful = true;
        $otp->save();

        // Step 4: Create the user after validation
        $fullName = $request->input('first_name') . ' ' . $request->input('last_name');
        $user = User::create([
            'name' => $fullName,
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => Hash::make($request->input('password')),
            'user_type' => 'customer',
            'permissions_id' => 3,  // Assign the default permission group
        ]);

        // Step 5: Return the successful registration response
        $result = [
            'status' => 200,
            'message' => 'User registered successfully!',
            'data' => $user,
        ];

        return apiResponse($result);
    }
}
