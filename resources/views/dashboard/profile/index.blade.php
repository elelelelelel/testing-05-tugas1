@extends('layout.dashboard.app')
@section('breadcumb','Profile')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Profile</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Profile</div>
                </div>
            </div>
            <div class="section-body">
                @if(Session::has('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
                @if(Session::has('failed'))
                    <div class="alert alert-danger">{{ Session::get('failed') }}</div>
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
                <h2 class="section-title">Hi, {{ Auth::user()->name }}!</h2>
                <p class="section-lead">
                    Change information about yourself on this page.
                </p>

                <div class="row mt-sm-4">
                    <div class="col-12">
                        <div class="card profile-widget">
                            <div class="profile-widget-header">
                                <img alt="image" src="{{ Auth::user()->avatar_url }}"
                                     class="rounded-circle profile-widget-picture">
                            </div>
                            <div class="profile-widget-description">
                                <div class="profile-widget-name">{{ Auth::user()->name }}
                                    <div class="text-muted d-inline font-weight-normal">
                                        <div class="slash"></div>
                                        {{ Auth::user()->job }}
                                    </div>
                                </div>
                                @if(Auth::user()->isAn('reviewer') || Auth::user()->isAn('editor'))
                                    <div class="profile-widget-name">
                                        Saldo : Rp. {{ number_format(Auth::user()->balance) }}
                                    </div>
                                    <a href="{{ route('withdraw.index') }}" class="btn btn-primary">Riwayat
                                        Penarikan</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <form method="post" class="needs-validation" novalidate=""
                                  action="{{ route('profile.update') }}">
                                @csrf
                                <div class="card-header">
                                    <h4>Edit Profile</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-12 col-md-6 col-lg-6">
                                            <label class="col-md-12">First Name</label>
                                            <input type="text" placeholder="First Name"
                                                   class="form-control form-control-line"
                                                   name="first_name" value="{{ Auth::user()->first_name }}" disabled>
                                        </div>
                                        <div class="form-group col-12 col-md-6 col-lg-6">
                                            <label class="col-md-12">Last Name</label>
                                            <input type="text" placeholder="First Name"
                                                   class="form-control form-control-line"
                                                   name="last_name" value="{{ Auth::user()->last_name }}" disabled>
                                        </div>
                                        <div class="form-group col-12 col-md-6 col-lg-6">
                                            <label for="example-email" class="col-md-12">Email</label>
                                            <input type="email" placeholder="email"
                                                   class="form-control form-control-line" name="email"
                                                   value="{{ Auth::user()->email }}">
                                        </div>
                                        <div class="form-group col-12 col-md-6 col-lg-6">
                                            <label class="col-md-12">Password</label>
                                            <input type="password" placeholder="Password" name="password"
                                                   class="form-control form-control-line">
                                        </div>
                                        <div class="form-group col-12 col-md-6 col-lg-6">
                                            <label class="col-md-12">Phone</label>
                                            <input type="text" placeholder="Phone" name="phone"
                                                   class="form-control form-control-line"
                                                   value="{{ Auth::user()->phone }}">
                                        </div>
                                        <div class="form-group col-12 col-md-6 col-lg-6">
                                            <label class="col-sm-12">Gender</label>
                                            <select class="form-control form-control-line" name="gender">
                                                <option {{ Auth::user()->gender == 'Male'? 'selected' : '' }}>Male
                                                </option>
                                                <option {{ Auth::user()->gender == 'Female'? 'selected' : '' }}>
                                                    Female
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group col-12 col-md-6 col-lg-6">
                                            <label class="col-sm-12">Job</label>
                                            @php($jobs = ['Student','Business','Researcher','Author','Professional'])
                                            <select class="form-control form-control-line" name="job">
                                                @foreach($jobs as $job)
                                                    <option {{ $job == Auth::user()->job ? 'selected' : '' }}>{{ $job }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-12 col-md-6 col-lg-6">
                                            <label class="col-md-12">University</label>
                                            <input type="text" placeholder="University" name="university"
                                                   class="form-control form-control-line"
                                                   value="{{ Auth::user()->university }}">
                                        </div>
                                        @if(Auth::user()->isAn('reviewer') || Auth::user()->isAn('editor'))
                                            @foreach(Auth::user()->subCategories as $i => $sub_categories)
                                                <div class="form-group col-12 col-md-6 col-lg-6 div-categ-{{$i}}">
                                                    <label class="col-sm-12">Subject Area</label>
                                                    <select class="form-control form-control-line select-category"
                                                            name="category[]"
                                                            id="category-{{ $i }}"
                                                            data-index="{{ $i }}"
                                                            onchange="getCategory(this.value,{{ $i }})">
                                                        @foreach($categories as $category)
                                                            <option
                                                                value="{{ $category->id }}" {{ $sub_categories->category->id == $category->id ? 'selected': '' }}>{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-10 col-md-5 col-lg-5 div-categ-{{$i}}">
                                                    <label class="col-md-12">Category</label>
                                                    <select class="form-control form-control-line"
                                                            name="sub_category[]" id="sub-category-{{ $i }}"
                                                            data-index="{{ $i }}">
                                                        @foreach($sub_categories->category->subCategories as $sub)
                                                            <option
                                                                value="{{ $sub->id }}" {{ $sub_categories->id == $sub->id ? 'selected': '' }}>{{ $sub->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-2 col-md-1 col-lg-1 div-categ-{{$i}}">
                                                    <label class="col-md-12"></label>
                                                    <button class="btn btn-danger" type="button"
                                                            onclick="deleteRow({{$i}})"><i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                            @endforeach
                                            <div class="form-group col-12" id="add-category">
                                                <a href="#" id="btn-add-category">+ Tambah Kategory</a>
                                            </div>
                                            <div class="form-group col-12 col-md-6 col-lg-6">
                                                <label class="col-md-12">Role</label>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="role[]" class="custom-control-input"
                                                           id="reviewer"
                                                           value="reviewer" {{ Auth::user()->isAn('reviewer') ? 'checked disabled' : '' }}>
                                                    <label class="custom-control-label" for="reviewer">Reviewer</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="role[]" class="custom-control-input"
                                                           id="editor"
                                                           value="editor" {{ Auth::user()->isAn('editor') ? 'checked disabled' : '' }}>
                                                    <label class="custom-control-label" for="editor">Editor</label>
                                                </div>
                                            </div>
                                            <div class="form-group col-12 col-md-6 col-lg-6 url-editor d-none">
                                                <label class="col-md-12">Orcid ID</label>
                                                <input type="text" placeholder="Orcid ID"
                                                       name="orcid_id"
                                                       class="form-control form-control-line"
                                                       value="{{ Auth::user()->orcid_id }}">
                                            </div>
                                            <div class="form-group col-12 col-md-6 col-lg-6 url-editor d-none">
                                                <label class="col-md-12">Scopus URL</label>
                                                <input type="text" placeholder="Scopus URL" name="scopus_url"
                                                       class="form-control form-control-line"
                                                       value="{{ Auth::user()->scopus_url }}" {{ is_null(Auth::user()->scopus_url) ? '' : 'disabled' }}>
                                            </div>
                                            <div class="form-group col-12 col-md-6 col-lg-6 url-editor d-none">
                                                <label class="col-md-12">Sinta URL</label>
                                                <input type="text" placeholder="Sinta URL" name="sinta_url"
                                                       class="form-control form-control-line"
                                                       value="{{ Auth::user()->sinta_url }}" {{ is_null(Auth::user()->sinta_url) ? '' : 'disabled' }}>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
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
            if ($('input[name="role[]"]:checked').val() == 'reviewer') {
                $('.url-editor').removeClass('d-none')
            }
        })

        const category = function (id) {
            return `
            <div class="form-group col-12 col-md-6 col-lg-6 div-categ-${id}">
                                                    <label class="col-sm-12">Subject Area</label>
                                                    <select class="form-control form-control-line select-category" name="category[]"
                                                            id="category-${id}"
                                                            data-index="${id}"
                                                            onchange="getCategory(this.value,${id})">
                                                            <option disabled selected>Pilih Kategori</option>
@foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
            </select>
        </div>
        <div class="form-group col-10 col-md-5 col-lg-5 div-categ-${id}">
            <label class="col-md-12">Category</label>
            <select class="form-control form-control-line"
                    name="sub_category[]" id="sub-category-${id}"
                                                            data-index="${id}">

            </select>
        </div>
        <div class="form-group col-2 col-md-1 col-lg-1 div-categ-${id}">
                                                    <label class="col-md-12"></label>
                                                    <button class="btn btn-danger" type="button"
                                                    onclick="deleteRow(${id})"><i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
`
        }

        function getCategory(value, index) {
            $.get({
                url: '{{ url('/sub-categories') }}/' + value,
                success: (response) => {
                    $('#sub-category-' + index).empty();

                    if (response.data.subcategories.length > 0) {
                        $.each(response.data.subcategories, function (key, subcategories) {
                            $('#sub-category-' + index).append('<option value="' + subcategories.id + '">' + subcategories.name + '</option>')
                        });
                    } else {
                        $('#sub-category-' + index).append('<option disabled selected>Belum ada kategori</option>')
                    }
                }
            })
        }

        function deleteRow(id) {
            $('.div-categ-' + id).remove()
        }

        $(function () {

            $('input[name="role[]"]').change(function () {
                if ($(this).val() == 'reviewer') {
                    if (this.checked) {
                        $('.url-editor').removeClass('d-none')
                    } else {
                        $('.url-editor').addClass('d-none')
                    }
                }
            })

            $('#btn-add-category').click(function (e) {
                e.preventDefault();

                if ($('.select-category').length == 0) {
                    $('#add-category').before(category(0))
                } else {
                    let row_link = $('.select-category').last();
                    $('#add-category').before(category(row_link.data('index') + 1))
                    if ($('.select-category').length > 4) {
                        $(this).addClass('d-none')
                    }
                }
            })
        })
    </script>
@endsection
