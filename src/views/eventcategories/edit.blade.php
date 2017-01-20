{!! Form::model($category, ['route' => ['eventcategories.update', $category->id], 'method' => 'PATCH', 'class' => 'event-category-form']) !!}
    <div class="box-body">
        <div class="form-group">
            {!! Form::label('title', 'Title') !!}
            {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter title here']) !!}
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit('Save', ['class' => 'btn btn-info pull-right']) !!}
    </div>
{!! Form::close() !!}