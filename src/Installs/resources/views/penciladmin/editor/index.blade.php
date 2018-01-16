@extends('penciladmin.layouts.app')

@section('htmlheader_title')
	Code Editor
@endsection

@section('main-content')
<div id="pencileditor" class="row">
	<div class="col-md-2 col-sm-3">
		<div class="pa-header">
			PA Editor
			<!--<div class="pa-dir">/Applications/MAMP/htdocs</div>-->
		</div>
		<div class="pa-file-tree">

		</div>
	</div>
	<div class="col-md-10 col-sm-9">
		<ul class="pencileditor-tabs">

		</ul>
		<pre id="pa-ace-editor"></pre>
	</div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('pa-assets/plugins/jquery-filetree/jQueryFileTree.min.css') }}"/>
@endpush

@push('scripts')
<script src="{{ asset('pa-assets/plugins/jquery-filetree/jQueryFileTree.min.js') }}"></script>
<script src="{{ asset('pa-assets/plugins/ace/ace.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="{{ asset('pa-assets/plugins/ace/ext-modelist.js') }}" type="text/javascript" charset="utf-8"></script>

<script>
var $openFiles = [];
var pencileditor = null;
var cntFile;
var modelist = ace.require("ace/ext/modelist");
var $laetabs = $(".pencileditor-tabs");

$(function () {
	// Start Jquery File Tree
	$('.pa-file-tree').fileTree({
		root: '/',
		script: "{{ url(config('penciladmin.adminRoute') . '/pencileditor_get_dir?_token=' . csrf_token()) }}"
	}, function(file) {
		openFile(file);
		// do something with file
		// $('.selected-file').text( $('a[rel="'+file+'"]').text() );
	});

	// Start Ace editor
	pencileditor = ace.edit("pa-ace-editor");
    pencileditor.setTheme("ace/theme/twilight");
    pencileditor.session.setMode("ace/mode/javascript");
	pencileditor.$blockScrolling = Infinity;
	pencileditor.commands.addCommand({
		name: 'save',
		bindKey: {win: "Ctrl-S", "mac": "Cmd-S"},
		exec: function(editor) {
			// console.log("saving", editor.session.getValue());
			saveFileCode(cntFile, editor.session.getValue(), false);
		}
	});

	setEditorSize();

	$(window).resize(function() {
		setEditorSize();
	});
});
function setEditorSize() {
	var windowHeight = $(window).height();
	var editorHeight = windowHeight-50-31;
	var treeHeight = windowHeight-70-21;
	// console.log("windowHeight	: "+windowHeight);
	// console.log("editorHeight: "+editorHeight);
	// console.log("treeHeight: "+treeHeight);

	$(".pa-file-tree").height(treeHeight+"px");
	$("#pa-ace-editor").css("height", editorHeight+"px");
	$("#pa-ace-editor").css("max-height", editorHeight+"px");
}

$(".pencileditor-tabs").on("click", "li i.fa", function(e) {
	filepath = $(this).parent().attr("filepath");
	closeFile(filepath);
	e.stopPropagation();
});
$(".pencileditor-tabs").on("click", "li", function(e) {
	filepath = $(this).attr("filepath");
	openFile(filepath);
	e.stopPropagation();
});

function openFile(filepath) {
	var fileFound = fileContains(filepath);
	// console.log("openFile: "+filepath+" fileFound: "+fileFound);

	loadFileCode(filepath, false);
	// console.log($openFiles);
}

function closeFile(filepath) {
	// console.log("closeFile: "+filepath);
	// $openFiles[getFileIndex(filepath)] = null;
	var index = getFileIndex(filepath);
	// console.log("index: "+index);
	$openFiles.splice(index, 1);
	$laetabs.children("li[filepath='"+filepath+"']").remove();
	// console.log($openFiles);

	if(index != 0 && $openFiles.length != 0) {
		openFile($openFiles[index-1].filepath);
	} else {
		pencileditor.setValue("", -1);
		pencileditor.focus();
		pencileditor.session.setMode("ace/mode/text");
		cntFile = "";
	}
}

function loadFileCode(filepath, reload) {
	// console.log("loadFileCode: "+filepath+" contains: "+fileContains(filepath));
	if(!fileContains(filepath)) {
		$.ajax({
			url: "{{ url(config('penciladmin.adminRoute') . '/pencileditor_get_file?_token=' . csrf_token()) }}",
			method: 'POST',
			data: {"filepath": filepath},
			async: false,
			success: function( data ) {
				//console.log(data);
				pencileditor.setValue(data, -1);
				pencileditor.focus();

				var mode = modelist.getModeForPath(filepath).mode;
				pencileditor.session.setMode(mode);

				// $openFiles[getFileIndex(filepath)].filedata = data;
				// $openFiles[getFileIndex(filepath)].filemode = mode;

				$file = {
					"filepath": filepath,
					"filedata": data,
					"filemode": mode
				}
				$openFiles.push($file);
				var filename = filepath.replace(/^.*[\\\/]/, '');
				$laetabs.append('<li filepath="'+filepath+'">'+filename+' <i class="fa fa-5x fa-times"></i></li>');
				highlightFileTab(filepath);
			}
		});
	} else {
		// console.log("File found offline");
		var data = $openFiles[getFileIndex(filepath)].filedata;
		pencileditor.setValue(data, -1);
		pencileditor.focus();
		var mode = modelist.getModeForPath(filepath).mode;
		pencileditor.session.setMode(mode);
		highlightFileTab(filepath);
	}
}

function saveFileCode(filepath, filedata, reload) {
	//console.log("saveFileCode: "+filepath);
	if(filepath != "") {
		$(".pencileditor-tabs li[filepath='"+filepath+"'] i.fa").removeClass("fa-times").addClass("fa-spin").addClass("fa-refresh");

		$.ajax({
			url: "{{ url(config('penciladmin.adminRoute') . '/pencileditor_save_file?_token=' . csrf_token()) }}",
			method: 'POST',
			data: {
				"filepath": filepath,
				"filedata": filedata
			},
			success: function( data ) {
				// console.log(data);
				$(".pencileditor-tabs li[filepath='"+filepath+"'] i.fa").removeClass("fa-spin").removeClass("fa-refresh").addClass("fa-times");
			}
		});
	}
}

function highlightFileTab(filepath) {
	cntFile = filepath;
	$laetabs.children("li").removeClass("active");
	$laetabs.children("li[filepath='"+filepath+"']").addClass("active");
}

function getFileIndex(filepath) {
	for (var i=0; i < $openFiles.length; i++) {
		if($openFiles[i].filepath == filepath) {
			return i;
		}
	}
}

function fileContains(filepath) {
	for (var i=0; i < $openFiles.length; i++) {
		if($openFiles[i].filepath == filepath) {
			return true;
		}
	}
	return false;
}

</script>
@endpush
