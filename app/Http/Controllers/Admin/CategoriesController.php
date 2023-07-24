<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{
    private $category;

    public function __construct(Category $category){
        $this->category = $category;
    }

    public function index(){
        $all_categories = $this->category->latest()->get();
        return view('admin.categories.index')->with('all_categories', $all_categories);
    }

    public function create(Request $request){
        $this->category->name = ucfirst($request->name);
        $this->category->save();
        

        return redirect()->back();
    }

    public function destroy($id){
        $this->category->destroy($id);
        return redirect()->route('admin.categories');
    }

   // $category = $this->category->findOrFail($id)
}
