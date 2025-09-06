<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Negative;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddNegativeRequest;
use App\Http\Requests\UpdateNegativeRequest;

class NegativeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('admin.negatives.index')->with([
            'negatives' => Negative::with(['product'])->latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $products = Product::all();
        return view('admin.negatives.create')->with([
            'products' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddNegativeRequest $request)
    {
        //
        if($request->validated()) {
            Negative::create($request->validated());
            return redirect()->route('admin.negatives.index')->with([
                'success' => 'Negative added successfully'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Negative $negative)
    {
        //
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Negative $negative)
    {
        //
        $products = Product::all();
        return view('admin.negatives.edit')->with([
            'products' => $products,
            'negative' => $negative
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNegativeRequest $request, Negative $negative)
    {
        //
        if($request->validated()) {
            $negative->update($request->validated());
            return redirect()->route('admin.negatives.index')->with([
                'success' => 'Negative updated successfully'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Negative $negative)
    {
        //
        $negative->delete();
        return redirect()->route('admin.negatives.index')->with([
            'success' => 'Negative deleted successfully'
        ]);
    }
}
