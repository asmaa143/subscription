<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class BillingControlle extends Controller
{
   public function index(){

       $plans=Plan::all();


       return view('billing.index',compact('plans'));
   }
}
