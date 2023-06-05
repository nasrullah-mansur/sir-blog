@extends('front.leyout.layout')

@push('custom_page_css')

<style>
    .custom-contact {
        padding: 50px 0 30px;
    }
</style>

    <style>
        {!! $page->css !!}
    </style>
@endpush

@push('page_css')
    <link rel="stylesheet" href="{{asset('front/css/pages/blog.css')}}">
@endpush


@push('custom_page_js')
    <script>
        {!! $page->javascript !!}
    </script>
@endpush

@section('content')
<!-- Page banner start -->
<div class="page-banner" style="background-image: url({{ asset($page->image ? $page->image : 'front/images/banner-bg.jpg') }});">
    <div class="container">
        <h2>{{ $page->name }}</h2>
    </div>
</div>
<!-- Page banner end -->


<!-- Blog section start -->
   <section class="blog-page">
    <div class="container">
        
        <div class="row">
            <div class="col-lg-9">
                <div class="single-blog">
                    {!! $page->html !!}
                </div>
            </div>
            <div class="col-lg-3">
              <div class="right-sidebar">
                <div class="sidebar-item">
                    @include('front.components.get_access_form')
                </div>
              </div>
          </div>
        </div>
    </div>
</section>
<!-- Blog section end -->
@endsection