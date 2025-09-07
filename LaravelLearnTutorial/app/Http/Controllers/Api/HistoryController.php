<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Store history
     */
    public function store(Request $request)
    {
        //check if the product is already in user history
        $product = History::where([
            'product_id' => $request->product_id,
            'user_id' => $request->user()->id
        ])->first();

        if(!$product) {
            History::create([
                'product_id' => $request->product_id,
                'user_id' => $request->user()->id
            ]);

            //return the response
            return UserResource::make($request->user());
        }else {
            return UserResource::make($request->user());
        }
    }
}
