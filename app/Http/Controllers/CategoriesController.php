<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Attachment;
use App\AttachmentCategory;

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
        if ($categories->count() > 0) {
            return view('Categories/list',compact('categories'));
        }else{
            return redirect()->route('categories.create');
        }
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
        $categoryId = Category::create($input)->id;
        if($request->filled('attachment')){
            $attach_id = $request->input('attachment');
            AttachmentCategory::create(['attachment_id' => $attach_id, 'category_id' => $categoryId]);
            dropImgAttachments($category);
        }
        return redirect()->route('categories.show', $categoryId);
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
        $category->save();
        if($request->filled('attachment')){
            $attach_id = $request->input('attachment');
            $this->dropImgAttachments($category);
            AttachmentCategory::create(['attachment_id' => $attach_id, 'category_id' => $category->id]);
        }
        return redirect()->route('categories.show', $category->id);
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
        return redirect('categories.index');
    }

    public function dropImgAttachments($category){
        $images = $category->attachments->where('type', 'main_img');
        foreach($images as $image){
            $image->delete();
        }
    }

}
