@extends('layout.dashboard.app')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Invoice</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Invoice</div>
                </div>
            </div>
            @if(Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif
            @if(Session::has('failed'))
                <div class="alert alert-danger">
                    {{ Session::get('failed') }}
                </div>
            @endif
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="invoice">
                                <div class="invoice-print">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="invoice-title">
                                                <h2>Judul : {{ $auction->order->title }}</h2>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <address>
                                                        <strong>Editor :</strong><br>
                                                        {{ $auction->order->editor->name }}<br>
                                                        {{ $auction->order->editor->email }}<br>
                                                        {{ $auction->order->editor->university }}
                                                    </address>
                                                </div>
                                                <div class="col-md-6 text-md-right">
                                                    <address>
                                                        <strong>Order Date :</strong><br>
                                                        {{ $auction->order->created_at->format('d M Y') }}
                                                    </address>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <address>
                                                        <strong>Subject Area :</strong><br>
                                                        {{ $auction->order->subCategory->category->name }}<br>
                                                        <strong>Category :</strong><br>
                                                        {{ $auction->order->subCategory->name }}
                                                    </address>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="section-title">Order Summary</div>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover table-md">
                                                    <tr>
                                                        <th class="text-center">Total Kata</th>
                                                        <th class="text-center">Total Harga</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-center">{{ number_format($auction->order->total_words) . ' Kata' }}</td>
                                                        <td class="text-center">
                                                            Rp. {{ number_format($auction->order->total_price) }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-12">
                                                    <div class="section-title">File</div>
                                                    <p class="section-lead">
                                                        <a href="{{ \Illuminate\Support\Facades\Storage::disk('s3')->url($auction->order->file_path) }}"
                                                           target="_blank">{{ $auction->order->file_name ." (" . $auction->order->file_size. ")" }}</a>
                                                    </p>
                                                    @if(!is_null($auction->order->form_review_path))
                                                        <div class="section-title">Form Review</div>
                                                        <p class="section-lead">
                                                            <a href="{{ \Illuminate\Support\Facades\Storage::disk('s3')->url($auction->order->form_review_path) }}"
                                                               target="_blank">{{ $auction->order->form_review_name . " (".$auction->order->form_review_size.")" }}</a>
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="text-md-right">
                                    @if($auction->details->where('reviewer_id',Auth::user()->id)->count() < 1)
                                        <button
                                            data-toggle="modal" data-target="#confirmationModal"
                                            class="btn btn-success btn-icon icon-left">Tawar
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('modal')
    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah anda akan membuat tawaran untuk pesanan ini? Silahkan masukkan tawaran anda
                    <br>
                    <br>
                    <form method="POST" id="form-submit" action="{{ route('dashboard.reviewer.auction.store') }}">
                        <input type="hidden" value="{{ $auction->id }}" name="auction_id">
                        <div class="form-group">
                            <label>Harga yang Ditawarkan</labeL>
                            <input class="form-control" placeholder="10000" name="bid">
                        </div>
                        <div class="form-group">
                            <label>Deadline yang Ditawarkan</labeL>
                            <input class="form-control" type="date"
                                   name="deadline"
                                   min="{{ \Carbon\Carbon::now()->addDays(1)->format('Y-m-d') }}"
                                   max='{{ \Carbon\Carbon::now()->addDays(14)->format('Y-m-d') }}'
                                   value="{{ \Carbon\Carbon::now()->addDays(1)->format('Y-m-d') }}">
                        </div>
                        @csrf
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                    <button type="button" class="btn btn-primary"
                            onclick="event.preventDefault(); document.getElementById('form-submit').submit();">Ya
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
