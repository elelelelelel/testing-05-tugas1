@extends('layout.dashboard.app')
@section('content')
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
                <div class="row mt-sm-4">
                    <div class="col-12 col-md-12 col-lg-5">
                        <div class="card profile-widget">
                            <div class="profile-widget-header">
                                <img alt="image" src="{{ $user->avatar_url }}"
                                     class="rounded-circle profile-widget-picture">
                                <div class="profile-widget-items">
                                    <div class="profile-widget-item">
                                        <div class="profile-widget-item-label">Total Review</div>
                                        <div class="profile-widget-item-value">187</div>
                                    </div>
                                    <div class="profile-widget-item">
                                        <div class="profile-widget-item-label">Rating</div>
                                        <div class="profile-widget-item-value">6,8K</div>
                                    </div>
                                    <div class="profile-widget-item">
                                        <div class="profile-widget-item-label">Following</div>
                                        <div class="profile-widget-item-value">2,1K</div>
                                    </div>
                                </div>
                            </div>
                            <div class="profile-widget-description">
                                <div class="profile-widget-name">{{ $user->name }}
                                    <div class="text-muted d-inline font-weight-normal">
                                        <div class="slash"></div>
                                        {{ $user->job }}
                                    </div>
                                </div>
                                {{--                                {{ $user->name }} adalah <b>{{ $user->job }}</b>.--}}
                                <p><strong>Publikasi :</strong></p>
                                <ul>
                                    @if(!is_null($user->sinta_url))
                                        <li>
                                            <a href="{{ '//' . (strpos($user->sinta_url, '//') !== false ? substr($user->sinta_url, strpos($user->sinta_url, '//') + 2) : ltrim($user->sinta_url, '/')) }}"
                                               target="_blank">Sinta</a>
                                        </li>
                                    @endif
                                    @if(!is_null($user->scopus_url))
                                        <li>
                                            <a href="{{ '//' . (strpos($user->scopus_url, '//') !== false ? substr($user->scopus_url, strpos($user->scopus_url, '//') + 2) : ltrim($user->scopus_url, '/')) }}"
                                               target="_blank">Scopus</a>
                                        </li>
                                    @endif
                                    @if(!is_null($user->orcid_id))
                                        <li>
                                            <a href="{{ 'https://orcid.org/'.$user->orcid_id }}"
                                               target="_blank">Orcid</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-7">
                        <div class="card">
                            <form method="post" class="needs-validation" novalidate="">
                                <div class="card-header">
                                    <h4>Bidang</h4>
                                </div>
                                <div class="card-body">
                                    @foreach($user->subCategories as $i => $sub_categories)
                                        <div class="row">
                                            <div class="form-group col-md-6 col-12">
                                                <label>Subject Area</label>
                                                <input type="text" class="form-control"
                                                       value="{{ $sub_categories->category->name }}" disabled>
                                            </div>
                                            <div class="form-group col-md-6 col-12">
                                                <label>Category</label>
                                                <input type="text" class="form-control"
                                                       value="{{ $sub_categories->name }}" disabled>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
