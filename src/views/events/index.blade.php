@extends('admin.layouts.master')

@section('title', 'List All Events')

@section('page-title', 'List All Events')

@section('breadcrumb')
<li><a href="{{ route('events.index') }}">Events</a></li>
<li class="active">All Events</a></li>
@endsection

@section('content')

<div class="row">
    <div class="col-xs-12">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">List of all events</h3>
            </div>

            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th class="col-sm-2 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($events as $event)
                            <tr>
                                <td>{{ $event->title }}</td>
                                <td>{{ $event->categoryString() }}</td>
                                <td>{!! $event->statusString() !!}</td>
                                <td class="text-center">
                                    {!! Form::open(['route' => ['events.destroy', $event->id], 'method' => 'DELETE', 'data-confirm' => 'Are you sure you want to delete this event?']) !!}
                                        <a data-toggle="tooltip" title="Edit" href="{{ route('events.edit', $event->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                        <button data-toggle="tooltip" title="Delete" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $(".table").DataTable();
    });
</script>
@endsection