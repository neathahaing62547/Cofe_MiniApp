<?php

namespace App\Http\Controllers;

use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest('customer_id')->get();
        return view('dashboard.customer', compact('customers'));
    }
}
