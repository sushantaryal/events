@extends('admin.layouts.master')

@section('title', 'Edit Event')

@section('page-title', 'Edit Event')

@section('breadcrumb')
<li><a href="{{ route('events.index') }}">Events</a></li>
<li class="active">Add Event</a></li>
@endsection

@section('content')

<div class="row">
    {!! Form::model($event, ['route' => ['events.update', $event->id], 'method' => 'PATCH', 'class' => 'event-form', 'files' => true]) !!}
    <div class="col-sm-12 col-md-8">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Edit event</h3>
            </div>

            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('title', 'Title') !!}
                    {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter title here']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('event_date', 'Event Date') !!}
                    {!! Form::text('event_date', null, ['class' => 'form-control', 'placeholder' => 'Enter event date here']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('description', 'Description') !!}
                    {!! Form::textarea('description', null, ['class' => 'form-control summernote', 'placeholder' => 'Enter title here']) !!}
                </div>
            </div>
            <div class="box-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-info pull-right']) !!}
            </div>
        </div>

    </div>

    <div class="col-sm-12 col-md-4">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Categories</h3>
            </div>

            <div class="box-body">
                {!! Form::select('categories[]', $categories, $event->categories()->pluck('category_id')->all(), ['id' => 'categories', 'class' => 'form-control', 'multiple' => true, 'data-placeholder' => 'Select categories']) !!}
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Image</h3>
            </div>

            <div class="box-body">
                <div id="image-preview" @if($event->image_thumb) style="background-image:url('{{ asset($event->image_thumb) }}'); background-size: cover; background-position: center center" @endif>
                    <label for="image-upload" id="image-label">{{ $event->image_thumb ? 'Change Image' : 'Choose Image' }}</label>
                    {!! Form::file('image', ['id' => 'image-upload']) !!}
                </div>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Publish</h3>
            </div>

            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('status', 'Status', ['class' => 'col-md-2 contol-label']) !!}

                    <div class="col-md-10">
                        <label class="radio-inline">
                            {!! Form::radio('status', 1) !!} Publish
                        </label>
                        <label class="radio-inline">
                            {!! Form::radio('status', 0) !!} Unpublish
                        </label>
                    </div>
                </div>
            </div>
        </div>

    </div>
    {!! Form::close() !!}

</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $("#categories").select2();

        $('#event_date').datetimepicker({
            format: 'YYYY-MM-DD'
        });

        $('.event-form').validate({
            rules: {
                title: 'required'
            }
        });
    });
</script>
@endsection