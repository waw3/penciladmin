@extends("pa.layouts.app")

@section("contentheader_title", "Organizations")
@section("contentheader_description", "Organizations listing")
@section("section", "Organizations")
@section("sub_section", "Listing")
@section("htmlheader_title", "Organizations Listing")

@section("headerElems")
@pa_access("Organizations", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Add Organization</button>
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

@pa_access("Organizations", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Add Organization</h4>
			</div>
			{!! Form::open(['action' => 'PA\OrganizationsController@store', 'id' => 'organization-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
                    @pa_form($module)
					
					{{--
					@pa_input($module, 'name')
					@pa_input($module, 'email')
					@pa_input($module, 'phone')
					@pa_input($module, 'website')
					@pa_input($module, 'assigned_to')
					@pa_input($module, 'connected_since')
					@pa_input($module, 'address')
					@pa_input($module, 'city')
					@pa_input($module, 'description')
					@pa_input($module, 'profile_image')
					@pa_input($module, 'profile')
					--}}
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
        ajax: "{{ url(config('penciladmin.adminRoute') . '/organization_dt_ajax') }}",
		language: {
			lengthMenu: "_MENU_",
			search: "_INPUT_",
			searchPlaceholder: "Search"
		},
		@if($show_actions)
		columnDefs: [ { orderable: false, targets: [-1] }],
		@endif
	});
	$("#organization-add-form").validate({
		
	});
});
</script>
@endpush
