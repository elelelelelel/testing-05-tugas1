@extends('layout.dashboard.app')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Buat Pesanan</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Tambah Pemesanan</a></div>
                    {{--                    <div class="breadcrumb-item">Form</div>--}}
                </div>
            </div>
            <form method="POST" action="{{ route('dashboard.editor.order.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="section-body">
                    <div class="row">
                        <div class="col-12">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as  $e)
                                            <li>{{$e}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="control-label">Judul</label>
                                        <input type="text" id="firstName" class="form-control" name="title"
                                               placeholder="Judul">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Abstract</label>
                                        <textarea class="form-control" name="abstract" style="height: 100px"
                                                  placeholder="Abstract"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Keyword</label>
                                        <input type="text" id="firstName" class="form-control" name="keyword"
                                               placeholder="Ex : Datamining, SVM, Naive Bayes">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Subject Area</label>
                                        <select class="form-control" name="category">
                                            <option disabled selected>Pilih Subject Area</option>
                                            @foreach($categories as $category)
                                                <option
                                                    value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Category</label>
                                        <select class="form-control" name="sub_category" id="sub-category">
                                            <option disabled selected>Pilih Category</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">File (Docx / Doc / PDF)</label>
                                        <input type="file" name="doc" class="form-control" required/>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Form Review (Docx / Doc / PDF) *opsional</label>
                                        <input type="file" name="form_review" class="form-control"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Paket Harga</label>
                                        <div class="selectgroup selectgroup-pills">
                                            @foreach(\App\Models\PriceList::all() as $i => $price)
                                                <label class="selectgroup-item">
                                                    <input type="radio" name="price" value="{{ $price->id }}"
                                                           class="selectgroup-input" {{ $i == 0 ? 'checked' : '' }}>
                                                    <span
                                                        data-toggle="tooltip" title="{{ $price->tooltip }}"
                                                        class="selectgroup-button">{{ $price->package. ' (Rp. ' . number_format($price->price).' per 1000 kata)' }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Total Kata</label>
                                        <input type="number" id="firstName" class="form-control" name="total_words"
                                               placeholder="100">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Pembayaran</label>
                                        <div class="selectgroup selectgroup-pills">
                                            @foreach(\App\Models\AdminBank::all() as $i => $bank)
                                                <label class="selectgroup-item">
                                                    <input type="radio" name="bank" value="{{ $bank->id }}"
                                                           class="selectgroup-input" {{ $i == 0 ? 'checked' : '' }}>
                                                    <span
                                                        class="selectgroup-button"
                                                        style="height: 75px;"><b>{{ $bank->bank_name }}</b><br>{{ $bank->bank_holder . ' (' . $bank->bank_number.')' }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary mr-1" type="submit">Pesan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
@section('scripts')
    <script>
        $('select[name="category"]').change(function (e) {
            $.get({
                url: '{{ url('/sub-categories') }}/' + $(this).val(),
                success: (response) => {
                    $('#sub-category').empty();

                    if (response.data.subcategories.length > 0) {
                        $.each(response.data.subcategories, function (key, subcategories) {
                            $('#sub-category').append('<option value="' + subcategories.id + '">' + subcategories.name + '</option>')
                        });
                    } else {
                        $('#sub-category').append('<option disabled selected>Belum ada kategori</option>')
                    }
                }
            })
        })
    </script>
@endsection
