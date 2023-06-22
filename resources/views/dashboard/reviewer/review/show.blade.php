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
                    <div class="col-8">
                        <div class="card">
                            <div class="invoice">
                                <div class="invoice-print">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="invoice-title">
                                                <h2>Invoice</h2>
                                                Status : <b>{{ $order->status }}</b>
                                                <div class="invoice-number">Order #{{ $order->invoice }}</div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <address>
                                                        <strong>Editor :</strong><br>
                                                        {{ $order->editor->name }}<br>
                                                        {{ $order->editor->email }}<br>
                                                        {{ $order->editor->university }}
                                                    </address>
                                                </div>
                                                <div class="col-md-6 text-md-right">
                                                    <address>
                                                        <strong>Reviewer :</strong><br>
                                                        {{ $order->reviewer->name }}<br>
                                                        {{ $order->reviewer->email }}<br>
                                                        {{ $order->reviewer->university }}
                                                    </address>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <address>
                                                        <strong>Payment Method:</strong><br>
                                                        Bank Transfer<br>
                                                        {{ $order->account_number . ' - ' . $order->account_holder . " ($order->account_name)" }}
                                                    </address>
                                                </div>
                                                <div class="col-md-6 text-md-right">
                                                    <address>
                                                        <strong>Order Date:</strong><br>
                                                        {{ $order->created_at->format('d F Y') }}<br><br>
                                                    </address>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <address>
                                                        <strong>Subject Area :</strong><br>
                                                        {{ $order->subCategory->category->name }}<br>
                                                        <strong>Category :</strong><br>
                                                        {{ $order->subCategory->name }}
                                                    </address>
                                                </div>
                                                @if(!is_null($order->deadline_at))
                                                    <div class="col-md-6 text-md-right">
                                                        <address>
                                                            <strong>Deadline:</strong><br>
                                                            {{ $order->deadline_at->format('d F Y') }}<br><br>
                                                        </address>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <div class="section-title">Order Summary</div>
                                            <p class="section-lead">All items here cannot be deleted.</p>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover table-md">
                                                    <tr>
                                                        <th>Title</th>
                                                        <th class="text-center">Paket</th>
                                                        <th class="text-center">Harga</th>
                                                        <th class="text-center">Total Kata</th>
                                                        <th class="text-right">Total Harga</th>
                                                    </tr>
                                                    <tr>
                                                        <td>{{ $order->title }}</td>
                                                        <td class="text-center">{{ $order->priceList->package }}</td>
                                                        <td class="">
                                                            Rp. {{ number_format($order->price) }}</td>
                                                        <td>{{ number_format($order->total_words) . ' Kata' }}</td>
                                                        <td class="text-right">
                                                            Rp. {{ number_format($order->total_price) }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-lg-8">
                                                    <div class="section-title">File</div>
                                                    <p class="section-lead">
                                                        <a href="{{ \Illuminate\Support\Facades\Storage::disk('s3')->url($order->file_path) }}"
                                                           target="_blank">{{ $order->file_name . " ($order->file_size)" }}</a>
                                                    </p>
                                                    @if(!is_null($order->form_review_path))
                                                        <div class="section-title">Form Review</div>
                                                        <p class="section-lead">
                                                            <a href="{{ \Illuminate\Support\Facades\Storage::disk('s3')->url($order->form_review_path) }}"
                                                               target="_blank">{{ $order->form_review_name . " ($order->form_review_size)" }}</a>
                                                        </p>
                                                    @endif
                                                    @if(!is_null($order->upload_review_at))
                                                        <div class="section-title">File dari Reviewer</div>
                                                        <p class="section-lead">
                                                            @foreach($order->reviews as $review)
                                                                <a href="{{ \Illuminate\Support\Facades\Storage::disk('s3')->url($review->attachment_path) }}"
                                                                   target="_blank">{{ $review->attachment_name }}</a>
                                                                <br>
                                                            @endforeach
                                                        </p>
                                                    @endif
                                                    @if($order->rate > 0)
                                                        <div class="section-title">Rate</div>
                                                        <p class="section-lead">
                                                            @for($i=0; $i < $order->rate; $i++)
                                                                <span><i class="fas fa-star"></i></span>
                                                            @endfor
                                                        </p>
                                                    @endif
                                                    @if(!is_null($order->testimonial))
                                                        <div class="section-title">Testimoni</div>
                                                        <p class="section-lead">
                                                            {{ $order->testimonial }}
                                                        </p>
                                                    @endif
                                                </div>
                                                <div class="col-lg-4 text-right">
                                                    <div class="invoice-detail-item">
                                                        <div class="invoice-detail-name">Subtotal</div>
                                                        <div class="invoice-detail-value">
                                                            Rp. {{ number_format($order->total_price) }}</div>
                                                    </div>
                                                    <div class="invoice-detail-item">
                                                        <div class="invoice-detail-name">Tax</div>
                                                        <div class="invoice-detail-value">+
                                                            Rp {{ number_format($order->tax_price) }}</div>
                                                    </div>
                                                    <hr class="mt-2 mb-2">
                                                    <div class="invoice-detail-item">
                                                        <div class="invoice-detail-name">Total</div>
                                                        <div class="invoice-detail-value invoice-detail-value-lg">
                                                            Rp. {{ number_format($order->total_price) }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="text-md-right">
                                    @if($order->status == 'Dikerjakan')
                                        <button
                                            data-toggle="modal" data-target="#confirmationModal"
                                            class="btn btn-success btn-icon icon-left">Upload Hasil Review
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="invoice">
                            <div class="invoice-print">
                                <div class="row">
                                    <div class="col-12">
                                        <h4>Order Log</h4>
                                        <div class="activities">
                                            @foreach($order->logs as $log)
                                                <div class="activity">
                                                    <div class="activity-detail">
                                                        <span
                                                            class="text-info-all text-capitalize">{{ $log->log }}</span>
                                                        <p class="text-info-all">{{ $log->created_at->format('d M Y h:i A') }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
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
                    <p>
                        Upload dokumen yang telah anda review disini
                    </p>
                    <form method="POST" action="{{ route('dashboard.reviewer.review.upload-doc') }}"
                          id="form-confirm-payment" enctype="multipart/form-data">
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <div class="form-group">
                            <label>Dokument</label>
                            <input type="file" class="form-control" name="doc">
                        </div>
                        @csrf
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                    <button type="button" class="btn btn-primary"
                            onclick="event.preventDefault(); document.getElementById('form-confirm-payment').submit();">
                        Ya
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
