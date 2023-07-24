<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Block;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BlockController extends Controller
{
    private $block;

    public function __construct(Block $block){
        $this->block = $block;
    }

    public function store($user_id){
        $this->block->blocker_id = Auth::user()->id; //blocking user
        $this->block->blocking_id = $user_id;  //blocked user
        $this->block->save(); 

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
