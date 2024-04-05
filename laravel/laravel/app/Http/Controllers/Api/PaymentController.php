<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentStoreRequest;
use App\Http\Requests\PaymentUpdateRequest;
use App\Models\Cart;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller

{
    public function index(){

    }
    
    public function delete($id)
    {
        $cart = Cart::find($id);

        if (!$cart) {
            return response()->json(['message' => 'Carrello non trovato'], 404);
        }

        $cart->destroy();

        return response()->json(['message' => 'Carrello eliminato con successo'], 200);
    }
}
?>