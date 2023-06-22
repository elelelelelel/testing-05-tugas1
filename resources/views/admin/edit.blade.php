@extends('admin/adminlayout')

@section('content')

<div class="uk-container uk-container-xlarge uk-margin-medium-top uk-margin-medium-bottom">
    <h1 class="uk-margin-medium-bottom">Edit Produk</h1>
    @if (session('success'))
        <div class="uk-alert-success" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    <div class="uk-margin-large-top uk-container uk-container-small">
        <form method="POST" action="{{ url('produks/'.$produk->id_produk) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <fieldset class="uk-fieldset">

                <legend class="uk-legend">Edit Produk</legend>

                <div class="uk-margin">
                    <label for="nama">Nama Produk</label>
                    <input name="nama" class="uk-input" type="text" placeholder="Nama Produk" required value="{{ $produk->nama }}">
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-select">Kopi / Susu</label>
                    <div class="uk-form-controls">
                        <select class="uk-select" name="jenis" id="form-horizontal-select" required>
                            @if ($produk->jenis == 1)
                                <option value="1">Kopi - kopian</option>
                                <option value="2">Susu - susuan</option>
                            @else
                            <option value="2">Susu - susuan</option>
                            <option value="1">Kopi - kopian</option>
                            @endif
                        </select>
                    </div>
                </div>
                {{-- <div class="uk-margin">
                    <label for="isdingin">Bisa dingin</label><br>
                    @if ($produk->isdingin == 0)
                        <label><input class="uk-radio" type="radio" name="isdingin" value="0" checked> Tidak</label><br>
                        <label><input class="uk-radio" type="radio" name="isdingin" value="1"> Bisa</label>
                    @else
                        <label><input class="uk-radio" type="radio" name="isdingin" value="0"> Tidak</label><br>
                        <label><input class="uk-radio" type="radio" name="isdingin" value="1" checked> Bisa</label>
                    @endif
                </div> --}}
                <div class="uk-margin">
                    <label for="harga">Harga Produk</label>
                    <input name="harga" class="uk-input" type="number" placeholder="Harga Produk" required value="{{ $produk->harga }}">
                </div>
                <div class="uk-margin" uk-margin>
                    <label for="upload">Upload Gambar</label><br>
                    <img src="{{ url('product_img/'.$produk->img_path) }}" alt="" style="width: 400px"><br>
                    <div uk-form-custom="target: true">
                        {{-- <label for="">Ganti gambar</label><br> --}}
                        <input type="file" name="file">
                        <input class="uk-input uk-form-width-medium" type="text" placeholder="Ganti gambar" disabled>
                    </div>
                    {{-- <button class="uk-button uk-button-default">Submit</button> --}}
                </div>

                <input type="submit" class="uk-button uk-button-primary" value="Submit" style="width: 100%">
            </fieldset>
        </form>
    </div>
</div>

@endsection