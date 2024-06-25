<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Inertia\Inertia;
use App\Models\User;

class OrderController extends Controller
{
    public function index()
    {
        $response = User::all();
        return Inertia::render('User/Index', ['orders' => $response]);
    }

    public function update(Request $request, User $order)
    {
        $order->update($request->all());
        return redirect()->route('orders.index')->with('success', 'Order updated successfully');
    }
}
