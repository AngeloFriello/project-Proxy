@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5">
                <span class="fs-1">{{$payment->total_price}}  €</span>
                <div class="my-5">
                    <h5>Status History</h5>
                    <hr>
                    <div>
                       <p>Rejected</p> 
                    </div>
                </div>
                <div class="my-5">
                    <h5>Payment Info</h4>
                        <hr>
                    <div class="grid p-5">
                        <div class="grid-item">
                            <h6>Nome CLiente</h6>
                            <p>{{$payment->client_name}}</p>
                        </div>
                        <div class="grid-item">
                            <h6>Prezzo Ordine</h6>
                            <p>{{$payment->total_price}}</p>
                        </div>
                        <div class="grid-item">
                            <h6>Descrizione del Pagmento</h6>
                            <p>{{$payment->description}}</p>
                        </div>
                        <div class="grid-item">
                            <h6>Data di scadenza</h6>
                            <p>{{$payment->due_date}}</p>
                        </div>
                        <div class="grid-item">
                            <h6>Stato del Pagamento</h6>
                            <p>{{$payment->status}}</p>
                        </div>
                        <div class="grid-item">
                            <h6>Nome CLiente</h6>
                            <p>{{$payment->client_name}}</p>
                        </div>
                        
                    </div>
                </div>
                <div>
                    <h5>Paymen method</h5>
                    <hr>
                    <div>
                        <p>Mastercard</p> 
                     </div>
                </div>
                <div class="my-5">
                    <h5>Products</h5>
                    <hr>
                    <div class="grid p-5">
                        @forEach($payment->products as $product)
                        <div class="grid-item">
                            <h6>Product Name</h6>
                            <p>{{$product->product_name}}</p>
                        </div>
                        <div class="grid-item">
                            <h6>Quantità Prodotto</h6>
                            <p>{{$product->quantity}}</p>
                        </div>
                        <div class="grid-item">
                            <h6>Prezzo Prodotto</h6>
                            <p>{{$product->product_price}}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                    
                    <div>
                        <button class="btn btn-primary"><a href="{{route('admin.payment.edit', $payment->id)}}" class="text-white">Edit</a></button>
                    </div>
                
            </div>
            
        </div>
    </div>
    <script>
        
    </script>
@endsection