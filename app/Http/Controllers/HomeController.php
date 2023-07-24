<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    private $post;
    private $user;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Post $post, User $user)
    {
        // $this->middleware('auth');
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //$all_posts = $this->post->latest()->get();
        //return view('users.home')->with('all_posts', $all_posts);

        $home_posts = $this->getHomePosts();
        $suggested_users = $this->getSuggestedUsers();
        return view('users.home')->with('home_posts', $home_posts)
                                 ->with('suggested_users', $suggested_users);
    }

    public function search(Request $request){
        //where(column_name, operator, searched_value)
        // % ~~ wildcard or anything before or after
        $user = $this->user->where('name', 'like', '%'.$request->search. '%')->get();
        return view('users.search')->with('users', $user)->with('search', $request->search);
    }

    #get the posts of the users that the Auth user is follwing
    public function getHomePosts(){
        $all_posts = $this->post->latest()->get();
        $home_posts = []; 

        foreach($all_posts as $post){
            if($post->user->isFollowed() || $post->user->id === Auth::user()->id){
                $home_posts[] = $post;
            }
        }
        return $home_posts;
    }
# GET the users that AUTH user is not following
    private function getSuggestedUsers(){
        $all_users = $this->user->all()->except(Auth::user()->id);
        $suggested_users = [];

        foreach($all_users as $user){
            if(!$user->isFollowed()){   // the user not followed by Auth user 
                $suggested_users[] = $user;
            }
        }

        return array_slice($suggested_users, 0, 5);
            // array_slice(x, y, z)
            // x ~~ array / array_name
            // y ~~ offset / starting index
            // z ~~ length / count / how many
        
    }
}
