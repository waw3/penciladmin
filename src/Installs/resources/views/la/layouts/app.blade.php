<!DOCTYPE html>
<html lang="en">

@section('htmlheader')
	@include('pa.layouts.partials.htmlheader')
@show
<body class="{{ PAConfigs::getByKey('skin') }} {{ PAConfigs::getByKey('layout') }} @if(PAConfigs::getByKey('layout') == 'sidebar-mini') sidebar-collapse @endif" bsurl="{{ url('') }}" adminRoute="{{ config('penciladmin.adminRoute') }}">
<div class="wrapper">

	@include('pa.layouts.partials.mainheader')

	@if(PAConfigs::getByKey('layout') != 'layout-top-nav')
		@include('pa.layouts.partials.sidebar')
	@endif

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		@if(PAConfigs::getByKey('layout') == 'layout-top-nav') <div class="container"> @endif
		@if(!isset($no_header))
			@include('pa.layouts.partials.contentheader')
		@endif
		
		<!-- Main content -->
		<section class="content {{ $no_padding or '' }}">
			<!-- Your Page Content Here -->
			@yield('main-content')
		</section><!-- /.content -->

		@if(PAConfigs::getByKey('layout') == 'layout-top-nav') </div> @endif
	</div><!-- /.content-wrapper -->

	@include('pa.layouts.partials.controlsidebar')

	@include('pa.layouts.partials.footer')

</div><!-- ./wrapper -->

@include('pa.layouts.partials.file_manager')

@section('scripts')
	@include('pa.layouts.partials.scripts')
@show

</body>
</html>
