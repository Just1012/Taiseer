<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Permissions extends Model
{
    use HasFactory;
    protected static function booted()
    {
        static::addGlobalScope('companies_data_filter', function ($query) {
            $user = Auth::user();
            if ($user && $user->user_type === 'company_user') {
                $query->where('company_id', $user->company_id)->orWhereNull('company_id');
            }
        });
    }

    public function users()
    {
        return $this->hasMany('App\Models\User', 'permissions_id');
    }

}
