<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class BillingControlle extends Controller
{
   public function index(){

       $plans=Plan::all();
       return view('billing.index',[
           'plans'=>$plans,
           'intent' => auth()->user()->createSetupIntent()
       ]);
   }

   public function store(Request $request){

       auth()->user()->newSubscription('cashier', $request->plan)
           ->create($request->paymentMethod);

       return true;

   }

   public function members(){

       return view('billing.members');
   }
    public function charge(){

        return view('billing.charge',[
            'intent' => auth()->user()->createSetupIntent()
        ]);

    }

    public function charge_store(Request $request){
        auth()->user()->invoiceFor('one time fee', 500);
        return true;
    }
}
