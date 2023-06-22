@extends('layout.dashboard.app')
@section('login')
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                    <div class="login-brand">
                        <img src="{{ asset('assets/dashboard/img/stisla.svg') }}" alt="logo" width="100"
                             class="shadow-light rounded-circle">
                    </div>

                    <div class="card card-primary">
                        <div class="card-header"><h4>Register</h4></div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate="">
                                @csrf
                                @if(Session::has('failed'))
                                    <div class="alert alert-danger">{{ Session::get('failed') }}</div>
                                @elseif(Session::has('success'))
                                    <div class="alert alert-success">{{ Session::get('success') }}</div>
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
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" placeholder="First Name" name="first_name"
                                           value="{{ old('first_name') }}">
                                </div>
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" placeholder="Last Name" name="last_name"
                                           value="{{ old('last_name') }}">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" placeholder="Email" name="email"
                                           value="{{ old('email') }}">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" placeholder="Password" name="password">
                                </div>
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" class="form-control" placeholder="Phone" name="phone"
                                           value="{{ old('phone') }}">
                                </div>
                                <div class="form-group">
                                    <label>Gender</label>
                                    <select class="form-control" name="gender">
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Job</label>
                                    <select class="form-control" name="job">
                                        <option>Student</option>
                                        <option>Business</option>
                                        <option>Researcher</option>
                                        <option>Author</option>
                                        <option>Professional</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>University</label>
                                    <input type="text" class="form-control"
                                           placeholder="Ex : Institut Teknologi Sepuluh Nopember" name="university"
                                           value="{{ old('university') }}">
                                </div>
                                <div class="form-group">
                                    <label>Subject Area</label>
                                    <select class="form-control" name="category">
                                        <option disabled selected>Pilih Subject Area</option>
                                        @foreach($categories as $category)
                                            <option
                                                value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select class="form-control" name="sub_category" id="sub-category"
                                            title="Pilih Category">
                                        <option disabled selected>Pilih Kategori</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="form-check-label">
                                        <label>Role</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" placeholder="University"
                                               name="role[]"
                                               value="reviewer" @if(old('role')){{ in_array('reviewer',old('role')) ? 'checked' : '' }}@endif>
                                        <div class="form-check-label">Reviewer</div>
                                        <input type="checkbox" class="form-check-input" placeholder="University"
                                               name="role[]"
                                               value="editor" @if(old('role')){{ in_array('editor',old('role')) ? 'checked' : '' }}@endif>
                                        <div class="form-check-label">Editor</div>
                                    </div>
                                </div>
                                <div class="d-none" id="url-editor">
                                    <div class="form-group">
                                        <label>Orcid ID</label>
                                        <input type="text" class="form-control" placeholder="Orcid ID"
                                               name="orcid_id"
                                               value="{{ old('orcid_id') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Scopus URL</label>
                                        <input type="text" class="form-control" placeholder="Scopus URL"
                                               name="scopus_url"
                                               value="{{ old('scopus_url') }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Sinta URL</label>
                                        <input type="text" class="form-control" placeholder="Sinta URL" name="sinta_url"
                                               value="{{ old('sinta_url') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        Register
                                    </button>
                                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg btn-block"
                                       tabindex="4">
                                        Login
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="simple-footer">
                        Copyright &copy; Stisla 2018
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            if ($('input[type="checkbox"]:checked').val() == 'reviewer') {
                $('#url-editor').removeClass('d-none')
            }
        })
        $('input[type="checkbox"]').change(function () {
            if ($(this).val() == 'reviewer') {
                if (this.checked) {
                    $('#url-editor').removeClass('d-none')
                } else {
                    $('#url-editor').addClass('d-none')
                }
            }
        })

        $('select[name="category"]').change(function (e) {
            $.get({
                url: '{{ url('/sub-categories') }}/' + $(this).val(),
                success: (response) => {
                    $('#sub-category').empty();

                    if (response.data.subcategories.length > 0) {
                        $.each(response.data.subcategories, function (key, subcategories) {
                            $('#sub-category').append('<option value="' + subcategories.id + '">' + subcategories.name + '</option>')
                        });
                    } else {
                        $('#sub-category').append('<option disabled selected>Belum ada kategori</option>')
                    }
                }
            })
        })
    </script>
@endsection
