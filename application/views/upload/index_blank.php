<?php defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' ); ?>
<!DOCTYPE HTML>
<!--
/*
 * jQuery File Upload Plugin Demo
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */
-->
<html lang="en">
<head>
	<!-- Force latest IE rendering engine or ChromeFrame if installed -->
	<!--[if IE]>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<![endif]-->
	<meta charset="utf-8">
	<title>jQuery File Upload Demo</title>
	<meta name="description" content="File Upload widget with multiple file selection, drag&amp;drop support, progress bars, validation and preview images, audio and video for jQuery. Supports cross-domain, chunked and resumable file uploads and client-side image resizing. Works with any server-side platform (PHP, Python, Ruby on Rails, Java, Node.js, Go etc.) that supports standard HTML form file uploads.">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php
	echo $this->config->item('jfu_bs_css') .
		$this->config->item('jfu_style_css') . 
		$this->config->item('jfu_blueimp_gallery_css') . 
		$this->config->item('jfu_jqfu_css') . 
		$this->config->item('jfu_jqfu_ui_css') ;
		//$this->config->item('jfu_jqfu_noscript_css') . 
		//$this->config->item('jfu_jqfu_ui_noscript_css') ;
	?>
<style type="text/css">
#container{width:530px !important;}
</style>
</head>
<body>
<form id="myform" action="http://recordsmanager.loc/upload/blank_show" method="post">
<input type="submit" id="klik" name="klik" value="klik">
</form>

<div id="uploadview" style="width:530px;background-color:#eee;border:1px solid #ccc;">

</div>
<?php
echo $this->config->item('jfu_jq_js') . 
	$this->config->item('jfu_jq_ui_widget_js') . 
	$this->config->item('jfu_blueimp_tmpl_js') . 
	$this->config->item('jfu_blueimp_loadimgall_js') . 
	$this->config->item('jfu_blueimp_canvas2blob_js') . 
	$this->config->item('jfu_bs_js') . 
	$this->config->item('jfu_blueimp_gallery_js') . 
	$this->config->item('jfu_jq_iframe_transport_js') . 
	$this->config->item('jfu_jq_fileupload_js') . 
	$this->config->item('jfu_jq_fileupload_process_js') . 
	$this->config->item('jfu_jq_fileupload_image_js') . 
	$this->config->item('jfu_jq_fileupload_audio_js') . 
	$this->config->item('jfu_jq_fileupload_video_js') . 
	$this->config->item('jfu_jq_fileupload_validate_js') . 
	$this->config->item('jfu_jq_fileupload_ui_js') . 
	/*$this->config->item('jfu_main_js') . */
	$this->config->item('jfu_jq_xdr_transport_js') ;
?>
<script type="text/javascript">
$(function(){
	$('#myform').submit(function(e){
	var sAct = $(this).attr("action");
		e.preventDefault();
		$.ajax({
			url: sAct, 
			type: "POST",
			dataType: "html", 
			data: $('#myform').serialize(),
			success: function(uReturn){
				//var oRet = jQuery.parseJSON(uReturn);
				//$("#uploadview").slideDown('slow');
				$("#uploadview").html(uReturn);
				}
		});
	});
});
</script>

</body>
</html>