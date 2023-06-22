@extends('layout.dashboard.app')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Daftar Tawaran untuk Pesanan {{ $auction->order->title }}</h1>
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
                                        <tr>
                                            <th>Reviewer</th>
                                            <th>Harga yang Ditawarkan</th>
                                            <th>Deadline yang Ditawarkan</th>
                                            <th>Action</th>
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
                        Apakah anda yakin akan mengkofirmasi tawaran ini?
                    </p>
                    <form method="POST" action="#"
                          id="form-submit">
                        @csrf
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                    <button type="button" class="btn btn-primary"
                            onclick="event.preventDefault(); document.getElementById('form-submit').submit();">
                        Ya
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var current_table_url = '{{ route('ajax.dashboard.makelar.auction.show',$auction->id) }}';
            var testimonials = $('#table-1').DataTable({
                "dom": "t, p, i",
                pageLength: 10,
                serverSide: true,
                ajax: current_table_url,
                searchDelay: 350,
                columns: [
                    {data: 'editor', name: 'editor',},
                    {data: 'bid', name: 'bid',},
                    {data: '_deadline_at', name: '_deadline_at',},
                        @if($auction->status == 0)
                    {
                        data: 'action', name: 'action',
                    },
                    @endif
                ], drawCallback: (settings) => {
                    $('.btn-primary').click(function () {
                        modalShow($(this).data('id'));
                    })
                }
            });
            tablePagination('table-1');
        });

        function modalShow(id) {
            $('#confirmationModal').modal('show');
            $('#form-submit').attr('action', '{{ url('dashboard/makelar/auctions') }}/' + id)
        }

        function tablePagination($tableID) {
            $('#' + $tableID + '_paginate').appendTo('.paginate-' + $tableID);
            $('#' + $tableID + '_info').appendTo('.info-' + $tableID);
        }
    </script>
@endsection
