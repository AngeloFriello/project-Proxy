@extends('layouts.app')
@section('content')
    <p>Gentile {{ $payment->user->name }},</p>
    <p>Il tuo pagamento di ${{ $payment->amount }} è stato confermato con successo.</p>
@endsection
