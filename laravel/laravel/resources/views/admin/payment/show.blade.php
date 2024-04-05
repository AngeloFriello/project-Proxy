@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5">
                <div class="card p-5">
                    <ul class="">
                        <li>Nome Cliente : {{$payment->client_name}}</li>
                        <li>Prezzo Ordine : {{$payment->total_price}}</li>
                        <li>Descrizione del Pagmento : {{$payment->description}}</li>
                        <li>Data di scadenza : {{$payment->due_date}}</li>
                        <li>Stato del Pagamento : <span id="paymentStatus">{{$payment->paid}}</span></li>
                    </ul>
                    <div class="grid">
                        @forEach($payment->product as $product)
                            <ul class="card col-3 py-3 grid-item">
                                <li>Nome Prodotto : {{$product->product_name}}</li>
                                <li>Quantità Prodotto : {{$product->quantity}}</li>
                                <li>Prezzo Prodotto : {{$product->product_price}}</li>
                            </ul>
                        @endforeach
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <script>
        let paymentStatusElement = document.getElementById('paymentStatus');
        let paymentStatus = {!! json_encode($payment->paid) !!};

        if (paymentStatus) {
            paymentStatusElement.textContent = 'Pagato';
        } else {
            paymentStatusElement.textContent = 'Non pagato';
        }
    </script>
@endsection