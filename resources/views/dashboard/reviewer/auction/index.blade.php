@extends('layout.dashboard.app')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Daftar Tawaran</h1>
                <div class="section-header-breadcrumb">
                    {{--                    <a class="btn btn-primary" href="{{ route('dashboard.admin.user.create') }}">Tambah Pengguna</a>--}}
                </div>
            </div>

            <div class="section-body">
                @if(Session::has('success'))
                    <div class="alert-success alert">{{ Session::get('success') }}</div>
                @endif
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Tawaran</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1" style="width: 100%">
                                        <thead>
                                        <tr bgcolor="white" style="font-weight: bold">
                                            <td>Judul</td>
                                            <td>Kategori</td>
                                            <td>Total Kata</td>
                                            <td>Harga</td>
                                            <td>Batas Waktu</td>
                                            <td>Action</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var current_table_url = '{{ route('ajax.dashboard.reviewer.auction.index') }}';
            var testimonials = $('#table-1').DataTable({
                "dom": "t, p, i",
                pageLength: 10,
                serverSide: true,
                ajax: current_table_url,
                searchDelay: 350,
                columns: [
                    {data: 'title', name: 'title',},
                    {data: 'category', name: 'category',},
                    {data: 'word_count', name: 'word_count',},
                    {data: 'total_price', name: 'total_price',},
                    {data: '_auction_due_at', name: '_auction_due_at',},
                    {data: 'action', name: 'action',},
                ],
                createdRow: (row, data, index) => {
                    if (data.request_bid == '1') {
                        $(row).attr('style', 'background: #ebecf0');
                    } else {
                        $(row).attr('style', 'background: white')
                    }
                },
            });
            tablePagination('table-1');
        });

        function tablePagination($tableID) {
            $('#' + $tableID + '_paginate').appendTo('.paginate-' + $tableID);
            $('#' + $tableID + '_info').appendTo('.info-' + $tableID);
        }
    </script>
@endsection
