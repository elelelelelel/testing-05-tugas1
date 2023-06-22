@extends('admin/adminlayout')

@section('content')

<div class="uk-container uk-container-xlarge uk-margin-medium-top uk-margin-medium-bottom">
    <h1 class="uk-margin-medium-bottom">Penjualan</h1>
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
                            <th>Atas Nama</th>
                            <th>Timestamp</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($nselling > 0)
                            @foreach ($sellingnow as $selling)
                                <tr>
                                    <td>{{ $selling->atas_nama }}</td>
                                    <td>{{ $selling->created_at }}</td>
                                    @if ($selling->isdone == 0)
                                        <td>Menunggu konfirmasi</td>
                                    @else
                                        <td class="text-primary">Terkonfirmasi</td>
                                    @endif
                                    <td>Rp <span>{{ $selling->total_harga }}</span></td>
                                    <td>
                                        <button class="uk-button uk-button-default" type="button" href="#modal-overflow-{{ $selling->id_nota }}" uk-toggle>Lihat Pesanan</button>
                                        {{-- <button class="uk-button uk-button-primary" type="button">Terima Pesanan</button> --}}
                                        {{-- <button class="uk-button uk-button-danger" type="button">Batalkan</button> --}}
                                        {{-- <a class="uk-button uk-button-default" href="#modal-overflow" uk-toggle>Open</a> --}}

                                        <div id="modal-overflow-{{ $selling->id_nota }}" uk-modal>
                                            <div class="uk-modal-dialog">

                                                <button class="uk-modal-close-default" type="button" uk-close></button>

                                                <div class="uk-modal-header">
                                                    <h2 class="uk-modal-title">{{ $selling->atas_nama }}</h2>
                                                    <h5>Nomor Meja : {{ $selling->no_meja }}</h5>
                                                </div>

                                                <div class="uk-modal-body" uk-overflow-auto>
                                                    <div class="uk-overflow-auto" style="height: 400px;">
                                                        <table class="uk-table uk-table-small uk-table-divider uk-table-justify uk-table-middle">
                                                            <thead>
                                                                <tr>
                                                                    <th>Nama Produk</th>
                                                                    {{-- <th>Tipe</th> --}}
                                                                    <th>Jumlah</th>
                                                                    <th>Harga</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @for ($i = 0; $i < count($produkbought); $i++)
                                                                    @for ($j = 0; $j < $produkbought[$i]
                                                                        ->where('nota_id', '=', $selling->id_nota)
                                                                        ->count(); $j++)
                                                                        <tr>
                                                                            <td>{{ $produkbought[$i][$j]->nama }}</td>
                                                                            {{-- @if ($produk->jenis == 1)
                                                                                <td>Hangat</td>
                                                                            @else
                                                                                <td>Dingin</td>
                                                                            @endif --}}
                                                                            <td>{{ $produkbought[$i][$j]->jumlah }}</td>
                                                                            <td>Rp <span>{{ $produkbought[$i][$j]->harga }}</span></td>
                                                                        </tr>
                                                                    @endfor
                                                                @endfor
                                                                {{-- @foreach ($produkbought as $produk)
                                                                @endforeach --}}
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                
                                                <div class="uk-modal-footer uk-text-left">
                                                    <div>TOTAL : Rp <span>{{ $selling->total_harga }}</span></div>
                                                </div>

                                                <div class="uk-modal-footer uk-text-right uk-flex" style="margin-left: auto; width: fit-content">
                                                    {{-- <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button> --}}
                                                    {{-- <button class="uk-button uk-button-danger" type="button">Batalkan Pesanan</button> --}}
                                                    <form action="{{ url('admin/selling/'.$selling->id_nota.'/dec') }}" method="PUT">
                                                        @csrf
                                                        <button class="uk-button uk-button-danger" type="submit">Batalkan Pesanan</button>
                                                    </form>
                                                    <form action="{{ url('admin/selling/'.$selling->id_nota.'/acc') }}" method="PUT">
                                                        @csrf
                                                        <button class="uk-button uk-button-primary" type="submit">Terima Pesanan</button>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <p>Tidak ada pemesanan</p>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="uk-container uk-container small uk-margin-large-top" style="height: -webkit-fill-available">
        <h3>Riwayat Pemesanan</h3>
        <div class="uk-card uk-card-secondary uk-card-hover uk-card-body uk-light uk-margin-small" style="height: 100%">
            {{-- <h3 class="uk-card-title">Kelola Produk</h3> --}}
            <div class="uk-overflow-auto" style="height: 400px;">
                <table class="uk-table uk-table-small uk-table-divider uk-table-justify uk-table-middle">
                    <thead>
                        <tr>
                            <th>Atas Nama</th>
                            <th>Timestamp</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sellinghis as $selling)
                            <tr>
                                <td>{{ $selling->atas_nama }}</td>
                                <td>{{ $selling->updated_at }}</td>
                                @if ($selling->isdone == 1)
                                    <td class="text-primary">Berhasil</td>
                                @else
                                    <td class="text-danger">Dibatalkan</td>
                                @endif
                                <td>Rp <span>{{ $selling->total_harga }}</span></td>
                                <td>
                                    <button class="uk-button uk-button-default" type="button" href="#modal-overflow2-{{ $selling->id_nota }}" uk-toggle>Lihat Pesanan</button>
                                    {{-- <button class="uk-button uk-button-primary" type="button">Terima Pesanan</button> --}}
                                    {{-- <button class="uk-button uk-button-danger" type="button">Delete</button>s --}}
                                    <div id="modal-overflow2-{{ $selling->id_nota }}" uk-modal>
                                        <div class="uk-modal-dialog">

                                            <button class="uk-modal-close-default" type="button" uk-close></button>

                                            <div class="uk-modal-header">
                                                <h2 class="uk-modal-title">{{ $selling->atas_nama }}</h2>
                                                <h5>Nomor Meja : {{ $selling->no_meja }}</h5>
                                            </div>

                                            <div class="uk-modal-body" uk-overflow-auto>
                                                <div class="uk-overflow-auto" style="height: 400px;">
                                                    <table class="uk-table uk-table-small uk-table-divider uk-table-justify uk-table-middle">
                                                        <thead>
                                                            <tr>
                                                                <th>Nama Produk</th>
                                                                {{-- <th>Tipe</th> --}}
                                                                <th>Jumlah</th>
                                                                <th>Harga</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @for ($i = 0; $i < count($produkbought); $i++)
                                                                @for ($j = 0; $j < $produkbought[$i]
                                                                    ->where('nota_id', '=', $selling->id_nota)
                                                                    ->count(); $j++)
                                                                    <tr>
                                                                        <td>{{ $produkbought[$i][$j]->nama }}</td>
                                                                        {{-- @if ($produk->jenis == 1)
                                                                            <td>Hangat</td>
                                                                        @else
                                                                            <td>Dingin</td>
                                                                        @endif --}}
                                                                        <td>{{ $produkbought[$i][$j]->jumlah }}</td>
                                                                        <td>Rp <span>{{ $produkbought[$i][$j]->harga }}</span></td>
                                                                    </tr>
                                                                @endfor
                                                            @endfor
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            
                                            <div class="uk-modal-footer uk-text-left">
                                                <div>TOTAL : Rp <span>{{ $selling->total_harga }}</span></div>
                                            </div>

                                            <div class="uk-modal-footer uk-text-right">
                                                <button class="uk-button uk-button-default uk-modal-close" type="button">Tutup</button>
                                                {{-- <button class="uk-button uk-button-primary" type="button">Terima Pesanan</button> --}}
                                            </div>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="uk-text-center">
            <h4>Total Pendapatan : </h4>
            <h2 class="uk-text-primary">Rp <span>{{ $sumselling }}</span></h2>
        </div>
    </div>
</div>

@endsection