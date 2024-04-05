@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5">
                <div class="card p-5">
                    <ul class="">
                        <li>{{$payment->client_name}}</li>
                        <li>{{$payment->total_price}}</li>
                        <li>{{$payment->description}}</li>
                    </ul>
                </div>
            </div>
            
        </div>
    </div>
        
@endsection