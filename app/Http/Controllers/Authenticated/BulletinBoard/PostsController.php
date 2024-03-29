<?php

namespace App\Http\Controllers\Authenticated\BulletinBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories\MainCategory;
use App\Models\Categories\SubCategory;
use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\Like;
use App\Models\Users\User;
use App\Http\Requests\BulletinBoard\PostFormRequest;
use Auth;

class PostsController extends Controller
{
    public function show(Request $request){
        $posts = Post::with('user', 'postComments')->get();
        $categories = MainCategory::get();
        $like = new Like;
        $post_comment = new Post;
        if(!empty($request->keyword)){
            $categories_posts = $request->categories_posts;
            $keyword = $request->keyword;
            $posts = Post::with('user', 'subCategories')
            ->whereHas('subCategories', function ($q) use ($categories_posts, $keyword) {
                $q->where('sub_categories.sub_category', 'like', '%' . $keyword . '%');
            })
            ->get();
            // $posts = Post::with('user', 'postComments')
            // ->where('post_title', 'like', '='.$request->keyword.'%')
            // ->orWhere('post', 'like', '='.$request->keyword.'=')->get();

        }else if($request->category_word){
            $sub_category = $request->category_word;
            $posts = Post::with('user', 'postComments')->get();
        }else if($request->like_posts){
            $likes = Auth::user()->likePostId()->get('like_post_id');
            $posts = Post::with('user', 'postComments')
            ->whereIn('id', $likes)->get();
        }else if($request->my_posts){
            $posts = Post::with('user', 'postComments')
            ->where('user_id', Auth::id())->get();
        //↓↓追加
        }else if($request->categories_posts){
            // dd($request);
            $categories_posts = $request->categories_posts;
            // dd($categories_posts);
            $posts = Post::with('user', 'subCategories')  //最終的に使うメソッド（リレーション）たち。指定したからと言ってwhereHasなしで使えるわけじゃない
            ->whereHas('subCategories', function($q) use ($categories_posts){  //whereHasがないとPostのカラム名しか↓で呼び出せない（逆にwhereHasがあれば中間テーブル、relation先も呼び出せる）
            $q->where('sub_categories.sub_category', $categories_posts);  //中間テーブルなどのカラム名の場合「テーブル名.カラム名」の記述になる（迷子になってしまうため）
            })
            ->get();
        }

        return view('authenticated.bulletinboard.posts', compact('posts', 'categories', 'like', 'post_comment'));
    }


    public function postDetail($post_id){
        $post = Post::with('user', 'postComments')->findOrFail($post_id);
        return view('authenticated.bulletinboard.post_detail', compact('post'));
    }


    public function postInput(){
        $main_categories = MainCategory::get();
        $sub_categories = SubCategory::get();
        return view('authenticated.bulletinboard.post_create', compact('main_categories', 'sub_categories'));
}



    //投稿
    public function postCreate(PostFormRequest $request){

    $post = Post::create([
        'user_id' => Auth::id(),
        'post_title' => $request->post_title,
        'post' => $request->post_body,
        // 'sub_category_id' => $request->sub_category_id,
]);
// dd($request->sub_category_id);
    // 中間テーブルにサブカテゴリーを追加
    $post->subCategories()->attach($request->sub_category_id);

    return redirect()->route('post.show');
}


    //投稿更新
    public function postEdit(Request $request){

        $request->validate([
            'post_title' => 'required|string|max:100',
            'post_body' => 'required|string|max:5000',
        ]);

        Post::where('id', $request->post_id)->update([
            'post_title' => $request->post_title,
            'post' => $request->post_body,
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }


    //投稿削除
    public function postDelete($id){
        Post::findOrFail($id)->delete();
        return redirect()->route('post.show');
    }


    //メインカテゴリーの登録
    public function mainCategoryCreate(Request $request){
        $request->validate([
            'main_category_name' => 'required|string|max:100|unique:main_categories,main_category',
        ]);

        MainCategory::create(['main_category' => $request->main_category_name]);
        return redirect()->route('post.input');
    }


    //サブカテゴリーの登録
    public function subCategoryCreate(Request $request){
        $request->validate([
            'main_category_id' => 'required|exists:main_categories,id',
            'sub_category_name' => [
                'required',
                'string',
                'max:100',
                // 同じ名前のサブカテゴリーは登録できない
                'unique:sub_categories,sub_category,NULL,id,main_category_id,' . $request->main_category_id,
            ],
        ]);

        SubCategory::create([
            'main_category_id' => $request->main_category_id,
            'sub_category' => $request->sub_category_name
        ]);
        return redirect()->route('post.input');
    }


    //コメント
    public function commentCreate(Request $request){

        $request->validate([
            'comment' => 'required|string|max:2500',
        ]);

        PostComment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }


    //自分の投稿絞り込み
    public function myBulletinBoard(){
        $posts = Auth::user()->posts()->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_myself', compact('posts', 'like'));
    }

    //いいねした投稿絞り込み
    public function likeBulletinBoard(){
        $like_post_id = Like::with('users')->where('like_user_id', Auth::id())->get('like_post_id')->toArray();
        $posts = Post::with('user')->whereIn('id', $like_post_id)->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_like', compact('posts', 'like'));
    }

    //サブカテゴリー絞り込み
    public function categoryBulletinBoard(){
        // dd($request);

        $sub_category_id = subCategory::with('posts')->where('sub_category_id')->get('categories_posts')->toArray();
        $posts = Post::with('user')->whereIn('id', $sub_category_id)->get();
        $subCategory = new subCategory;

        // $selectedSubCategory = $request->input('categories_posts');
        // $posts = SubCategory::where('sub_category', $selectedSubCategory)->first()->posts;
        // $posts = SubCategory::where('sub_category_id', $selectedSubCategory)->get();
        // $posts = Post::with('post')->whereIn('sub_category_id', $selectedSubCategory)->get();
        // $posts = Post::with('post')->whereIn('id', $selectedSubCategory)->get();

        return view('category.bulletin.board', compact('posts'));
    }

    //検索機能
    public function searchBulletinBoard(Request $request)
    {
        $keyword = $request->input('keyword');
        $subCategories = SubCategory::where("keyword", "=", $keyword)->get();
        return view('post.search', compact('posts', 'keyword'));
    }


    //いいね
    public function postLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->like_user_id = $user_id;
        $like->like_post_id = $post_id;
        $like->save();

        return response()->json();
    }

    public function postUnLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->where('like_user_id', $user_id)
            ->where('like_post_id', $post_id)
            ->delete();

        return response()->json();
    }
}
