@extends('layout.dashboard.app')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Daftar Pengguna</h1>
            </div>

            <div class="section-body">
                @if(Session::has('success'))
                    <div class="alert-success alert">{{ Session::get('success') }}</div>
                @endif
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Pengguna</h4>
                                <div class="card-header-action">
                                    <div class="dropdown">
                                        <a href="#" data-toggle="dropdown" class="btn btn-warning dropdown-toggle"
                                           id="btn-filter-role">Filter</a>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item btn-filter-role" data-type="all"> All</a>
                                            <a href="#" class="dropdown-item btn-filter-role" data-type="reviewer">
                                                Reviewer</a>
                                            <a href="#" class="dropdown-item btn-filter-role" data-type="editor">
                                                Editor</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1" style="width: 100%">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Role</th>
                                            <th>University</th>
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
                        Apakah anda yakin akan mengkofirmasi ini?
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
        var threshold_minimal = '{{ $threshold_minimal }}'
        var threshold_maximal = '{{ $threshold_maximal }}'
        var current_table_url = '{{ route('ajax.dashboard.makelar.user.index') }}';
        let testimonials = $('#table-1').DataTable({
            "dom": "t, p, i",
            pageLength: 10,
            serverSide: true,
            ajax: current_table_url,
            searchDelay: 350,
            columns: [
                {data: 'name', name: 'name',},
                {data: 'email', name: 'email',},
                {data: 'phone', name: 'phone',},
                {data: 'role', name: 'role',},
                {data: 'university', name: 'university',},
                {data: 'status', name: 'status',},
                {data: 'action', name: 'action',},
            ],
            createdRow: (row, data, index) => {
                if (data.similarity >= threshold_minimal && data.similarity <= threshold_maximal) {
                    $(row).attr('style', 'background-color:#ebecf0');
                } else {
                    $(row).attr('bgcolor', 'white')
                }
            }, drawCallback: (settings) => {
                $('.btn-primary').click(function () {
                    modalShow($(this).data('id'), 'approve');
                })

                $('.btn-danger').click(function () {
                    modalShow($(this).data('id'), 'decline');
                })
            }
        });
        tablePagination('table-1');

        $('.btn-filter-role').click(function (e) {
            e.preventDefault()
            let url = new URL(current_table_url);
            url.searchParams.set('role', $(this).data('type'));
            current_table_url = url.href;
            testimonials.ajax.url(current_table_url).load();
            $('#btn-filter-role').text(jsUcfirst($(this).data('type')))
        })

        function tablePagination($tableID) {
            $('#' + $tableID + '_paginate').appendTo('.paginate-' + $tableID);
            $('#' + $tableID + '_info').appendTo('.info-' + $tableID);
        }

        function jsUcfirst(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        function modalShow(id, type) {
            $('#confirmationModal').modal('show');
            if (type == 'approve') {
                $('#form-submit').attr('action', '{{ url('dashboard/makelar/users/approve') }}/' + id)
            } else {
                $('#form-submit').attr('action', '{{ url('dashboard/makelar/users/decline') }}/' + id)
            }
        }
    </script>
@endsection
