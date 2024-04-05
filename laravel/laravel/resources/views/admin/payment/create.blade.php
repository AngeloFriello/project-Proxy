@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row mt-3 mb-3 text-aline-center">
            <div class="card col-12 p-4 ">
                <form action="{{ route('admin.payment.store') }}" method="POST" class="" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="client_name" class="form-label">Client Name</label>
                        <input type="text" class="form-control" id="client_name" value="" name="client_name">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="description" value="" name="description">
                    </div>
                    <h3 class="p-3">Cart</h3>

                    <div id="productSections">
                        <!-- Qui verranno aggiunte dinamicamente le sezioni di aggiunta prodotti -->
                    </div>

                    <div class="py-3">
                        <p id="totalPriceLabel">Prezzo Totale : </p>
                        <input type="text" id="total_price" name="total_price" value="" readonly>
                    </div>

                    <button type="submit" id='submit' class="btn btn-primary">Submit</button>
                    <button type="button" id="addProductBtn" class="btn btn-success">Aggiungi Prodotto</button>
                </form>
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
        </div>
    </div>

    <script>
        document.getElementById("addProductBtn").addEventListener("click", function() {
            // Crea una nuova sezione di aggiunta prodotto
            var productSection = document.createElement("div");
            productSection.classList.add("card", "p-3", "m-3");

            // Aggiungi gli input per il nuovo prodotto
            productSection.innerHTML = `
            <div class="mb-3 d-flex">
                <div class="px-3">
                    <label for="product_name" class="form-label">Add product</label>
                    <input type="text" class="form-control refresh" name="product_name[]">
                </div>
                <div class="px-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" class="form-control refresh" name="quantity[]">
                </div>
                <div class="px-3">
                    <label for="product_price" class="form-label">Price</label>
                    <input type="number" class="form-control refresh" name="product_price[]" onchange="updateTotalPrice()">
                </div>
                <div class="px-3">
                    <button type="button" class="btn btn-danger removeProductBtn">Elimina Prodotto</button>
                </div>
            </div>`;

            // Aggiungi la nuova sezione di aggiunta prodotto al DOM
            document.getElementById("productSections").appendChild(productSection);
        });
        document.addEventListener("click", function(event) {
            if (event.target.classList.contains("removeProductBtn")) {
                event.target.closest(".card").remove(); // Rimuovi la sezione del prodotto più vicina
                updateTotalPrice();
            }
        });



        function updateTotalPrice() {
            var totalPrice = 0;
            var productPrices = document.querySelectorAll('input[name="product_price[]"]');
            var quantities = document.querySelectorAll('input[name="quantity[]"]');

            productPrices.forEach(function(productPrice, index) {
                var price = parseFloat(productPrice.value);
                var quantity = parseInt(quantities[index].value);
                totalPrice += price * quantity;
            });

            document.getElementById("total_price").value = totalPrice.toFixed(2);
        }

        document.addEventListener("DOMContentLoaded", function() {
        
            let inputs = document.querySelectorAll('.refresh');

        
            inputs.forEach(function(input) {
                input.addEventListener("input", function() {
                    
                    updateTotalPrice();
                });
            });
        });
    </script>
@endsection