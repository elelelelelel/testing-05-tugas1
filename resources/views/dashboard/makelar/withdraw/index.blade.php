@extends('layout.dashboard.app')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Riwayat Penarikan</h1>
                <div class="section-header-breadcrumb">
                </div>
            </div>

            <div class="section-body">
                @if(Session::has('success'))
                    <div class="alert-success alert">{{ Session::get('success') }}</div>
                @elseif(Session::has('failed'))
                    <div class="alert-danger alert">{{ Session::get('failed') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as  $e)
                                <li>{{$e}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Riwayat Penarikan</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1" style="width: 100%">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Nama Akun</th>
                                            <th>Nama Bank</th>
                                            <th>Nomor Rekening</th>
                                            <th>Jumlah</th>
                                            <th>Status</th>
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
    <div class="modal fade" id="depositoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                    <form method="POST" action="{{ route('dashboard.makelar.withdraw.confirm') }}" id="form-deposito">
                        <p>Apakah anda yakin akan mengkonfirmasi penarikan ini?</p>
                        <input type="hidden" name="withdraw_id" id="input-withdraw-id">
                        @csrf
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                    <button type="button" class="btn btn-primary"
                            onclick="event.preventDefault(); document.getElementById('form-deposito').submit();">
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
            var current_table_url = '{{ route('ajax.dashboard.makelar.withdraw.index') }}';
            var testimonials = $('#table-1').DataTable({
                "dom": "t, p, i",
                pageLength: 10,
                serverSide: true,
                ajax: current_table_url,
                searchDelay: 350,
                columns: [
                    {data: 'user', name: 'user',},
                    {data: 'behalf', name: 'behalf',},
                    {data: 'bank_name', name: 'bank_name',},
                    {data: 'bank_number', name: 'bank_number',},
                    {data: 'amount', name: 'amount',},
                    {data: 'status', name: 'status',},
                    {data: 'action', name: 'action',},
                ], drawCallback: (settings) => {
                    $('.btn-primary').click(function () {
                        modalShow($(this).data('id'));
                    })
                }
            });
            tablePagination('table-1');
        });

        function tablePagination($tableID) {
            $('#' + $tableID + '_paginate').appendTo('.paginate-' + $tableID);
            $('#' + $tableID + '_info').appendTo('.info-' + $tableID);
        }

        function modalShow(id) {
            $('#input-withdraw-id').val(id)
            $('#depositoModal').modal('show')
        }
    </script>
@endsection
