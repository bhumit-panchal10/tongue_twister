@extends('layouts.front')


@section('title', "Blog")

@section('content')
    <style>
        .blog-card {
      transition: transform .3s, box-shadow .3s;
      /*background:#b80000;*/
      padding:10px;
      
    }
    .blog-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 24px rgba(0,0,0,.1);
    }
    .card-body {
        padding:0.75rem;
    }
    
    .card-body .description {
        padding:5px 0;
    }
    h5{
        font-size:18px;
        color:#000;
    }
    
    .card-body h5 a {
        color:#000 ;
    }
    
    .card-body h5 a:hover {
        color:#b80000;
    }
    
    .blog-card img {
      width: 100%;
      height: 220px;
      object-fit: cover;
    }
    
    .blog-meta {
      font-size: .85rem;
      color: #777;
    }
    .pagination .page-link {
      color: #b80000;
    }
    .pagination .page-item.active .page-link {
      background-color: #b80000;
      border-color: #b80000;
    }
    
    button{
        background:#b80000;
        color:#fff !important;
        padding:5px 10px;
        margin:5px 0;
        border:1px solid #b80000;
    }
    </style>

   <!--breadcrumbs area start-->
<div class="breadcrumbs_area">
        <div class="container">   
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <h3>Blog</h3>
                        <ul>
                            <li><a href="{{route('FrontIndex')}}">home</a></li>
                            <li>Blog</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>         
    </div>
    <!--breadcrumbs area end-->


    <!-- Blog Listing -->
  <section class="py-5">
    <div class="container">
      <div class="row g-4 ">
        
        @foreach ($blogs as $blog)
            <div class="col-12 col-md-6 col-lg-4 mt-2">
              <div class="card blog-card h-100">
                <img src="{{ asset('Blog/Thumbnail/' . '/' . $blog->strPhoto) }}" class="card-img-top" alt="{{ $blog->strTitle }}">
                <div class="card-body">
                  <p class="blog-meta mb-2">{{ date('M d, Y', strtotime($blog->created_at)) }} </p>
                  <h5 class="">
                      <a href="{{ route('front.blog_detail', $blog->strSlug) }}" class="" title="{{ $blog->strTitle }}">
                        {{ \Illuminate\Support\Str::words(strip_tags($blog->strTitle), 10, '...') }}
                      </a>
                  </h5>
                  <p class="description">
                      {{ \Illuminate\Support\Str::words(strip_tags($blog->strDescription), 20, '...') }}
                  </p>
                  <button class="add-to-cart"><a class="text-white" href="{{ route('front.blog_detail', $blog->strSlug) }}">Read
                    More</a></button>
                </div>
              </div>
            </div>
        @endforeach       

      </div>

      <!-- Pagination -->
      <nav aria-label="Blog pagination" class="mt-5">
        <ul class="pagination justify-content-center">
          {{ $blogs->links() }}
        </ul>
      </nav>
    </div>
  </section>
@endsection
