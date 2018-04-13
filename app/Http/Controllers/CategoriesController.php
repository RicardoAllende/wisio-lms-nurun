<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('Categories/list',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Categories/form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->input();

        $path = $input['featured_image'];

        $categoryId = Category::create($input)->id;

        $this->uploadImageCategory($categoryId,$path);
        return redirect()->action('CategoriesController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('Categories/show',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('Categories/form',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $category->name = $request->name;
        $category->description = $request->description;
        $category->featured_image = $request->featured_image;
        $category->save();
        $this->uploadImageCategory($category->id,$request->featured_image);
        return redirect('/categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect('/categories');
    }

    public function uploadImage(Request $request){
        $imagePath = request()->file('file')->store('temps');
        echo $imagePath;
        
    }

    

    public function uploadImageCategory($categoryId,$path){

        //$arrPath = explode('.', $path);
        $newPath = 'categories/'.$categoryId.'/'.substr($path, strrpos($path, "/") + 1);
        Storage::move($path,"public/".$newPath);
        Storage::delete($path);
        $category= Category::find($categoryId);
        $category->featured_image = 'storage/'.$newPath;
        $category->save();

    }
}
