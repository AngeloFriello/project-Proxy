@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-6">
                <div class="card p-4  m-3 ">
                    <form action="{{ route('profile.stripe') }}" method="POST" id="stripeForm">
                        @csrf
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3>Stripe</h3>
                                <div class="form-check form-switch">
                                    <label class="form-check-label" for="flexSwitchCheckDefault">Enabled</label>
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        id="flexSwitchCheckDefault" value="1" name="active"
                                        @if ($settings['payMethods'][0]['active'] == 1) checked @endif>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-success mt-4" id="saveStripeBtn">Save</button>
                                </div>
                            </div>
                            <div>
                                <div class="">
                                    <label class="form-label" for="stripePublicKey">Stripe Public Key</label>
                                    <input class="form-control" type="text" id="stripePublicKey"
                                        value="{{ old('public_key', isset($settings['payMethods'][0]['publickey']) ? $settings['payMethods'][0]['publickey'] : '')}}"
                                        name="public_key">
                                </div>
                                <div class="">
                                    <label class="form-label" for="stripeSecretKey">Stripe Secret Key</label>
                                    <input class="form-control" type="text" id="stripeSecretKey"
                                        value="{{ old('private_key', isset($settings['payMethods'][0]['privateKey']) ? $settings['payMethods'][0]['privateKey'] : '')}}"
                                        name="private_key">
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="card p-4  m-3 ">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3>Pay Pal</h3>
                        <div class="form-check form-switch">
                            <label class="form-check-label" for="flexSwitchCheckDefault">Enabled</label>
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault"
                                value="1" name="active">
                        </div>
                    </div>
                </div>
                <div class="card p-4  m-3 ">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3>Sumup</h3>
                        <div class="form-check form-switch">
                            <label class="form-check-label" for="flexSwitchCheckDefault">Enabled</label>
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault"
                                value="1" name="active">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card p-4 m-3 ">
                    <div class="m-3">
                        <h3>Settings</h3>
                    </div>
                    <form action="{{ route('profile.updateSettings') }}" method="POST">
                        @csrf
                        <div class=" m-3 d-flex justify-content-between">
                            <label class="col-md-6" for="orderBy">Order By : </label>
                            <select class="form-select" id="orderBy" name="orderBy">
                                <option value="client_name" {{ $orderByValue == 'client_name' ? 'selected' : ''}}>Order For Name</option>
                                <option value="due_date" {{ $orderByValue == 'due_date' ? 'selected' : '' }}>Order For Due Date</option>
                                <option value="created_at" {{ $orderByValue == 'created_at' ? 'selected' : '' }}>Order For Creation Date</option>                
                                <option value="active" {{ $orderByValue == 'active' ? 'selected' : '' }}>Order For Active</option>            
                                <option value="status" {{ $orderByValue == 'status' ? 'selected' : '' }}>Order For Status</option>                    
                                <option value="total_price" {{ $orderByValue == 'total_price' ? 'selected' : '' }}>Order For Total Price</option>              
                            </select>
                        </div>
                        <div class=" m-3 d-flex justify-content-between">
                            <label class="col-md-6" for="orderFor">Order For</label>
                            <select class="form-select" id="orderFor" name="orderFor">
                                <option value="asc" {{ $settings['orderFor'] == 'asc' ? 'selected' : '' }}>Order For ASC</option>
                                <option value="desc" {{ $settings['orderFor'] == 'desc' ? 'selected' : '' }}>Order For DSC</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-between m-3">
                            <label class="col-md-6" for="perPage">Payments For Page : </label>
                            <select  id="perPage" class="form-select" name="perPage">
                                <option value="10" {{ $settings['perPage'] == '10' ? 'selected' : '' }}>10</option>
                                <option value="20" {{ $settings['perPage'] == '20' ? 'selected' : '' }}>20</option>
                                <option value="50" {{ $settings['perPage'] == '50' ? 'selected' : '' }}>50</option>
                            </select>
                        </div>
                        
                        <div>
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
