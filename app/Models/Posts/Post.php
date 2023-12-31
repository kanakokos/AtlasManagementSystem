<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
        'user_id',
        'post_title',
        'post',
    ];

    public function user(){
        return $this->belongsTo('App\Models\Users\User');
    }

    public function postComments(){
        return $this->hasMany('App\Models\Posts\PostComment');
    }

    //多対多
    public function subCategories(){
        // return $this->belongsToMany(\App\Models\Categories\SubCategory::class, 'sub_category_id');
        return $this->belongsToMany('App\Models\Categories\SubCategory', 'post_sub_categories', 'post_id', 'sub_category_id');
    }


    // コメント数
    public function commentCounts($post_id){
        return Post::with('postComments')->find($post_id)->postComments();
    }
    public function commentCount()
{
    return $this->postComments()->count();
}



    // いいねのリレーション
    public function likes(): HasMany
    {
        return $this->hasMany('App\Models\Posts\Like', 'like_post_id');
    }

    // いいねの数を取得するメソッド
    public function likeCount()
    {
        return $this->likes()->count();
    }

}
