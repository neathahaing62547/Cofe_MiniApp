<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\Report;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addtocart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
            'customer_name' => 'required|string|max:100',
            'product_name' => 'required|string|max:100',
        ]);

        Cart::create([
            'product_id' => $request->product_id,
            'product_name' => $request->product_name,
            'customer_name' => $request->customer_name,
            'quantity' => $request->quantity,
            'total_price' => $request->price * $request->quantity,
        ]);

        return redirect()->route('order_page')
            ->with('success', 'Product added to cart successfully.');
    }

    public function showcart()
    {
        $carts = Cart::all();
        return view('cart', compact('carts'));
    }

    public function remove($id)
    {
        $remove = Cart::findOrFail($id);
        $remove->delete();

        return redirect()->route('showcart')->with('success', 'Product removed from cart successfully.');
    }

    public function payment()
    {
        $carts = Cart::all();
        if ($carts->isEmpty()) {
            return redirect()->route('showcart')->with('error', 'Cart is empty.');
        }
        $totalAmount = $carts->sum('total_price');
        $receiptNo =  'ATRS' .  $carts->sum('total_price') . time(); 
        $customerName = $carts->first()->customer_name;
        $grandTotal = $totalAmount + ($totalAmount * 0.10);

        foreach ($carts as $cart) {
            Report::create([
                'receipt_no' => $receiptNo,
                'customer_name' => $cart->customer_name,
                'product_id' => $cart->product_id,
                'product_name' => $cart->product_name,
                'quantity' => $cart->quantity,
                'product_amount' => $cart->total_price,
                'tax_amount' => $cart->total_price * 0.10,
                'total_amount' => $cart->total_price,
                'grand_total_amount' => $cart->total_price + ($cart->total_price * 0.10),
                'payment_method' => 'Cash',
                'status' => 'Paid',
                'receipt_date' => now(),
            ]);
        }
        Customer::create([
            'customer_name' => $customerName,
            'total_orders' => 1,
            'total_spent' => $grandTotal,
            'last_order_at' => now(),
        ]);

        Cart::truncate();
        return redirect()->route('order_page')->with('success', 'Payment successful and report generated.');
    }
}
