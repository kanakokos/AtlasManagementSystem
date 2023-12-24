<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

use App\Models\Users\User;

class Subjects extends Model
{
    const UPDATED_AT = null;


    protected $fillable = [
        'subject'
    ];

    //多対多
    public function users(){
        return $this->belongsToMany(User::class);
        // リレーションの定義
    }
}
