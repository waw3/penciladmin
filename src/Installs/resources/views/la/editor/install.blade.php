@extends('pa.layouts.app')

@section("contentheader_title", "PA Code Editor")
@section("contentheader_description", "Installation instructions")
@section("section", "PA Code Editor")
@section("sub_section", "Not installed")
@section("htmlheader_title", "Install PA Code Editor")

@section('main-content')

<div class="box">
	<div class="box-header">

	</div>
	<div class="box-body">
		<p>PencilAdmin Code Editor does not comes inbuilt now. You can get it by following commands.</p>
		<pre><code>composer require waw/paeditor</code></pre>
		<p>This will download the editor package. Not install editor by following command:</p>
		<pre><code>php artisan pa:editor</code></pre>
		<p>Now refresh this page or go to <a href="{{ url(config('penciladmin.adminRoute') . '/paeditor') }}">{{ url(config('penciladmin.adminRoute') . '/paeditor') }}</a>.</p>
	</div>
</div>

@endsection

@push('styles')

@endpush

@push('scripts')
<script>
$(function () {

});
</script>
@endpush
