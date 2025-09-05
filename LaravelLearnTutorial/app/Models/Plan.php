<?php

namespace App\Models;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    //
    protected $fillable = ['name','number_of_hearts','price','price_id'];

    public function subscriptions(){
        return $this->hasMany(Subscription::class);
    }
}
