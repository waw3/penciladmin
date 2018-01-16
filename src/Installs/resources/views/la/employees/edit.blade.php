@extends("pa.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('penciladmin.adminRoute') . '/employees') }}">Employee</a> :
@endsection
@section("contentheader_description", $employee->$view_col)
@section("section", "Employees")
@section("section_url", url(config('penciladmin.adminRoute') . '/employees'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Employees Edit : ".$employee->$view_col)

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
				{!! Form::model($employee, ['route' => [config('penciladmin.adminRoute') . '.employees.update', $employee->id ], 'method'=>'PUT', 'id' => 'employee-edit-form']) !!}
					@pa_form($module)
					
					{{--
					@pa_input($module, 'name')
					@pa_input($module, 'designation')
					@pa_input($module, 'gender')
					@pa_input($module, 'mobile')
					@pa_input($module, 'mobile2')
					@pa_input($module, 'email')
					@pa_input($module, 'dept')
					@pa_input($module, 'city')
					@pa_input($module, 'address')
					@pa_input($module, 'about')
					@pa_input($module, 'date_birth')
					@pa_input($module, 'date_hire')
					@pa_input($module, 'date_left')
					@pa_input($module, 'salary_cur')
					--}}
					<div class="form-group">
						<label for="role">Role* :</label>
						<select class="form-control" required="1" data-placeholder="Select Role" rel="select2" name="role">
							<?php $roles = App\Role::all(); ?>
							@foreach($roles as $role)
								@if($role->id != 1 || Entrust::hasRole("SUPER_ADMIN"))
									@if($user->hasRole($role->name))
										<option value="{{ $role->id }}" selected>{{ $role->name }}</option>
									@else
										<option value="{{ $role->id }}">{{ $role->name }}</option>
									@endif
								@endif
							@endforeach
						</select>
					</div>
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <a href="{{ url(config('penciladmin.adminRoute') . '/employees') }}" class="btn btn-default pull-right">Cancel</a>
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
	$("#employee-edit-form").validate({
		
	});
});
</script>
@endpush
