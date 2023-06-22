@extends('layout.dashboard.app')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Daftar Reviewer</h1>
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
                                <h4>Daftar Reviewer</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1" style="width: 100%">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Gender</th>
                                            <th>University</th>
                                            <th>Category</th>
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
            var current_table_url = '{{ route('ajax.dashboard.editor.reviewer.index') }}';
            var testimonials = $('#table-1').DataTable({
                "dom": "t, p, i",
                pageLength: 10,
                serverSide: true,
                ajax: current_table_url,
                searchDelay: 350,
                columns: [
                    {data: 'name', name: 'name',},
                    {data: 'gender', name: 'gender',},
                    {data: 'university', name: 'university',},
                    {data: 'category', name: 'category',},
                ],
            });
            tablePagination('table-1');
        });

        function tablePagination($tableID) {
            $('#' + $tableID + '_paginate').appendTo('.paginate-' + $tableID);
            $('#' + $tableID + '_info').appendTo('.info-' + $tableID);
        }
    </script>
@endsection
