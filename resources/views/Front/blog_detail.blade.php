@extends('layouts.front')

@section('opTag')
@section('title', "$Blog->metaTitle")
<meta name="description" content="{{ $Blog->metaDescription }}" />
<meta name="keywords" content="{{ $Blog->metaKeyword }} " />
<?php echo $Blog->head; ?>
<?php echo $Blog->body; ?>
@endsection

@section('content')

<style>
  p {
    text-align: justify;
  }

  a {
    color: #b80000;
  }

  a:hover {
    color: green;
  }

  .blog-detail h1 {
    font-size: 2rem;
    font-weight: 700;
  }

  .recent-posts {
    position: sticky !important;
    top: 100px !important;
  }


  .recent-posts img {
    width: 80px;
    height: 80px;
    object-fit: cover;
  }

  .recent-posts .recent-data {
    margin: 0 5px;
  }

  h1 {
    color: #b80000;
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

<!-- Content page -->
<main class="container my-5">
  <div class="row">
    <!-- Blog Detail Section -->
    <div class="col-lg-8 col-md-12">
      <article class="blog-detail mb-4">
        <h1 class="mb-3">{{ $Blog->strTitle }}</h1>
        <p class="text-muted mb-4"> {{ date('M d, Y', strtotime($Blog->created_at)) }}</p>
        <img src="{{ asset('Blog/Thumbnail/' . '/' . $Blog->strPhoto) }}" alt="{{ $Blog->strTitle }}"
          class="img-fluid rounded mb-4">
        
        {!! $Blog->strDescription !!}
      </article>
    </div>

    <!-- Sidebar Recent Posts -->
    <aside class="col-lg-4 col-md-12">
      <div class="recent-posts p-3 border rounded ">
        <h4 class="mb-4">Recent Posts</h4>
        
        @foreach ($RecentBlog as $blogs)
            <a href="{{ route('front.blog_detail', $blogs->strSlug) }}" class="text-decoration-none text-dark">
              <div class="recent-post d-flex mb-3">
                <img src="{{ asset('Blog/Thumbnail/' . '/' . $blogs->strPhoto) }}" class="rounded me-3" alt="{{ $blogs->strTitle }}">
                <div class="recent-data">
                  <a href="{{ route('front.blog_detail', $blogs->strSlug) }}" class="fw-bold d-block">{{ $blogs->strTitle }}</a>
                  <small class="text-muted">{{ date('M d, Y', strtotime($Blog->created_at)) }}</small>
                </div>
              </div>
            </a>
        @endforeach        

      </div>
    </aside>
  </div>
</main>

@endsection