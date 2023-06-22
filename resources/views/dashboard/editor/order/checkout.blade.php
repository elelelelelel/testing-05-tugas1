@extends('layout.dashboard.app')
@section('breadcumb','Profile')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Transaksi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Transaksi</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card profile-widget">
                            <div class="profile-widget-description">
                                <center>
                                    <h4>Pesanan Anda telah Terbuat</h4>
                                    <p>Silahkan anda melakukan upload bukti pembayaran agar pesanan anda segera
                                        diproses. Terima kasih</p>
                                    <a href="{{ route('dashboard.editor.order.show',$order->invoice) }}"
                                       class="btn btn-success">Konfirmasi Pembayaran</a>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
