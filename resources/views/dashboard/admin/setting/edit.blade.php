@extends('layout.dashboard.app')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Pengatuan</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    {{--                    <div class="breadcrumb-item"><a href="#">Bootstrap Components</a></div>--}}
                    {{--                    <div class="breadcrumb-item">Form</div>--}}
                </div>
            </div>
            <form method="POST" action="{{ route('dashboard.admin.setting.update',['slug' => $setting->slug]) }}">
                @csrf
                @method('put')
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
                                        <label class="control-label">Nama</label>
                                        <input type="text" id="firstName" class="form-control" name="name"
                                               value="{{ $setting->name }}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Nilai</label>
                                        <input type="text" id="firstName" class="form-control" name="value"
                                               value="{{ $setting->value }}"
                                               placeholder="Ex : Computer Science">
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
