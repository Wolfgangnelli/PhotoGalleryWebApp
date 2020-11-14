<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlbumCategoryRequest;
use App\Models\AlbumCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlbumCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $categories = AlbumCategory::getCategoriesByUserId(Auth::user())->paginate(env('RECORD_PER_PAGE'));
        $category = new AlbumCategory();
        return view('categories.index', ['categories' => $categories, 'category' => $category]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = new AlbumCategory();
  
        return view('categories.managecategory')->with('category', $category);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AlbumCategoryRequest $request)
    {
        $category = new AlbumCategory();
        $category->category_name = $request->category_name;
        $category->user_id = Auth::id();
        $res = $category->save();

        if ($request->expectsJson()) {
            return [
                'message' => $res ? 'Category created' : 'Category not created',
                'success' => (bool)$res,
                'data' => $category
            ];
        } else {

            return redirect()->route('categories.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(AlbumCategory $category)
    {
        return $category;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(AlbumCategory $category)
    {
        return view('categories.managecategory', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AlbumCategory $category)
    {
        $category->category_name = $request->category_name;
        $res = $category->save();

        if ($request->expectsJson()) {
            return [
                'message' => $res ? 'Category updated' : 'Category not updated',
                'success' => (bool)$res,
                'data' => $category
            ];
        } else {

            return redirect()->route('categories.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AlbumCategory $category, Request $req)
    {
     
        $res = $category->delete();
        if ($req->expectsJson()) {
            return [
                'message' => $res ? 'Category deleted' : 'Could not delete category',
                'success' => (bool)$res
            ];
        } else {
            return redirect()->route('categories.index');
        }
    }
}
