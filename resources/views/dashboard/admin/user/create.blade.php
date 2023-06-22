@extends('layout.dashboard.app')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Pengguna</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    {{--                    <div class="breadcrumb-item"><a href="#">Bootstrap Components</a></div>--}}
                    {{--                    <div class="breadcrumb-item">Form</div>--}}
                </div>
            </div>
            <form method="POST" action="{{ route('dashboard.admin.user.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="section-body">
                    <div class="row">
                        <div class="col-12">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as  $e)
                                            <li>{{$e}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="control-label">First Name</label>
                                        <input type="text" id="firstName" class="form-control" name="first_name"
                                               placeholder="Ex : John">
                                    </div>
                                    <div class="form-group has-danger">
                                        <label class="control-label">Last Name</label>
                                        <input type="text" id="lastName" class="form-control"
                                               name="last_name"
                                               placeholder="Ex : Doe">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Email</label>
                                        <input type="email" id="firstName" class="form-control" name="email"
                                               placeholder="Ex : johndoe@gmail.com">
                                    </div>
                                    <div class="form-group has-danger">
                                        <label class="control-label">Password</label>
                                        <input type="password" id="lastName"
                                               class="form-control form-control-danger"
                                               name="password"
                                               placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Gender</label>
                                        <select class="form-control custom-select" name="gender">
                                            <option>Male</option>
                                            <option>Female</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Phone</label>
                                        <input type="text" id="lastName" class="form-control"
                                               name="phone"
                                               placeholder="Ex : 08521234123">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Job</label>
                                        @php($jobs = ['Student','Business','Researcher','Author','Professional'])
                                        <select class="form-control custom-select" name="job">
                                            @foreach($jobs as $job)
                                                <option>{{ $job }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Role</label>
                                        <select class="form-control custom-select" name="role">
                                            <option>Makelar</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">University</label>
                                        <input type="text" id="lastName" class="form-control"
                                               name="university"
                                               placeholder="Ex : Institut Teknologi Sepuluh Nopember">
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary mr-1" type="submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
