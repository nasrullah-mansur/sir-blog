@extends('front.leyout.layout', [$title = $blog->title])

@push('page_css')
    <link rel="stylesheet" href="{{asset('front/css/pages/blog.css')}}">
@endpush

@push('custom_page_css')
@if ($blog->custom_css)
    <style>
        {!! $blog->custom_css !!}
    </style>
    @endif
@endpush




@section('content')
<!-- Page banner start -->
<div class="page-banner" style="background-image: url({{ asset('front/images/banner-bg.jpg') }});">
  <div class="container">
      <h2>{{ $blog->title }}</h2>
  </div>
</div>
<!-- Page banner end -->
   <!-- Blog section start -->
   <section class="blog-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="single-blog">
                    <div class="single-blog-title">
                        <h2>{{ $blog->title }}</h2>
                        <a href="{{ route('up.blog.by.category', $blog->category->slug) }}" class="category">
                          {{$blog->category->title}}
                      </a>
                      <span class="time">
                          <i class="far fa-calendar"></i>
                          {{$blog->created_at->format('d M Y')}}
                      </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9">
                <div class="single-blog">
                    
                    <img class="w-100 img-fluid" src="{{ asset($blog->image) }}" alt="{{$blog->title}}">
                    <div class="description">
                        <p>{{$blog->content}}</p>
                    </div>

                    <div class="details">
                        {!! $blog->details !!}
                    </div>

                    <div class="next-prev">
                        <ul>
                          @if ($previous_blog)
                          <li>
                              <a href="{{ route('single.up.blog', $previous_blog->slug) }}">
                                  <span>Previous blog</span>
                                  <p>{{ $previous_blog->title }}</p>
                              </a>
                          </li>
                          @endif
                          @if ($next_blog)
                          <li class="text-lg-end">
                              <a href="{{route('single.up.blog', $next_blog->slug)}}">
                                  <span>Next blog</span>
                                  <p>{{ $next_blog->title }}</p>
                              </a>
                          </li>
                          @endif
                        </ul>
                    </div>

                    <div class="also-like">
                        <h3>You may also like</h3>
                        <div class="row">
                          @foreach ($other_blogs as $like)
                          <div class="col-lg-4">
                            <div class="blog-item">
                                <div class="img">
                                    <a href="{{route('single.up.blog', $like->slug)}}">
                                        <img class="img-fluid w-100" src="{{ asset($like->image) }}" alt="{{$like->title}}" />
                                    </a>
                                </div>
                                <div class="blog-text">
                                    <div class="blog-content">
                                        <h3 class="mb-0">
                                            <a href="{{route('single.up.blog', $like->slug)}}">{{ $like->title }}</a>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                          @endforeach
                        </div>
                    </div>
                    <div class="comment comment-section">
                        <h3>Our Comment</h3>
                        <ul>
                            @forelse ($comments as $comment)
                            <li>
                                <div class="item">
                                    <div class="icon">
                                        <i class="far fa-comment-alt"></i>
                                    </div>
                                    <div class="contant">
                                        <div class="title">
                                            <h4>{{ $comment->name }} <a data-pid="{{ $comment->id }}" href="#"><i class="fas fa-reply"></i></a> </h4>
                                            <span>{{ $comment->created_at->format('d M Y') }}</span>
                                        </div>
                                        <div class="text">
                                            <p>{{ $comment->comment }}</p>
                                        </div>
                                    </div>
                                </div>
                                @if (count($comment->replies) > 0)
                                    <ul>
                                        @foreach ($comment->replies as $reply)
                                        <li>
                                            <div class="item">
                                                <div class="icon">
                                                    <i class="far fa-comment-alt"></i>
                                                </div>
                                                <div class="contant">
                                                    <div class="title">
                                                        <h4>{{ $reply->name }} @if($loop->last) <a data-pid="{{ $comment->id }}" href="#"><i class="fas fa-reply"></i></a> @endif</h4>
                                                        <span>{{ $reply->created_at->format('d M Y') }}</span>
                                                    </div>
                                                    <div class="text">
                                                        <p>{{ $reply->comment }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                            @empty
                                <p>No comment found</p>
                            @endforelse
                            
                            
                        </ul>

                        <h3 class="comment-title" id="comment-form">
                            <span id="reply-text">Leave a reply</span> 
                            <a id="close-reply" href="#"><i class="fas fa-times"></i></a>
                        </h3>
                        <div class="comment-form">
                            <form action="{{ route('comment.upcoming.store') }}" method="POST">
                                @csrf
                                <div class="text">
                                    <textarea name="comment" placeholder="Write your text here..."></textarea>
                                    @if ($errors->has('comment'))
                                        <small class="error-msg">{{ $errors->first('comment') }}</small>
                                    @endif
                                </div>
                                <div class="inputs">
                                    <div class="input-box">
                                        <input type="text" name="name" placeholder="Your name">
                                        @if ($errors->has('name'))
                                        <small class="error-msg">{{ $errors->first('name') }}</small>
                                    @endif
                                    </div>
                                    <div class="input-box">
                                        <input type="email" name="email" placeholder="Your email">
                                        @if ($errors->has('email'))
                                        <small class="error-msg">{{ $errors->first('email') }}</small>
                                    @endif
                                    </div>
                                </div>

                                <div class="submit pb-3">
                                    <input type="hidden" id="pid" name="p_id" value="0">
                                    <input type="hidden" name="blog_id" value="{{$blog->id}}">
                                    <button type="submit">Post Comment</button>
                                </div>
                                
                            </form>
                        </div>
                    </div>

                    <div class="comment-alert">
                        @if ($errors->any())
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Sorry!</strong> Something went wrong, Please try again. 
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @elseif(Session::has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Well Done</strong> Your comment has been sent successfully, Please wait for confirmation.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        

                    </div>
                </div>

            </div>
            <div class="col-lg-3">
              <div class="right-sidebar">
                  @if ($sidebar)
                  <div class="sidebar-item">
                      <div class="cta">
                          <img src="{{ asset($sidebar->image) }}" alt="{{$sidebar->content}}" />
                          <p>{{ $sidebar->content }}</p>
                          <a href="{{$sidebar->btn_link}}">{{$sidebar->btn_text}}</a>
                      </div>
                  </div>
                  @endif
                  <div class="sidebar-item">
                      <div class="category">
                          <h4>Categories</h4>
                          <ul>
                              @foreach ($categories as $category)
                              <li>
                                  <a href="{{route('up.blog.by.category', $category->slug)}}">
                                      <span>{{ $category->title }}</span>
                                      <span>({{$category->blogs->count()}})</span>
                                  </a>
                              </li>
                              @endforeach
                          </ul>
                      </div>
                  </div>
                 
                  <div class="sidebar-item">
                    
                    @include('front.components.get_access_form')
                </div>

                  {{-- @foreach (single_blog_add() as $add)
                    <div class="sidebar-item">
                        <a href="{{$add->link}}" class="add">
                            <img class="img-fluid w-100" src="{{asset($add->image)}}" alt="{{$add->title}}" />
                        </a>
                    </div>
                    @endforeach --}}
              </div>
          </div>
        </div>
    </div>
</section>
<!-- Blog section end -->
@endsection