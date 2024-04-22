@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row mt-3 mb-3 text-aline-center">
            <div class="card col-12 p-5 ">
                <form action="{{ route('admin.payment.store') }}" method="POST" class="" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="client_name" class="form-label">Client Name</label>
                        <input type="text" class="form-control" id="client_name" name="client_name"
                            value="{{ old('client_name') }}">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea type="text" class="form-control " id="description" rows="4" value="{{ old('description') }}"
                            name="description">{{ old('description') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="">Due Date</label>
                        <input type="date" class="form-control" id="due_date" name="due_date"
                            value="{{ old('due_date') }}">
                    </div>
                    <div class="form-check form-switch">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Enabled</label>
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault"
                            value="1" name="active">
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="p-3">Cart</h3>
                        </div>

                        <div class="d-flex flex-row-reverse">
                            <button type="button" id="addProductBtn" class="btn btn-success add">+ Add Product</button>
                        </div>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="d-flex justify-content-center flex-column align-items-center">
                        <div id="productSections" class="">
                            <!-- Qui verranno aggiunte dinamicamente le sezioni di aggiunta prodotti -->
                            <div class="card p-3 my-3 pruduct-section">
                                <div class="mb-3 d-flex justify-content-between ">
                                    <div class="d-flex align-items-center">
                                        <div class="px-3">
                                            <label for="product_name" class="form-label ">Product Name</label>
                                            <input type="text" class="form-control refresh"
                                                name="products[0][product_name]"
                                                value="{{ old('products.0.product_name') }}">
                                        </div>
                                        <div class="px-3">
                                            <label for="quantity" class="form-label ">Quantity</label>
                                            <select type="number" class="form-control refresh quantity"
                                                name="products[0][quantity]" id="quantity_select">
                                                @for ($j = 1; $j <= 100; $j++)
                                                    <option value="{{ $j }}">{{ $j }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="">
                                            <button type="button" class=" removeProductBtn delete-product">x</button>
                                        </div>
                                    </div>
                                    <div class="px-3 input-group d-flex flex-column-reverse align-items-end">
                                        <div class="d-flex">
                                            <input type="number" class="form-control refresh price" step="0.01"
                                                min="1" name="products[0][product_price]"
                                                onchange="updateTotalPrice()"
                                                value="{{ old('products.0.product_price') }})">
                                        </div>
                                        <label for="product_price" class="form-label">Price : &euro;</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="card p-3  d-flex flex-row-reverse pruduct-section">
                            <div class="px-3 ">
                                <div class="d-flex justify-content-end flex-column align-items-end">
                                    {{-- <label id="totalPriceLabel" class="form-label">Total Price : &euro;</label>
                                    <input type="text" class="form-control total refresh" id="total_price"  step="0.01" name="total_price" value="0.00" readonly> --}}
                                    <div class="d-flex no-wrap">
                                        <h4>Total Price : <span id="total_price"></span> &euro;</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5">
                        <a class="btn btn-secondary" href="{{ route('admin.payment.index') }}"><-Back </a>
                                <button type="submit" id='submit' class="btn btn-primary mx-3">Create</button>
                    </div>

                </form>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", (event) => {
            let index = 0;


            function updateTotalPrice() {
                var productPrices = document.getElementsByClassName("price")
                var quantities = document.getElementsByClassName("quantity")
                var totalPrice = 0;
                for (let p = 0; p < productPrices.length; p++) {

                    var price = parseFloat(productPrices[p].value);
                    var quantity = parseFloat(quantities[p].value);
                    totalPrice += price * quantity;
                }

                if (isNaN(totalPrice)) {
                    totalPrice = 0

                } else {
                    document.getElementById("total_price").innerHTML = totalPrice.toFixed(2);
                }
                console.log(totalPrice)
                if (totalPrice === 0) {
                    document.getElementById("total_price").innerHTML = 0 .toFixed(2);
                }
            }

            // Aggiungi un listener per l'evento "input" su tutti gli input e textarea
            document.querySelectorAll('input, textarea').forEach(function(element) {
                element.addEventListener('input', updateTotalPrice);
            });

            // Aggiungi un listener per l'evento "keypress" su tutti gli input di tipo text
            document.querySelectorAll('input[type="text"]').forEach(function(element) {
                element.addEventListener('keypress', updateTotalPrice);
            });

            // Aggiungi un listener per l'evento "click" su tutti i bottoni
            document.querySelectorAll('button').forEach(function(element) {
                element.addEventListener('click', updateTotalPrice);
            });


            document.getElementById("addProductBtn").addEventListener("click", function() {
                // Verifica se tutti i campi del prodotto precedente sono stati compilati
                index = index + 1;
                var lastProductSection = document.querySelector("#productSections .card:last-of-type");
                if (lastProductSection) {
                    var inputs = lastProductSection.querySelectorAll("input");
                    var isFilled = true;
                    inputs.forEach(function(input) {
                        if (input.value.trim() === "") {
                            isFilled = false;
                            return;
                        }
                    });

                    // Se i campi del prodotto precedente non sono stati compilati, mostra un messaggio di errore
                    if (!isFilled) {
                        alert(
                            "Compila tutti i campi del prodotto precedente prima di aggiungerne un altro."
                            );
                        return;
                    }
                }

                // Crea una nuova sezione di aggiunta prodotto
                var productSection = document.createElement("div");
                // productSection.classList.add("card", "p-3", "m-3");

                // Aggiungi gli input per il nuovo prodotto
                productSection.innerHTML = `
            <div class="card p-3 my-3 pruduct-section">
                                <div class="mb-3 d-flex justify-content-between ">
                                    <div class="d-flex align-items-center">
                                        <div class="px-3">
                                            <label for="product_name" class="form-label ">Product Name</label>
                                            <input type="text" class="form-control refresh"
                                                name="products[${index}][product_name]"
                                                value="{{ old('products.${index}.product_name') }}">
                                        </div>
                                        <div class="px-3">
                                            <label for="quantity" class="form-label ">Quantity</label>
                                            <select type="number" class="form-control refresh quantity" name="products[${index}][quantity]">
                                                @for ($j = 1; $j <= 100; $j++)
                                                <option value="{{ $j }}" >{{ $j }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="">
                                            <button type="button" class=" removeProductBtn delete-product">x</button>
                                        </div>
                                    </div>
                                    <div class="px-3 input-group d-flex flex-column-reverse align-items-end">
                                        <div class="d-flex">
                                            <input type="number" class="form-control refresh price" step="0.01"
                                                name="products[${index}][product_price]" onchange="updateTotalPrice()"
                                                value="{{ old('products.${index}.product_price') }}">
                                        </div>
                                        <label for="product_price" class="form-label">Price : &euro;</label>
                                    </div>
                                </div>
                            </div>`;

                // Aggiungi la nuova sezione di aggiunta prodotto al DOM
                document.getElementById("productSections").appendChild(productSection);
                productSection.querySelectorAll('.refresh').forEach(function(element) {
                    element.addEventListener('input', updateTotalPrice);
                });
            });


            // Listener per il pulsante "Elimina Prodotto"
            document.addEventListener("click", function(event) {
                if (event.target.classList.contains("removeProductBtn")) {
                    event.target.closest(".card").remove(); // Rimuovi la sezione del prodotto più vicina
                    updateTotalPrice(); // Aggiorna il prezzo totale
                }
            });
            $(document).ready(function() {
                $('#quantity_select').change(function() {
                    updateTotalPrice();
                });
            });

        })
    </script>

@endsection
