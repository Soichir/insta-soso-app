<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Block;
use App\Models\Follow;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BlockController extends Controller
{
    private $block;
    private $follow;
    private $user;

    public function __construct(Block $block, Follow $follow, User $user){
        $this->block = $block;
        $this->follow = $follow;
        $this->user = $user;
    }

    public function store($user_id){
        $this->block->blocker_id = Auth::user()->id; //blocking user
        $this->block->blocking_id = $user_id;  //blocked user
        $this->block->save(); 
        // if($this->follow->where('follower_id', Auth::user()->id)->where('following_id', $user_id)->exists()){

        // }

        return redirect()->back();
    }

    public function blockFollow($user_id){
        $this->block->blocker_id = Auth::user()->id; //blocking user
        $this->block->blocking_id = $user_id;  //blocked user
        $this->block->save();

        $this->follow
             ->where('follower_id', Auth::user()->id)
             ->where('following_id', $user_id)
             ->delete();

        return redirect()->back();
    }

    public function destroy($user_id){
        $this->block
             ->where('blocker_id', Auth::user()->id)
             ->where('blocking_id', $user_id)
             ->delete();

        return redirect()->back();
    }

    
}
