<?php

namespace App\Models;

use App\Helpers\Helper;
use App\Models\Shipment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $guarded = [];

    // One-to-many relationships
    public function typeActivityCompanies()
    {
        return $this->hasMany(TypeActivityCompany::class);
    }

    public function country()
    {
        return $this->hasMany(CompanyCountry::class);
    }

    public function city()
    {
        return $this->hasMany(CompanyCity::class);
    }

    public function followers()
    {
        return $this->hasMany(Follower::class);
    }

    public function rating()
    {
        return $this->hasMany(Rating::class);
    }
    // Many-to-many relationships
    public function countries()
    {
        return $this->belongsToMany(Country::class, 'company_countries', 'company_id', 'country_id');
    }

    public function cities()
    {
        return $this->belongsToMany(City::class, 'company_cities', 'company_id', 'city_id');
    }
    // Scopes
    public function relatedShipments(Request $request)
    {
        $typeActivityIds = $this->typeActivityCompanies->pluck('type_activity_id')
            ->map(fn($id) => (string) $id)
            ->toArray();

        $shipments = Shipment::where(function ($query) use ($typeActivityIds) {
            $query->where('shipment_type', 'specific')
                ->where('company_id', $this->id)
                ->orWhere(function ($q) use ($typeActivityIds) {
                    $q->where('shipment_type', 'general')
                        ->whereJsonContains('typeActivity_id', $typeActivityIds);
                });
        });

        $searchableColumns = ['receiver_phone', 'status', 'receiver_name'];
        Helper::searchInQuery($request,$searchableColumns,$shipments);

        return $shipments->paginate();
    }
}
