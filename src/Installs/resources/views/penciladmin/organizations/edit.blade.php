@extends("penciladmin.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('penciladmin.adminRoute') . '/organizations') }}">Organization</a> :
@endsection
@section("contentheader_description", $organization->$view_col)
@section("section", "Organizations")
@section("section_url", url(config('penciladmin.adminRoute') . '/organizations'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Organizations Edit : ".$organization->$view_col)

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
				{!! Form::model($organization, ['route' => [config('penciladmin.adminRoute') . '.organizations.update', $organization->id ], 'method'=>'PUT', 'id' => 'organization-edit-form']) !!}
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
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <a href="{{ url(config('penciladmin.adminRoute') . '/organizations') }}" class="btn btn-default pull-right">Cancel</a>
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
	$("#organization-edit-form").validate({
		
	});
});
</script>
@endpush
