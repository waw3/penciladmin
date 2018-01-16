@extends("pa.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('penciladmin.adminRoute') . '/departments') }}">Department</a> :
@endsection
@section("contentheader_description", $department->$view_col)
@section("section", "Departments")
@section("section_url", url(config('penciladmin.adminRoute') . '/departments'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Departments Edit : ".$department->$view_col)

@section("main-content")

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="box">
	<div class="box-header">

	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				{!! Form::model($department, ['route' => [config('penciladmin.adminRoute') . '.departments.update', $department->id ], 'method'=>'PUT', 'id' => 'department-edit-form']) !!}
					@pa_form($module)

					{{--
					@pa_input($module, 'name')
					@pa_input($module, 'tags')
					@pa_input($module, 'color')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <a href="{{ url(config('penciladmin.adminRoute') . '/departments') }}" class="btn btn-default pull-right">Cancel</a>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
	$("#department-edit-form").validate({

	});
});
</script>
@endpush
