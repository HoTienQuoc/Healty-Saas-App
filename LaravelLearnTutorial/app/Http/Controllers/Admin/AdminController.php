<?php

namespace App\Http\Controllers\Admin;

use App\Models\Plan;
use App\Models\User;
use App\Models\History;
use App\Models\Product;
use App\Models\Negative;
use App\Models\Positive;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthAdminRequest;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    //Admin dashboard
    public function index(){
        $negatives = Negative::all();
        $positives = Positive::all();
        $products = Product::all();
        $histories = History::all();
        $users = User::all();
        $plans = Plan::all();
        $subscriptions = Subscription::all();

        return view('admin.dashboard')->with([
            'Negatives' => $negatives,
            'Positives'=>$positives,
            'Products'=>$products,
            'History'=>$histories,
            'Users'=>$users,
            'Plans'=>$plans,
            'Subscriptions'=>$subscriptions,
        ]);
    }

    public function login(){
        if(auth()->guard('admin')->check()){
            return redirect()->route('admin.index');
        }
        return view('admin.login');
    }

    /**
     * Log in the admin function
     */
    public function auth(AuthAdminRequest $request){
        if($request->validated()){
            if(auth()->guard('admin')->attempt([
                'email' => $request->email,
                'password' => $request->password,
            ])){
                $request->session()->regenerate();
                return redirect()->route('admin.index');
            }
            else{
                throw ValidationException::withMessages([
                    'email' => 'These credentials do not match our records.'
                ]);
            }
        }
    }

    /**
     * Logout the admin
     */
    public function logout(){

    }
}
