@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">client name</th>
                    <th scope="col">Price</th>
                    <th scope="col">description</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                 @foreach($payments as $payment)
                  <tr>
                    <th scope="row">1</th>
                    <td><a href="{{route('admin.payment.show', $payment->id)}}">{{$payment->client_name}}</a></td>
                    <td>{{$payment->total_price}}</td>
                    <td>{{$payment->description}}</td>
                    <td><a class="btn btn-primary" href="{{route('admin.payment.edit', $payment->id)}}">edit</a></td>
                    <td>
                        <form class="margin-left-auto form-delete" action="{{route('admin.payment.destroy', $payment->id)}}" method="POST" data-delete-name="{{$payment->client_name}}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger w-100 form-delete-btn">Delete</button>
                        </form>
                    </td>
                 
                  </tr>
                  @endforeach
                </tbody>
              </table>

              <div>
              
                <a href="{{route('admin.payment.create')}}" class="btn btn-primary">crea un nuovo pagamento</a>
            </div>
        </div>
    </div>
@endsection

<script>
  
</script>