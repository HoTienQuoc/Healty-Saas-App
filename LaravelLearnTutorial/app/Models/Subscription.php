<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\User;
use App\Models\Negative;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    //
    protected $fillable = [
        'stripe_subscription_id',
        'stripe_status',
        'stripe_plan_id',
        'current_period_start',
        'current_period_end',
        'plan_id',
        'user_id'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'current_period_start' => 'datetime',
            'current_period_end' => 'datetime',
        ];
    }

    public function plan(){
        return $this->belongsTo(Plan::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getCurrentPeriodStartAttribute($value){
        return Carbon::parse($value)->format("Y-m-d h:s:i") ;
    }

    public function getCurrentPeriodEndAttribute($value){
        return Carbon::parse($value)->format("Y-m-d h:s:i") ;
    }

}
