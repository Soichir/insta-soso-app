<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    private $post;
    private $category;

    public function __construct(Post $post, Category $category){
        $this->post = $post;
        $this->category = $category;
    }

    public function create(){
        //retrieve all the categories
        //use the categories in create.blade.php
        $all_categories = $this->category->all();
        return view('users.posts.create')->with('all_categories', $all_categories);
    }

    public function store(Request $request){
        #1 validate
         $request->validate([
            'category'     =>  'required|array|between:1,3',
            'description'  =>  'required|min:1|max:1000',
            'image'        =>  'required|mimes:jpg,jpeg,png,gif|max:1048'

         ]);
         #2 recieved all data from form
         $this->post->user_id = Auth::user()->id; // store the id of the user who created the post
         $this->post->description = $request->description;
         $this->post->image       = 'data:image/' . $request->image->extension() . ';base64,' . 
         base64_encode(file_get_contents($request->image));
         $this->post->save(); // INSERT INTO posts(user_id, image, description) VALUES('Auth::user()->id', '$image', '$request->description' )

         #3 Save categories
         foreach($request->category as $category_id){
            $category_post[] = ['category_id' => $category_id];
            //1 - Food, 2 - Travel,, 3 - Lifestyle
            //$category_post[1, 2, 3]
         }
         //This line will insert the post_id and category_id PIVOT into the category_post table in the database
         $this->post->categoryPost()->createMany($category_post);
         //createMany() ---> requires that we have a ['key'=> 'value'] pair of data

         //Given/Data:
         //$this->post->id(2)
         //$request->category[1,2,3]

         //after the $this->post->categoryPost()
         //$category_post = [
         //['post_id' => 1, 'category_id' => 1 ],
         //['post_id' => 1, 'category_id' => 2 ],
         //['post_id' => 1, 'category_id' => 3 ]
         //];

         #4 Go back to homepage
         return redirect()->route('index');

    }

    public function show($id){
        $post = $this->post->findOrFail($id);
        return view('users.posts.show')->with('post', $post);
    }

    public function edit($id){
        $post = $this->post->findOrFail($id);

        //if the AUTH user is not the owner of the post, redirect to homepage
        if(Auth::user()->id != $post->user->id){
            return redirect()->route('index');
        }

        //retrieved all the categories
        $all_categories = $this->category->all();

        //Get all the categries of this post and save it in an array
        $selected_categories = []; //This is an emptyarray for now

        foreach($post->categoryPost as $category_post){ //categoryPost is from Post.php
            $selected_categories[] = $category_post->category_id;
        } 

        return view('users.posts.edit')
        ->with('post', $post) //coming from line 73, it conteins entire row of data from DB
        ->with('all_categories', $all_categories) //from line 81, it contains all categories from DB
        ->with('selected_categories', $selected_categories); //from line 877, after the loop the array will have all the categories under this post
    }

    public function update(Request $request, $id){
        #1. Validate the data from the form
        $request->validate([
            'category' => 'required|array|between:1,3',
            'description' => 'required|min:1|max:1000',
            'image' => 'mimes:jpeg.png,jpeg,gif|max:1048'
        ]);

        #2. Update the post

        $post = $this->post->findOrFail($id);
        $post->description = $request->description;

        //if there is a new image...
        if($request->image){
            $post->image = 'data:image/' . $request->image->extension(). ';base64' . base64_encode(file_get_contents($request->image));
        }

        $post->save();

        #3. Delte all the records from category_post related to this post
        $post->categoryPost()->delete();
        //Equivalent: DELETE FROM category_post WHERE post_id = $id
        //Use relationship Post::categoryPost to select the records related to a post

        #4. Save the new categories to category
        foreach($request->category as $category_id){
            $category_post[] = ['category_id' => $category_id];
        }

        $post->categoryPost()->createMany($category_post);

        #5. Redirect to show Post Page (To confirm the update)
        return redirect()->route('post.show', $id);
    }

    public function destroy($id){
        
        // $this->post->forceDelete($id);
        $post = $this->post->findOrFail($id);
        $post->forceDelete();

        return redirect()->route('index');
    }

    
    
}
