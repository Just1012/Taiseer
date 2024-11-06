<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Builder;

class Shipment extends Model
{

    protected $casts = [
        'typeActivity_id' => 'array', // Automatically cast to array
    ];


    use HasFactory;
    protected $guarded = [];
    // protected static function booted()
    // {
    //     static::addGlobalScope('companies_data_filter', function ($query) {
    //         $user = Auth::user();
    //         if ($user && $user->user_type === 'company_user') {
    //             // Filter for non-wholesale customers and allow `company_id` to be `null`
    //             $query->where(function ($q) use ($user) {
    //                 $q->where('company_id', $user->company_id)
    //                     ->orWhereNull('company_id')->where;
    //             });
    //         }
    //     });
    // }

    protected static function booted()
    {
        static::addGlobalScope('companies_data_filter', function ($query) {
            $user = Auth::user();

            // Apply the filter only if the user is a company user
            if ($user && $user->user_type === 'company_user') {
                $companyId = $user->company_id;

                // Retrieve the type activity IDs for the company
                $company = Company::with('typeActivityCompanies.typeActivities')
                    ->find($companyId);

                // If the company exists, proceed with filtering
                if ($company) {
                    $typeActivityIds = $company->typeActivityCompanies
                        ->pluck('type_activity_id')
                        ->map(fn($id) => (string) $id)
                        ->toArray();

                    // Apply the filtering for specific and general shipments
                    $query->where(function ($query) use ($companyId) {
                        $query->where('shipment_type', 'specific')
                            ->where('company_id', $companyId);
                    })
                        ->orWhere(function ($query) use ($typeActivityIds) {
                            $query->where('shipment_type', 'general')
                                ->whereJsonContains('typeActivity_id', $typeActivityIds);
                        });
                }
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function addressTo()
    {
        return $this->belongsTo(Address::class, 'to_address_id');
    }
    public function addressFrom()
    {
        return $this->belongsTo(Address::class, 'from_address_id');
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
    public function shipmentImage()
    {
        return $this->hasMany(ShipmentImage::class);
    }
}
