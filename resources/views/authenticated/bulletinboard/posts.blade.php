@extends('layouts.sidebar')

@section('content')
<div class="board_area w-100 m-auto d-flex">
  <div class="post_view w-75 mt-5">
    <p class="w-75 m-auto">投稿一覧</p>
    @foreach($posts as $post)
    <div class="post_area border w-75 m-auto p-3">
      <p style="color:gray;"><span style="color: gray;">{{ $post->user->over_name }}</span><span class="ml-3"  style="color: gray;">{{ $post->user->under_name }}</span>さん</p>
      <p><a href="{{ route('post.detail', ['id' => $post->id]) }}" style="color: black;">{{ $post->post_title }}</a></p>
      <div class="post_bottom_area">
        <div class="d-flex post_status">
          @foreach($post->subCategories as $subCategory)
            <p class="category_btn">{{ $subCategory->sub_category }}</p>
          @endforeach
          <div class="mr-5 count">
            <i class="fa fa-comment"></i><span class="">{{ $post->commentCount() }}</span>
          </div>
          <div>
            @if(Auth::user()->is_Like($post->id))
            <p class="m-0"><i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $post->likeCount() }}</span></p>
            @else
            <p class="m-0"><i class="fas fa-heart like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ $post->likeCount() }}</span></p>
            @endif
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="other_area w-25">
    <div class="m-4">
      <div style="width:250px; background-color:#03AAD2; border-radius:10px; text-align: center;"><a href="{{ route('post.input') }}" style="color: white; text-decoration: none; display: block; padding: 5px;">投稿</a></div>
      <div class="search-container">
        <input type="text" placeholder="キーワードを検索" name="keyword" form="postSearchRequest">
        <input type="submit" value="検索" form="postSearchRequest">
      </div>
      <input type="submit" name="like_posts" value="いいねした投稿" class="custom-button like-button" form="postSearchRequest">
      <input type="submit" name="my_posts" value="自分の投稿" class="custom-button my-posts-button" form="postSearchRequest">

      <div class="category-container">
        <p style="margin-top:30px;">カテゴリー検索</p>
        @foreach($categories as $category)
          <div class="category-header" onclick="toggleSubCategories(this)" style="margin-top:20px;">
            <span>{{ $category->main_category }}</span>
            <span class="icon">▼</span>
          </div>
          <div class="sub-categories" style="display: none;">
            @foreach($category->subCategories as $subCategory)
                <input type="submit" name="categories_posts" value="{{ $subCategory->sub_category }}" form="postSearchRequest">
            @endforeach
          </div>
        @endforeach
      </div>


    </div>
  </div>
  <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
</div>
@endsection
