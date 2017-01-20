<?php

namespace Taggers\Events\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Taggers\Events\Models\EventCategory;
use Illuminate\Foundation\Validation\ValidatesRequests;

class EventCategoriesController extends Controller
{
    use ValidatesRequests;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = EventCategory::all();

        return view('events::eventcategories.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required'
        ]);

        $category = EventCategory::create([
            'title' => $request->input('title')
        ]);

        flash('Category has been added successfully.', 'success');
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = EventCategory::find($id);

        return view('events::eventcategories.edit', compact('category'))->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required'
        ]);

        $category = EventCategory::find($id);
        $category->title = $request->input('title');
        $category->save();

        flash('Category has been updated successfully.', 'success');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = EventCategory::find($id);
        $category->delete();
        
        flash('Category has been deleted successfully.', 'success');
        return back();
    }
}
