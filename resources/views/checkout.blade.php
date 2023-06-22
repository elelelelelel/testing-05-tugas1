@extends('layout')

@section('content')
<div class="p-3" style="background-color: #CCB9B1;">
    <a href="javascript:history.back()" style="text-decoration: none;">
        <h4 style="align-items: center; margin-top: 100px;"><span uk-icon="icon: chevron-left; ratio: 2"></span>Back</h4>
    </a>
    <div class="uk-card uk-card-default uk-card-body m-3" style="">
        @if (session('success'))
            <div class="uk-alert-success" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p>{{ session('success') }}</p>
            </div>
        @endif
        <h2 class="mb-5">
            Checkout
        </h2>
        {{-- <div style="width: 500px" id="reader"></div> --}}
        <div class="uk-overflow-auto">
            <table class="show-cart uk-table uk-table-striped">

            </table>
        </div>
        <div class="uk-text-left fw-bold" style="width: fit-content">
            TOTAL HARGA: Rp<span class="total-cart" onload="disableKuy()"></span>
        </div>
        {{-- <div>{{ $sessiondata }}</div> --}}
        <div class="d-flex flex-column mt-4" style="place-content: center; text-align: -webkit-center;">
            <div class="d-flex flex-row mb-4" style="place-content: center">
                <h4 class="m-2">Apakah Anda</h4>
                <div class="button-group">
                    <label class="button-group__btn"><input type="radio" name="group" value="1" checked="checked"/> <span class="button-group__label">Sudah di tempat</span></label>
                    <label class="button-group__btn"><input type="radio" name="group" value="2"/> <span class="button-group__label">Pesan tempat</span></label>
                </div>

            </div>
            <div id="site1" class="desc">
                <h3>Sudah di tempat</h3>
                <form id="lalala" action="{{ url('/checkout'.'/'.csrf_token().'?') }}" class="uk-form-stacked" method="POST">
                    @csrf
                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Atas Nama</label>
                        <div class="uk-form-controls uk-width-1-4@s">
                            <input class="uk-input" name="atas_nama" id="form-stacked-text" type="text" placeholder="Nama" required>
                        </div>
                    </div>
                    <div id="cartdatani"></div>
                    <div id="qr-reader" style="width:500px"></div>
                    <div class="text-danger">*Pastikan kamera tidak digunakan oleh aplikasi lain</div>
                    <div class="mt-3 uk-card uk-card-primary uk-card-body uk-light" id="qr-reader-results" style="width: max-content; display: none"></div>
                    <input id="mejani" type="hidden" name="no_meja" value="">
                    <input id="totalni" type="hidden" name="total_harga" value="">
                    <div class="uk-margin">
                        <div class="uk-form-controls uk-width-1-4@s">
                            <input class="uk-input uk-button uk-button-primary" id="submitdata" type="Submit">
                        </div>
                    </div>
                </form>
            </div>
            {{-- <button id="submitdata">hawow</button> --}}
            <div id="site2" class="desc" style="display: none">
                <h3>Pesan tempat</h3>
                <form id="lalala2" action="{{ url('/checkout'.'/'.csrf_token().'?') }}" class="uk-form-stacked" method="POST">
                    @csrf
                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Atas Nama</label>
                        <div class="uk-form-controls uk-width-1-4@s">
                            <input class="uk-input" name="atas_nama" id="form-stacked-text" type="text" placeholder="Nama" required>
                        </div>
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Jumlah Orang</label>
                        <select name="jml_org" class="uk-select uk-width-1-4@s">
                            <option value="2">1-2</option>
                            <option value="4">3-4</option>
                            <option value="6">5-6</option>
                            <option value="8">7-8</option>
                            <option value="10">9-10</option>
                        </select>
                    </div>
                    <input id="totalni2" type="hidden" name="total_harga" value="">
                    <div class="uk-margin">
                        <div class="uk-form-controls uk-width-1-4@s">
                            <input class="uk-input uk-button uk-button-primary" id="submitdata" type="Submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function() {
        $("input[name$='group']").click(function() {
            var test = $(this).val();

            $("div.desc").hide();
            $("#site" + test).show();
        });
    });
</script>

{{-- <script src="/html5-qrcode.min.js"></script> --}}
<script src="{{ asset('js/qrcode.min.js'); }}"></script>
<script>
    function docReady(fn) {
        // see if DOM is already available
        if (document.readyState === "complete"
            || document.readyState === "interactive") {
            // call on next available tick
            setTimeout(fn, 1);
        } else {
            document.addEventListener("DOMContentLoaded", fn);
        }
    }

    docReady(function () {
        var resultContainer = document.getElementById('qr-reader-results');
        var lastResult, countResults = 0;
        let mejani = document.getElementById('mejani');
        function onScanSuccess(decodedText, decodedResult) {
            if (decodedText !== lastResult) {
                ++countResults;
                lastResult = decodedText;
                // Handle on success condition with the decoded message.
                console.log(`Scan result ${decodedText}`, decodedResult);
                resultContainer.innerHTML = `Nomor meja Anda : ${decodedText}`;
                resultContainer.style.display = "block"
                mejani.value += `${decodedText}`;
            }
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", { fps: 10, qrbox: 250 });
        html5QrcodeScanner.render(onScanSuccess);
    });
</script>

<script>
    // $("#submitdata").click(function(){
    $(document).ready(function() {
        $('#lalala').submit(function (){
            let testurl="";
            for(let i=0; i<cart.length; i++) {
                testurl += "halah%5B"+i+"%5D%5Bname%5D="+cart[i].name+"&"+"halah%5B"+i+"%5D%5Bprice%5D="+cart[i].price+"&"+"halah%5B"+i+"%5D%5Bcount%5D="+cart[i].count+"&";
            };
            var usertoken = '{{ csrf_token() }}';
            var nexturl = "/checkout/" + usertoken + testurl;
            var cartdata = [];
            cartdata = cart;
            document.getElementById('lalala').action += testurl;
        });

        $('#lalala2').submit(function (){
            let testurl="";
            for(let i=0; i<cart.length; i++) {
                testurl += "halah%5B"+i+"%5D%5Bname%5D="+cart[i].name+"&"+"halah%5B"+i+"%5D%5Bprice%5D="+cart[i].price+"&"+"halah%5B"+i+"%5D%5Bcount%5D="+cart[i].count+"&";
            };
            var usertoken = '{{ csrf_token() }}';
            var nexturl = "/checkout/" + usertoken + testurl;
            var cartdata = [];
            cartdata = cart;
            document.getElementById('lalala2').action += testurl;
        });

        let totalni = document.getElementById('totalni');
        totalni.value += shoppingCart.totalCart(cart);

        let totalni2 = document.getElementById('totalni2');
        totalni2.value += shoppingCart.totalCart(cart);

    });

</script>

@endsection
