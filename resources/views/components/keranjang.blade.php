<button class="uk-button uk-button-secondary px-5" style="bottom: 0; right: 0; position: fixed; z-index: 300" href="#modal-overflow" uk-toggle>
    <span uk-icon="cart"></span>&nbsp;
    Keranjang ( <span class="total-count"></span> )
</button>

<div id="modal-overflow" class="uk-modal-container" uk-modal style="width: 100%">
    <div class="uk-modal-dialog">

        <button class="uk-modal-close-default" type="button" uk-close></button>

        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Keranjang</h2>
        </div>

        <div class="uk-modal-body" uk-overflow-auto>
            <table class="show-cart uk-table uk-table-striped">
                
            </table>
        </div>
        
        <div class="uk-modal-footer d-flex flex-row">
            <div class="uk-text-left fw-bold" style="width: fit-content">
                TOTAL HARGA: Rp<span class="total-cart" onload="disableKuy()"></span>
            </div>
            <div class="uk-text-right" style="width: fit-content; margin-left: auto">
                <button class="uk-button uk-button-default uk-modal-close" type="button">Tutup</button>
                <a href="{{ url('/checkout') }}">
                    <button id="disabled-btn" class="uk-button uk-button-secondary" type="button">Checkout</button>
                </a>
            </div>
        </div>

    </div>
</div>
<script src="{{ asset('js/keranjang.js') }}"></script>
<script>
    // console.log(cart);
    function disableKuy() {
        console.log(shoppingCart.totalCart(cart));
        // var disabledButton = document.getElementById("disabled-btn");
        if(shoppingCart.totalCart(cart) <= 0) {
            document.getElementById('disabled-btn').createAttribute("disabled"); 
        }
    }
</script>