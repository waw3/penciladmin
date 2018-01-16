@extends("pa.layouts.app")

@section("contentheader_title", "Employees")
@section("contentheader_description", "Employees listing")
@section("section", "Employees")
@section("sub_section", "Listing")
@section("htmlheader_title", "Employees Listing")

@section("headerElems")
@pa_access("Employees", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Add Employee</button>
@endpa_access
@endsection

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

<div class="box box-success">
	<!--<div class="box-header"></div>-->
	<div class="box-body">
		<table id="example1" class="table table-bordered">
		<thead>
		<tr class="success">
			@foreach( $listing_cols as $col )
			<th>{{ $module->fields[$col]['label'] or ucfirst($col) }}</th>
			@endforeach
			@if($show_actions)
			<th>Actions</th>
			@endif
		</tr>
		</thead>
		<tbody>
			
		</tbody>
		</table>
	</div>
</div>

@pa_access("Employees", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Add Employee</h4>
			</div>
			{!! Form::open(['action' => 'PA\EmployeesController@store', 'id' => 'employee-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
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
								@if($role->id != 1)
									<option value="{{ $role->id }}">{{ $role->name }}</option>
								@endif
							@endforeach
						</select>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				{!! Form::submit( 'Submit', ['class'=>'btn btn-success']) !!}
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endpa_access

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('pa-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('pa-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>
$(function () {
	$("#example1").DataTable({
		processing: true,
        serverSide: true,
        ajax: "{{ url(config('penciladmin.adminRoute') . '/employee_dt_ajax') }}",
		language: {
			lengthMenu: "_MENU_",
			search: "_INPUT_",
			searchPlaceholder: "Search"
		},
		@if($show_actions)
		columnDefs: [ { orderable: false, targets: [-1] }],
		@endif
	});
	$("#employee-add-form").validate({
		
	});
});
</script>
@endpush
