@extends('admin/adminlayout')

@section('content')

<div class="uk-container uk-container-xlarge uk-margin-medium-top uk-margin-medium-bottom">
    <h1 class="uk-margin-medium-bottom">Kelola Produk</h1>
    @if (session('success'))
        <div class="uk-alert-success" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    <div class="" style="height: -webkit-fill-available">
        <div class="uk-card uk-card-secondary uk-card-hover uk-card-body uk-light uk-margin-small" style="height: 100%">
            {{-- <h3 class="uk-card-title">Kelola Produk</h3> --}}
            <div class="uk-overflow-auto" style="height: 400px;">
                <table class="uk-table uk-table-small uk-table-divider uk-table-justify uk-table-middle">
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Jumlah Penjualan</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allproduk as $produk)
                            <tr>
                                <td><img src="{{url('/product_img'.'/'.$produk->img_path)}}" alt="" style="width: 200px"></td>
                                <td style="text-transform: capitalize">{{ $produk->nama }}</td>
                                <td>{{$produk->detailpesanans->sum('jumlah')}}</td>
                                <td>
                                    @if ($produk->isavail == 0)
                                        Non-Aktif
                                    @else
                                        Aktif
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ url('produks/toggleAction/'.$produk->id_produk) }}" method="PUT">
                                        @csrf
                                        <button class="uk-button uk-button-default" type="submit">
                                            @if ($produk->isavail == 1)
                                                Nonaktifkan
                                            @else
                                                Aktifkan
                                            @endif
                                        </button>
                                    </form>
                                    <a class="uk-button uk-button-primary" href="{{ url('/produks'.'/'.$produk->id_produk.'/edit') }}">
                                        Edit
                                    </a>
                                    <form action="{{ url('produks/'.$produk->id_produk) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button class="uk-button uk-button-danger" type="submit">
                                            DELETE
                                        </button>
                                    </form>
                                    {{-- <a class="uk-button uk-button-danger" href="{{ url('/produks'.'/'.$produk->id_produk) }}">
                                        Delete
                                    </a> --}}
                                    {{-- <button class="uk-button uk-button-danger" type="button">Delete</button> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="uk-margin-large-top uk-container uk-container-small">
        <form method="POST" action="{{ url('produks') }}" enctype="multipart/form-data">
            @csrf
            <fieldset class="uk-fieldset">

                <legend class="uk-legend">Tambah Produk</legend>

                <div class="uk-margin">
                    <label for="nama">Nama Produk</label>
                    <input name="nama" class="uk-input" type="text" placeholder="Nama Produk" required>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-select">Kopi / Susu</label>
                    <div class="uk-form-controls">
                        <select class="uk-select" name="jenis" id="form-horizontal-select" required>
                            <option value="1">Kopi - kopian</option>
                            <option value="2">Susu - susuan</option>
                        </select>
                    </div>
                </div>
                {{-- <div class="uk-margin">
                    <label for="isdingin">Bisa dingin</label><br>
                    <label><input class="uk-radio" type="radio" name="isdingin" value="0" checked> Tidak</label><br>
                    <label><input class="uk-radio" type="radio" name="isdingin" value="1"> Bisa</label>
                </div> --}}
                <div class="uk-margin">
                    <label for="harga">Harga Produk</label>
                    <input name="harga" class="uk-input" type="number" placeholder="Harga Produk" required>
                </div>
                <div class="uk-margin" uk-margin>
                    <label for="upload">Upload Gambar</label><br>
                    <div uk-form-custom="target: true">
                        <input type="file" name="file" required>
                        <input class="uk-input uk-form-width-medium" type="text" placeholder="Select file" disabled>
                    </div>
                    {{-- <button class="uk-button uk-button-default">Submit</button> --}}
                </div>

                <input type="submit" class="uk-button uk-button-primary" value="Submit" style="width: 100%">
            </fieldset>
        </form>
    </div>
</div>

@endsection
