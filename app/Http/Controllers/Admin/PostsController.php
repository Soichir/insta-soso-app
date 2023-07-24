<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    private $post;

    public function __construct(Post $post){
        $this->post = $post;
    }

    public function index(){
        $all_posts = $this->post->withTrashed()->latest()->paginate(5);
        // $all_deleted = $this->showDelete();

        return view('admin.posts.index')->with('all_posts', $all_posts);
                                        // ->with('all_deleted', $all_deleted);
    }

    public function destroy($id){
        $this->post->destroy($id);
        return redirect()->back();
    }

    public function unhide($id){
        // onlyTrashed() - select the soft deleted records only
        // restore() - reserves the soft delete / delete_at column will become NULL
        $this->post->onlyTrashed()->findOrFail($id)->restore();
        return redirect()->back();
    }

    // private function showDelete(){
    //     $deleted_post = $this->post->onlyTrashed()->get(); 
    //     foreach($deleted_post as $post){
    //         if($post->user->id === Auth::user()->id){
    //             $all_deleted[] = $post;
    //         }
    //     }
    //     return $all_deleted;
    // }

    //onlyTrashed() can get only softdeleted recoreds
    //withTrashed() can get all records along with softdeleted recoreds
}
