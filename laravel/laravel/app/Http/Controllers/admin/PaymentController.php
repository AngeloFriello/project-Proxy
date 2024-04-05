<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentStoreRequest;
use App\Http\Requests\PaymentUpdateRequest;
use App\Models\Cart;
use App\Models\Payment;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $payments = null;
        if ($user) {
            $payments = Payment::where('user_id', $user->id)->paginate(10); // 10 è il numero di elementi per pagina
        }
        return view('admin.payment.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        return view('admin.payment.show', compact('payment'));
    }

    public function create()
    {
        return view('admin.payment.create');
    }

    public function store(PaymentStoreRequest $request)
    {

        $data = $request->validated();

        $userID = auth()->user()->id;

        $due_date = Carbon::now()->addMonth();

        $new_payment = Payment::create([
            'client_name' => $data['client_name'],
            'total_price' => $data['total_price'],
            'description' => $data['description'],
            'paid' => false,
            'due_date' => $due_date,
            'user_id' => $userID,
        ]);


        $payment_id = $new_payment->id;

        foreach ($data['product_name'] as $key => $productName) {
            // Verifica se il nome del prodotto è vuoto (potrebbe non essere necessario)
            if (!empty($productName)) {
                // Creazione di un nuovo oggetto Cart per ogni prodotto
                $cartData = [
                    'payment_id' => $payment_id, // Utilizza $payment->id anziché $product-id
                    'product_name' => $productName,
                    'quantity' => $data['quantity'][$key],
                    'product_price' => $data['product_price'][$key],
                ];
                // Salva il prodotto nel carrello
                Product::create($cartData);
            }
        }
        return redirect()->route('admin.payment.show', $new_payment->id);
    }

    public function edit(Payment $payment)
    {

        return view('admin.payment.edit', compact('payment'));
    }

    public function update(PaymentUpdateRequest $request, Payment $payment)
    {
        $payment = Payment::findOrFail($payment->id);

        // Ottieni i dati validati dal form
        $data = $request->validate($request->rules());
    
        // Elimina tutti i prodotti associati al pagamento
        $payment->product()->delete();
    
        // Aggiorna i dati del pagamento
        $payment->update([
            'client_name' => $data['client_name'],
            'description' => $data['description'],
            // 'total_price' => $data['total_price'],
        ]);
    
        // Aggiungi i nuovi prodotti associati al pagamento
        foreach ($data['product_name'] as $index => $productName) {
            $product = new Product([
                'product_name' => $productName,
                'quantity' => $data['quantity'][$index],
                'product_price' => $data['product_price'][$index],
            ]);
            $payment->product()->save($product);
        }
    
        return redirect()->route('admin.payment.show', $payment->id);
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('admin.payment.index');
    }
}
