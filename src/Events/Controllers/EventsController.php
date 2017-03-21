<?php

namespace Taggers\Events\Controllers;

use Image;
use Illuminate\Http\Request;
use Taggers\Events\Models\Event;
use Illuminate\Routing\Controller;
use Taggers\Events\Models\EventCategory;
use Illuminate\Foundation\Validation\ValidatesRequests;

class EventsController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::with('categories')->get();

        return view('events::events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = EventCategory::pluck('title', 'id');

        return view('events::events.create', compact('categories'));
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

        $event = new Event;
        $event->title       = $request->input('title');
        $event->event_date  = $request->input('event_date');
        $event->end_date    = $request->input('end_date');
        $event->description = $request->input('description');
        $event->status      = $request->input('status');

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $path = 'uploads/events/';
            $extension = $image->getClientOriginalExtension();
            $filename = generateFilename($path, $extension);

            // Upload Original
            $image = Image::make($image)->save($path . $filename);
            // Upload thumbnail
            $thumbimage = Image::make($image)->fit(350)->save($path . 'thumbs/' . $filename);

            if($image && $thumbimage) {
                $event->image = $path . $filename;
                $event->image_thumb = $path . 'thumbs/' . $filename;
            }
        }

        if($event->save()) {
            if($request->has('categories')) {
                $event->categories()->attach($request->input('categories'));
            }
            flash('Event has been created successfully.', 'success');
            return back();
        }
        flash('Event cannot be created at this moment.', 'danger');
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
        $categories = EventCategory::pluck('title', 'id');
        $event = Event::with('categories')->find($id);

        return view('events::events.edit', compact('categories', 'event'));
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

        $event = Event::find($id);
        $event->title       = $request->input('title');
        $event->event_date  = $request->input('event_date');
        $event->end_date    = $request->input('end_date');
        $event->description = $request->input('description');
        $event->status      = $request->input('status');

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $path = 'uploads/events/';
            $extension = $image->getClientOriginalExtension();
            $filename = generateFilename($path, $extension);

            // Upload Original
            $image = Image::make($image)->save($path . $filename);
            // Upload thumbnail
            $thumbimage = Image::make($image)->fit(350)->save($path . 'thumbs/' . $filename);

            if($image && $thumbimage) {
                if($event->image && app('files')->exists($event->image)) {
                    app('files')->delete($event->image);
                    app('files')->delete($event->image_thumb);
                }

                $event->image = $path . $filename;
                $event->image_thumb = $path . 'thumbs/' . $filename;
            }
        }

        if($event->save()) {
            if($request->has('categories')) {
                $event->categories()->sync($request->input('categories'));
            }
            flash('Event has been updated successfully.', 'success');
            return back();
        }
        flash('Event cannot be updated at this moment.', 'danger');
        return back();
    }

    /**
     * Update publish status
     * 
     * @param  $id
     * @return Response
     */
    public function updateStatus($id)
    {
        $event = Event::find($id);
        $event->status = ($event->status == 1) ? 0 : 1;
        $event->save();
        
        flash('Status has been updated successfully.', 'success');
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
        $event = Event::find($id);
        $event->delete();

        flash('Event has been deleted successfully.', 'success');
        return back();
    }
}
