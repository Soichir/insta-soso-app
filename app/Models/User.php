<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    const ADMIN_ROLE_ID = 1;
    const USER_ROLE_ID = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // a user has many posts
    public function posts(){
        return $this->hasMany(Post::class)->latest();
    }

    #use this method to get all of the followers of the user
    // Dynamic property
    public function followers(){
        return $this->hasMany(Follow::class, 'following_id');
    }

    #use this method to get all the users that the user is following
    // Dynamic property
    public function following(){
        return $this->hasMany(Follow::class, 'follower_id');
    }

    //Static property
    public function isFollowed(){
        return $this->followers()->where('follower_id', Auth::user()->id)->exists();
        //Auth::user->id = the follower_id
        //Firstly, get all the followers of a user ($this->followers()), then from
        //that lists, search for the Auth user from the follower column
        //(Where('follower_id, Auth::user_id))
    }

    public function blockers(){
        return $this->hasMany(Block::class, 'blocking_id');
    }

    public function blocking(){
        return $this->hasMany(Block::class, 'blocker_id');
    }

    //ブロックしているユーザー
    public function isBlocked(){
        return $this->blockers()->where('blocker_id', Auth::user()->id)->exists();
    }
    
    //ブロックされているユーザー
    public function isBlocking(){
        return $this->blocking()->where('blocking_id', Auth::user()->id)->exists();
    }

    
}
