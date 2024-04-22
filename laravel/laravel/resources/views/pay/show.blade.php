@extends('layouts.client')
@section('content')

    <div class="container mt-5 p-4 max-container">
        <div class="row">
            @if ($payment && $payment->active == 1 && $user && $payment->status != 'paid')
                <div>
                    @if ($user->image)
                        <img class="logo-pay" src="{{ $user->image }}" alt="Immagine del profilo">
                    @else
                        <img class="logo-pay" src="http://192.168.1.8:8000/immagine.png" alt="">
                    @endif
                </div>
                <div>
                    <span>{{ $user->company_name || $user->name }} sta richiedendo questo pagamento</span>
                </div>
                <div class="card p-3 shadow my-2 bg-viola">
                    <span>{{ $payment->description }}</span>
                </div>

                <div class="card p-3 shadow my-2 bg-viola">
                    <span>Data di scadenza:
                        {{ isset($payment->due_date) ? \Carbon\Carbon::parse($payment->due_date)->format('d/m/Y') : '∞' }}</span>
                </div>
                <div class="card p-3 shadow my-2 bg-viola">
                    <table class="table no-border">
                        <thead>
                            <tr class="bg-viola">
                                <th class="bg-viola">Descrizione prodotto/servizio</th>
                                <th class="d-flex bg-viola justify-content-end no-border">Prezzo €</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payment->products as $product)
                                <tr>
                                    <td scope="row">
                                        <div>
                                            {{ $product->quantity }} x <span
                                                class="fw-bold">{{ $product->product_name }}</span>
                                        </div>
                                        <div class="fs-10">unity price : <span
                                                class="fw-bold">{{ number_format($product->product_price, 2, ',', '.') }}</span>
                                        </div>
                                    </td>
                                    <td class="d-flex  justify-content-end fw-bold">
                                        {{ number_format($product->product_price * $product->quantity, 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card d-flex justify-content-between flex-row px-4 py-2 bg-purple">
                    <span>Totale €: </span>
                    <span class="fw-bold">{{ $payment->total_price }}</span>
                </div>
                <div class="mt-2">
                    <input type="checkbox">
                    <label for="">Accetto le policy d'uso e privacy (click per info)</label>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="mt-5 d-flex justify-content-center">
                        <form action="{{ route('pay.checkout', $payment->id) }}" method="POST">
                            @csrf
                            @if ($settings['payMethods'][0]['active'] == 0)
                                <span class="btn btn-success paga">NESSUN METODO DI PAGAMENTO DISPONIBILE</span>
                            @else
                                <button class="btn btn-success paga" type="submit">PAGA ADESSO</button>
                            @endif
                        </form>


                    </div>
                </div>
            @else
                <div class="d-flex justify-content-center align-items-center">
                    <img class="logo-pay" src="http://192.168.1.8:8000/immagine.png" alt="">
                </div>
                <div class="card p-3 shadow my-2 bg-viola d-flex justify-content-center align-items-center">
                    <span>!! Attenzione Pagamento Non Presente !!</span>
                </div>
            @endif
        </div>
    </div>







@endsection
