<!DOCTYPE html>
<html lang="en">

@section('htmlheader')
	@include(penciladmin.layouts.partials.htmlheader')
@show
<body class="{{ Configs::getByKey('skin') }} {{ Configs::getByKey('layout') }} @if(Configs::getByKey('layout') == 'sidebar-mini') sidebar-collapse @endif" bsurl="{{ url('') }}" adminRoute="{{ config('penciladmin.adminRoute') }}">
<div class="wrapper">

	@include(penciladmin.layouts.partials.mainheader')

	@if(Configs::getByKey('layout') != 'layout-top-nav')
		@include(penciladmin.layouts.partials.sidebar')
	@endif

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		@if(Configs::getByKey('layout') == 'layout-top-nav') <div class="container"> @endif
		@if(!isset($no_header))
			@include(penciladmin.layouts.partials.contentheader')
		@endif

		<!-- Main content -->
		<section class="content {{ $no_padding or '' }}">
			<!-- Your Page Content Here -->
			@yield('main-content')
		</section><!-- /.content -->

		@if(Configs::getByKey('layout') == 'layout-top-nav') </div> @endif
	</div><!-- /.content-wrapper -->

	@include(penciladmin.layouts.partials.controlsidebar')

	@include(penciladmin.layouts.partials.footer')

</div><!-- ./wrapper -->

@include(penciladmin.layouts.partials.file_manager')

@section('scripts')
	@include(penciladmin.layouts.partials.scripts')
@show

</body>
</html>
