@extends('layout.dashboard.app')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Riwayat Tawaran</h1>
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
                                <h4>Riwayat Tawaran</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1" style="width: 100%">
                                        <thead>
                                        <tr>
                                            <th>Judul</th>
                                            <th>Harga Asli</th>
                                            <th>Harga yang Ditawarkan</th>
                                            <th>Deadline yang Ditawarkan</th>
                                            <th>Status</th>
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
            var current_table_url = '{{ route('ajax.dashboard.reviewer.auction.history') }}';
            var testimonials = $('#table-1').DataTable({
                "dom": "t, p, i",
                pageLength: 10,
                serverSide: true,
                ajax: current_table_url,
                searchDelay: 350,
                columns: [
                    {data: 'title', name: 'title',},
                    {data: 'price', name: 'price',},
                    {data: 'bid', name: 'bid',},
                    {data: '_deadline_at', name: '_deadline_at',},
                    {data: 'bid_status', name: 'bid_status',},
                ],
                createdRow: (row, data, index) => {
                    if (data.request_bid == '1') {
                        $(row).attr('bgcolor', '#ebecf0');
                    } else {
                        $(row).attr('bgcolor', 'white')
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
