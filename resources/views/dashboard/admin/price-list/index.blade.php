@extends('layout.dashboard.app')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Daftar Harga</h1>
                <div class="section-header-breadcrumb">
                    {{--                    <a class="btn btn-primary" href="{{ route('dashboard.admin.category.create') }}">Tambah Kategori</a>--}}
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
                                <h4>Daftar Harga</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1" style="width: 100%">
                                        <thead>
                                        <tr>
                                            <th>Harga</th>
                                            <th>Paket</th>
                                            <th>Deskripsi</th>
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

            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var current_table_url = '{{ route('ajax.dashboard.admin.price-list.index') }}';
            var testimonials = $('#table-1').DataTable({
                "dom": "t, p, i",
                pageLength: 10,
                serverSide: true,
                ajax: current_table_url,
                searchDelay: 350,
                columns: [
                    {data: 'price', name: 'price',},
                    {data: 'package', name: 'package',},
                    {data: 'description', name: 'description',},
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
            $.get({
                url: '{{ url('ajax/dashboard/admin/price-list/edit') }}/' + id,
                success: (response) => {
                    $('.modal-content').html(response);
                    $("#confirmationModal").modal('show');
                }
            })
        }
    </script>
@endsection
