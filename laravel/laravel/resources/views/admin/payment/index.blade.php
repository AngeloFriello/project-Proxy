@extends('layouts.app')

@section('content')
    <div class="container p-5">
        <div class="row">

            @if (session('error'))
                <div class="alert alert-danger d-flex justify-content-center">
                    {{ session('error') }}
                </div>
            @endif

            <div class="d-flex justify-content-between">
                <div class="d-flex">

                    @if ($user->image)
                        <img class="logo-pay mb-5" src="{{ Auth::user()->image }}" alt="Immagine del profilo">
                    @endif
                </div>
                <div>
                    <a href="{{ route('admin.payment.create') }}" class="btn btn-primary mb-3 ">+ New Payment</a>
                </div>
            </div>

            {{-- ricerca per nome /attivo e paginazione  --}}

            <form id="form" name="form" action="{{ route('admin.payment.index') }}" method="GET"
                class=" shadow search p-3">

                <div class="d-flex justify-content-between align-items-center">
                    <div class="input-group m-3">
                        <label for="keyword" class="form-label mx-3">Search</label>
                        <input type="text" class="form-control" placeholder="Search Payments..." id="keyword"
                            name="keyword" value="{{ request()->query('keyword') }}">
                    </div>
                    <div class="input-group m-3 ">
                        <label for="active" class="form_label mx-3">Status </label>
                        @php
                            $allSelected = request()->query('active') === null;
                        @endphp

                        <select class="form-select" aria-label="Default select example" id="active" name="active">
                            <option value="" {{ $allSelected ? 'selected' : '' }}>Tutti</option>
                            <option value="1" {{ !$allSelected && request()->query('active') == 1 ? 'selected' : '' }}>
                                Enabled</option>
                            <option value="0" {{ !$allSelected && request()->query('active') == 0 ? 'selected' : '' }}>
                                Disabled</option>
                        </select>
                        <input type="hidden" name="perPage"
                            value="{{ request()->query('perPage', session('perPage', 10)) }}">

                    </div>
                    <div class="input-group m-3">
                        <label for="perPage" class="form-label mx-3">Rows for Page:</label>
                        <select class="form-select" id="perPage" name="perPage">
                            <option value="10" {{ $settings['perPage'] == 10 ? 'selected' : '' }}>10</option>
                            <option value="20" {{ $settings['perPage'] == 20 ? 'selected' : '' }}>20</option>
                            <option value="50" {{ $settings['perPage'] == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </div>
                    <div class="d-flex">
                        <button class="btn btn-success mx-2" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ route('admin.payment.index') }}" class="btn btn-danger mx-2" id="resetFilter">
                            <i class="fas fa-times-circle"></i>
                        </a>
                    </div>
                </div>
            </form>



            <div class="pagination d-flex justify-content-between p-1 align-items-center shadow search my-4 ">
                <div class="d-flex gap-2">
                    <div>
                        @if ($payments->currentPage() > 1)
                            <a class="btn btn-primary bh d-flex align-items-center" href="{{ url()->current() }}?page=1"
                                class="pagination-link">
                                <i class="fas fa-chevron-left"></i><i class="fas fa-chevron-left"></i> </a>
                        @endif
                    </div>
                    <div>
                        @if ($payments->currentPage() > 1)
                            <a class="btn btn-secondary bh d-flex align-items-center"
                                href="{{ $payments->appends(request()->query())->previousPageUrl() }}"
                                class="pagination-link">&laquo; Previous</a>
                        @endif
                    </div>
                </div>
                <div>
                    <span>Current Page</span>
                    <span class="font-weight-bold">{{ $payments->currentPage() }}</span> /
                    <span class="font-weight-bold">{{ $payments->lastPage() }}</span>
                    <span class="mx-4">Total results : {{ $payments->total() }}</span>
                </div>

                <div class="d-flex gap-2">
                    <div>
                        @if ($payments->hasMorePages())
                            <a class="btn btn-secondary bh d-flex align-items-center"
                                href="{{ $payments->appends(request()->query())->nextPageUrl() }}"
                                class="pagination-link">Next &raquo;</a>
                        @endif
                    </div>
                    <div class="">
                        @if ($payments->currentPage() == $payments->lastPage())
                        @else
                            <a class="btn btn-primary  bh d-flex align-items-center"
                                href="{{ url()->current() }}?page={{ $payments->lastPage() }}" class="pagination-link"><i
                                    class="fas fa-chevron-right"></i><i class="fas fa-chevron-right"></i></a>
                        @endif
                    </div>
                </div>

            </div>
            <div class="bg-viola p-3 card shadow rounded-lg">
                <table class="table">
                    <thead>
                        <tr class="">
                            <th class="bg-viola"></th>
                            <th scope="col" class="bg-viola">
                                <a class="{{ $settings['orderBy'] == 'client_name' ? 'badge text-bg-primary text-wrap fs-10' : '' }}"
                                    href="{{ route('admin.payment.index', array_merge(request()->query(), ['column' => 'client_name', 'order' => $settings['orderBy'] == 'client_name' && $settings['orderFor'] == 'ASC' ? 'DESC' : 'ASC'])) }}">
                                    Client Name
                                    @if ($settings['orderBy'] == 'client_name')
                                        @if ($settings['orderFor'] == 'ASC')
                                            <i class="fas fa-arrow-up"></i>
                                            <!-- Aggiungi l'icona per l'ordine ascendente -->
                                        @else
                                            <i class="fas fa-arrow-down"></i>
                                            <!-- Aggiungi l'icona per l'ordine discendente -->
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="bg-viola">
                                <a class="{{ $settings['orderBy'] == 'due_date' ? 'badge text-bg-primary text-wrap fs-10' : '' }}"
                                    href="{{ route('admin.payment.index', array_merge(request()->query(), ['column' => 'due_date', 'order' => $settings['orderBy'] == 'due_date' && $settings['orderFor'] == 'ASC' ? 'DESC' : 'ASC'])) }}">Due
                                    Date
                                    @if ($settings['orderBy'] == 'due_date')
                                        @if ($settings['orderFor'] == 'ASC')
                                            <i class="fas fa-arrow-up"></i>
                                            <!-- Aggiungi l'icona per l'ordine ascendente -->
                                        @else
                                            <i class="fas fa-arrow-down"></i>
                                            <!-- Aggiungi l'icona per l'ordine discendente -->
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="bg-viola">
                                <a class="{{ $settings['orderBy'] == 'created_at' ? 'badge text-bg-primary text-wrap fs-10' : '' }}"
                                    href="{{ route('admin.payment.index', array_merge(request()->query(), ['column' => 'created_at', 'order' => $settings['orderBy'] == 'created_at' && $settings['orderFor'] == 'ASC' ? 'DESC' : 'ASC'])) }}">Created
                                    at
                                    @if ($settings['orderBy'] == 'created_at')
                                        @if ($settings['orderFor'] == 'ASC')
                                            <i class="fas fa-arrow-up"></i>
                                            <!-- Aggiungi l'icona per l'ordine ascendente -->
                                        @else
                                            <i class="fas fa-arrow-down"></i>
                                            <!-- Aggiungi l'icona per l'ordine discendente -->
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th scope="col" class="bg-viola">
                                <a class="{{ $settings['orderBy'] == 'active' ? 'badge text-bg-primary text-wrap fs-10' : '' }}"
                                    href="{{ route('admin.payment.index', array_merge(request()->query(), ['column' => 'active', 'order' => $settings['orderBy'] == 'active' && $settings['orderFor'] == 'ASC' ? 'DESC' : 'ASC'])) }}">Active
                                    @if ($settings['orderBy'] == 'active')
                                        @if ($settings['orderFor'] == 'ASC')
                                            <i class="fas fa-arrow-up"></i>
                                            <!-- Aggiungi l'icona per l'ordine ascendente -->
                                        @else
                                            <i class="fas fa-arrow-down"></i>
                                            <!-- Aggiungi l'icona per l'ordine discendente -->
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th  colspan="2" class="bg-viola">
                                Status
                            </th>
                            <th scope="col" class="text-end bg-viola">
                                <a class="{{ $settings['orderBy'] == 'total_price' ? 'badge text-bg-primary text-wrap fs-10' : '' }}"
                                    href="{{ route('admin.payment.index', array_merge(request()->query(), ['column' => 'total_price', 'order' => $settings['orderBy'] == 'total_price' && $settings['orderFor'] == 'ASC' ? 'DESC' : 'ASC'])) }}">Total
                                    Price €
                                    @if ($settings['orderBy'] == 'total_price')
                                        @if ($settings['orderFor'] == 'ASC')
                                            <i class="fas fa-arrow-up"></i>
                                            <!-- Aggiungi l'icona per l'ordine ascendente -->
                                        @else
                                            <i class="fas fa-arrow-down"></i>
                                            <!-- Aggiungi l'icona per l'ordine discendente -->
                                        @endif
                                    @endif
                                </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $payment)
                            <tr class="db-green">
                                {{-- {{ route('admin.payment.edit', $payment->id) }} --}}
                                <td><a href="{{route('admin.payment.copyCreate', $payment)}}" class="btn btn-primary">Duplicate</a></td>
                                <td onclick="window.location='{{ route('admin.payment.edit', $payment->id) }}'">
                                    {{ $payment->client_name }} </td>
                                <td>
                                    @if ($payment->due_date)
                                    {{ \Carbon\Carbon::parse($payment->due_date)->format('d/m/Y') }}
                                    @else
                                        ∞
                                    @endif
                                </td>
                                <td onclick="window.location='{{ route('admin.payment.edit', $payment->id) }}'">
                                    {{ \Carbon\Carbon::parse($payment->created_at)->format('d/m/Y') }}
                                </td>
                                <td onclick="window.location='{{ route('admin.payment.edit', $payment->id) }}'">
                                    @if ($payment->active == true)
                                        <span class="badge bg-success">Enabled</span>
                                    @else
                                        <span class="badge bg-danger">Disabled</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($payment->status == 'paid')
                                        <span class="badge bg-success">{{$payment->status}}</span>
                                    @else
                                        <span class="badge bg-danger">{{$payment->status}}</span>
                                    @endif
                                  
                                </td>
                                <td class="relative">
                                    <button class="btn btn-secondary copyButton" onclick="copy(event)"
                                        token="http://192.168.1.8:8000/pay/{{ $payment->token }}">
                                        Copy
                                    </button>
                                    <div class="absolute">
                                        link copiato
                                    </div>
                                </td onclick="window.location='{{ route('admin.payment.edit', $payment->id) }}'">
                                <td class="price-right">{{ number_format($payment->total_price, 2, ',', '.') }} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            <div class="pagination d-flex justify-content-between p-1 shadow search mt-3 align-items-center">
                <div class="d-flex gap-2">
                    <div>
                        @if ($payments->currentPage() > 1)
                            <a class="btn btn-primary bh d-flex align-items-center" href="{{ url()->current() }}?page=1"
                                class="pagination-link">
                                <i class="fas fa-chevron-left"></i><i class="fas fa-chevron-left"></i> </a>
                        @endif
                    </div>
                    <div>
                        @if ($payments->currentPage() > 1)
                            <a class="btn btn-secondary bh d-flex align-items-center"
                                href="{{ $payments->appends(request()->query())->previousPageUrl() }}"
                                class="pagination-link">&laquo; Previous</a>
                        @endif
                    </div>
                </div>
                <div>
                    <span>Current Page</span>
                    <span class="font-weight-bold">{{ $payments->currentPage() }}</span> /
                    <span class="font-weight-bold">{{ $payments->lastPage() }}</span>
                    <span class="mx-4">Total results : {{ $payments->total() }}</span>
                </div>

                <div class="d-flex gap-2">
                    <div>
                        @if ($payments->hasMorePages())
                            <a class="btn btn-secondary bh d-flex align-items-center"
                                href="{{ $payments->appends(request()->query())->nextPageUrl() }}"
                                class="pagination-link">Next &raquo;</a>
                        @endif
                    </div>
                    <div>
                        @if ($payments->currentPage() == $payments->lastPage())
                        @else
                            <a class="btn btn-primary bh d-flex align-items-center"
                                href="{{ url()->current() }}?page={{ $payments->lastPage() }}"
                                class="pagination-link"><i class="fas fa-chevron-right"></i><i
                                    class="fas fa-chevron-right"></i></a>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection



<script>
    document.addEventListener("DOMContentLoaded", (event) => {
        document.getElementById('perPage').addEventListener('change', function() {
            form.submit();
        });

        document.getElementById('active').addEventListener('change', function() {
            form.submit();
        });
        // resetta i filtri
        document.getElementById('resetFilter').addEventListener('click', function() {
            console.log("Pulsante cliccato"); // Aggiunto per verifica 
            window.location.href = '{{ route('admin.payment.index') }}';
        });

        const sortableColumns = document.querySelectorAll('.sortable');


        const btns = document.getElementsByClassName('copyButton');

        for (let b = 0; b < btns.length; b++) {
           
            btns[b].addEventListener('click', function(e) {
                event.preventDefault();
                const token = btns[b].getAttribute("token");
                link = token.toString()
                const inputNascosto = document.createElement("input");
                inputNascosto.value = link;
                document.body.appendChild(inputNascosto);

                // Seleziona il testo nell'input
                inputNascosto.select();
                // Copia il testo selezionato negli appunti del dispositivo
                document.execCommand("copy");

                // Rimuovi l'input nascosto dal documento
                document.body.removeChild(inputNascosto);
            })
        }

        function copy() {
          
            console.log('ciao')
        }
        
        
    });
</script>
