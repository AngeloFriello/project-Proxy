<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller

{
    public function index(){

    }
    
    public function test_api(){
        return response()->json(['message' => 'Prodotto eliminato con successo'], 200);
    }

    public function destroy($id)
    {
        $cart = Cart::find($id);
    
        // if (!$cart) {
        //     return response()->json(['message' => 'Il prodotto non è stato trovato'], 404);
        // }
    
        $cart->delete();
    
        return response()->json(['message' => 'Prodotto eliminato con successo'], 200);
    }
}
?>