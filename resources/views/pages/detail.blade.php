@extends('layouts.app')

@section('title')
    Detail Travel
@endsection

@section('content')
    <main>
        <section class="section-details-header"></section>
        <section class="section-details-content">
            <div class="container">
                <div class="row">
                    <div class="col p-0 pl-3 pl-lg-0">
                        <nav aria-label="breadcumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item" aria-current="page">
                                    Paket Travel
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Details
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 pl-lg-0">
                        <div class="card card-details">
                            <h1>{{ $item->title }}</h1>
                            <p>{{ $item->location }}</p>
                            @if ($item->gallery->count())
                                <div class="gallery">
                                    <div class="xzoom-container">
                                        <img src="{{ Storage::url($item->gallery->first()->image) }}" class="xzoom"
                                            id="xzoom-default"
                                            xoriginal="{{ Storage::url($item->gallery->first()->image) }}" />
                                        <div class="xzoom-thumbs">
                                            @foreach ($item->gallery as $gallery)
                                                <a href="{{ Storage::url($gallery->image) }}">
                                                    <img src="{{ Storage::url($gallery->image) }}" class="xzoom-gallery"
                                                        width="128" xpreview="{{ Storage::url($gallery->image) }}" />
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <h2>Tentang Wisata</h2>
                            <p>
                                {!! $item->about !!}
                            </p>
                            <div class="features row pt-3">
                                <div class="col-md-4">
                                    <img src="{{ url('frontend/images/Features-1.png') }}" alt=""
                                        class="features-image" />
                                    <div class="description">
                                        <h3>Featured Event</h3>
                                        <p>{{ $item->featured_event }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4 border-left">
                                    <img src="{{ url('frontend/images/Features-2.png') }}" alt=""
                                        class="features-image" />
                                    <div class="description">
                                        <h3>Language</h3>
                                        <p>{{ $item->language }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4 border-left">
                                    <img src="{{ url('frontend/images/Features-3.png') }}" alt=""
                                        class="features-image" />
                                    <div class="description">
                                        <h3>Foods</h3>
                                        <p>{{ $item->foods }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card card-details card-right">
                            <h2>Members are going</h2>
                            <div class="members my-2">
                                <img src="{{ url('frontend/images/members-1.png') }}" class="member-image mr-1">
                                <img src="{{ url('frontend/images/members-2.png') }}" class="member-image mr-1">
                                <img src="{{ url('frontend/images/members-3.png') }}" class="member-image mr-1">
                                <img src="{{ url('frontend/images/members-4.png') }}" class="member-image mr-1">
                                <img src="{{ url('frontend/images/members-5.png') }}" class="member-image mr-1">
                            </div>
                            <hr>
                            <h2>Trip Informations</h2>
                            <table class="trip-informations">
                                <tr>
                                    <th width="50%">Date of Departure</th>
                                    <td width="50%" class="text-right">{{ \Carbon\Carbon::create($item->departure_date)->format('F n, Y') }}</td>
                                </tr>
                                <tr>
                                    <th width="50%">Duration</th>
                                    <td width="50%" class="text-right">{{ $item->duration }}</td>
                                </tr>
                                <tr>
                                    <th width="50%">Type</th>
                                    <td width="50%" class="text-right">{{ $item->type }}</td>
                                </tr>
                                <tr>
                                    <th width="50%">Price</th>
                                    <td width="50%" class="text-right">${{ $item->price }} / Person</td>
                                </tr>
                            </table>
                        </div>
                        <div class="join-container">
                        @auth
                        <form action="{{ route('checkout_process', $item->id) }}" method="post">
                            @csrf
                            <button class="btn btn-block btn-join-now mt-3 py-2" type="submit">
                                Join Now
                            </button>
                        </form>
                        @endauth
                        @guest
                          <a href="{{ route('login') }}" class="btn btn-block btn-join-now mt-3 py-2">
                              Login or Register to Join
                          </a>
                        @endguest
                      </div>
                    </div>
                </div>
        </section>
    </main>
@endsection

@push('prepend-style')
    <link rel="stylesheet" href="{{ url('frontend/libraries/xzoom/xzoom.css') }}" />
@endpush

@push('addon-script')
    <script src="{{ url('frontend/libraries/xzoom/xzoom.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.xzoom, .xzoom-gallery').xzoom({
                zoomWidth: 500,
                title: false,
                tint: '#333',
                Xoffset: 15
            });
        });
    </script>
@endpush
