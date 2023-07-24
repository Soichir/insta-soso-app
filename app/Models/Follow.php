<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;
    public $timestamps = false;

    #use this method to get the info of a follower
    #フォロワーのidを取得
    public function follower(){
        return $this->belongsTo(User::class, 'follower_id')->withTrashed();
    }

    #use this method to get the info of the user being followed
    #フォローされているユーザーのidを取得
    public function following(){
        return $this->belongsTo(User::class, 'following_id')->withTrashed();
    }

    #use this method to get the followers of a user
    // public function followers()

}
