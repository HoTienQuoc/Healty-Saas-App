<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Get all the plans
     */
    public function index()
    {
        return response()->json([
            'plans' => Plan::all()
        ]);
    }
}
