<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*--------------------------------------------------------------------------------------------------
	created 2011-07-21 12:36:05 <pippin.zaenul@gmail.com>
--------------------------------------------------------------------------------------------------*/

$ci =& get_instance();
$config['app_base_url']				= $ci->config->item('base_url') . '/';
$config['app_base_dir']				= $_SERVER['DOCUMENT_ROOT'] . '/';
$config['assets_dir']				= $config['app_base_url'] . 'assets/';

/*--------------------------------------------------------------------------------------------------
Application
--------------------------------------------------------------------------------------------------*/
$config['app_name']					= 'Records Manager Lite';
$config['app_version']				= '01.01';
$config['file_year_start']			= 1999;

/*--------------------------------------------------------------------------------------------------
Images
--------------------------------------------------------------------------------------------------*/
$config['img_dir']					= $config['assets_dir'] . 'img/';
$config['ico_add']					= '<img src="' . $config["img_dir"] . 'icon_add.gif" border="0" title="Add">';
$config['ico_info']					= '<img src="' . $config["img_dir"] . 'icon_info.gif" border="0" title="Info">';
$config['ico_edit']					= '<img src="' . $config["img_dir"] . 'icon_edit.gif" border="0" title="Edit">';
$config['ico_del']					= '<img src="' . $config["img_dir"] . 'icon_del.gif" border="0" title="Delete">';
$config['ico_submit']				= '<img src="' . $config["img_dir"] . 'icon_submit.gif" border="0" title="Submit">';

/*--------------------------------------------------------------------------------------------------
Template
--------------------------------------------------------------------------------------------------*/
$config['alte_code']				= 'alte';
$config['alte_dir']					= $config['app_base_url'] . 'tpl/' . $config['alte_code'] . '/';
$config['alte_plugins']				= $config['alte_dir'] . 'plugins/';
$config['alte_css']					= '<link rel="stylesheet" href="' . $config['alte_dir'] . 'dist/css/AdminLTE.min.css">';

$config['alte_skin_blue_css']		= '<link rel="stylesheet" href="' . $config['alte_dir'] . 'dist/css/skins/skin-blue.min.css">';
$config['alte_skin_purple_css']		= '<link rel="stylesheet" href="' . $config['alte_dir'] . 'dist/css/skins/skin-purple.min.css">';
$config['alte_skin_all_css']		= '<link rel="stylesheet" href="' . $config['alte_dir'] . 'dist/css/skins/_all-skins.min.css">';

$config['alte_jq_js']				= '<script src="'. $config['alte_plugins'] .'jQuery/jquery-2.2.3.min.js"></script>';
$config['alte_bs_css']				= '<link rel="stylesheet" href="'. $config['alte_dir'] .'bootstrap/css/bootstrap.min.css">';
$config['alte_bs_js']				= '<script src="'. $config['alte_dir'] .'bootstrap/js/bootstrap.min.js"></script>';
$config['alte_app_js']				= '<script src="'. $config['alte_dir'] .'dist/js/app.min.js"></script>';

$config['alte_icheck_js']			= '<script src="'. $config['alte_plugins'] .'iCheck/icheck.min.js"></script>';
$config['alte_icheck_sb_css']		= '<link rel="stylesheet" href="'. $config['alte_plugins'] .'iCheck/square/blue.css">'; // iCheck Square Blue css
$config['alte_icheck_all_css']		= '<link rel="stylesheet" href="'. $config['alte_plugins'] .'iCheck/all.css">'; // iCheck Square Blue css

$config['alte_datepicker3_css']		= '<link rel="stylesheet" href="'. $config['alte_plugins'] .'datepicker/datepicker3.css">';
$config['alte_daterangepicker_css']	= '<link rel="stylesheet" href="'. $config['alte_plugins'] .'daterangepicker/daterangepicker.css">';
$config['alte_datepicker_js']		= '<script src="'. $config['alte_plugins'] .'datepicker/bootstrap-datepicker.js"></script>';
$config['alte_timepicker_css']		= '<link rel="stylesheet" href="'. $config['alte_plugins'] .'timepicker/bootstrap-timepicker.min.css">';
$config['alte_colorpicker_css']		= '<link rel="stylesheet" href="'. $config['alte_plugins'] .'colorpicker/bootstrap-colorpicker.min.css">';

$config['alte_select2_css']			= '<link rel="stylesheet" href="'. $config['alte_plugins'] .'select2/select2.min.css">';
$config['alte_select2_js']			= '<script src="'. $config['alte_plugins'] .'select2/select2.full.min.js"></script>';

$config['alte_dttables_css']		= '<link rel="stylesheet" href="'. $config['alte_plugins'] .'datatables/dataTables.bootstrap.css">';
$config['alte_dttables_js']			= '<script src="'. $config['alte_plugins'] .'datatables/jquery.dataTables.min.js"></script>';
$config['alte_dttablesbs_js']		= '<script src="'. $config['alte_plugins'] .'datatables/dataTables.bootstrap.min.js"></script>';

$config['alte_slimscroll_js']		= '<script src="'. $config['alte_plugins'] .'slimScroll/jquery.slimscroll.min.js"></script>';
$config['alte_fastclick_js']		= '<script src="'. $config['alte_plugins'] .'fastclick/fastclick.js"></script>';


$config['app_paging']				= 50;
$config['app_form_required']		= '<font color="#cc0000">*</font>';
$config['breadcrumb_separator']		= '&nbsp;&nbsp&gt;&nbsp;&nbsp;';
$config['page_title_separator']		= ':&nbsp;&nbsp;';
$config['no_description']			= 'No Description';

$config['tpl']						= $config['alte_code'];

/*--------------------------------------------------------------------------------------------------
Directories & files
--------------------------------------------------------------------------------------------------*/
$config['dir_media']				= $config['app_base_dir'] . 'media/';
$config['dir_storage']				= $config['dir_media'] . 'storage/'; // Move to non http-request folder, outside public_html
$config['dir_uploads']				= $config['app_base_dir'] . 'uploads/';
$config['dir_uploads_file']			= $config['dir_uploads'] . 'files/';
$config['dir_uploads_file_mode']	= '0777';
$config['dir_thumbnail_code']		= 'thumbnail';
$config['dir_document_code']		= 'doc';

$config['image_extension']			= array("jpg", "jpeg", "gif", "png", "bmp");

/*--------------------------------------------------------------------------------------------------
Images
--------------------------------------------------------------------------------------------------*/
$config['img_usrt_160x160']			= '<img src="'. $config['alte_dir'] .'dist/img/user2-160x160.jpg" class="img-circle" alt="Wan Malek Wan Abdullah">';

/*--------------------------------------------------------------------------------------------------
Assets
--------------------------------------------------------------------------------------------------*/
$config['app_css']					= '<link rel="stylesheet" href="'. $config['assets_dir'] .'app.css">';
$config['fontawesome_css']			= '<link rel="stylesheet" href="'. $config['assets_dir'] .'font-awesome-4.7.0/css/font-awesome.min.css">';
$config['ionicons_css']				= '<link rel="stylesheet" href="'. $config['assets_dir'] .'ionicons-2.0.1/css/ionicons.min.css">';

/*--------------------------------------------------------------------------------------------------
jQuery File Upload of blueimp
--------------------------------------------------------------------------------------------------*/
$config['jfu_url']						= $config['assets_dir'] . 'jfu/';
$config['jfu_css_url']					= $config['jfu_url'] . 'css/';
$config['jfu_img_url']					= $config['jfu_url'] . 'img/';
$config['jfu_js_url']					= $config['jfu_url'] . 'js/';

$config['jfu_bs_css']					= '<link rel="stylesheet" href="' . $config['jfu_css_url'] . 'bootstrap.min.3-2-0.css">';
$config['jfu_style_css']				= '<link rel="stylesheet" href="' . $config['jfu_css_url'] . 'style.css">';
$config['jfu_blueimp_gallery_css']		= '<link rel="stylesheet" href="' . $config['jfu_css_url'] . 'blueimp-gallery.min.css">';
$config['jfu_jqfu_css']					= '<link rel="stylesheet" href="' . $config['jfu_css_url'] . 'jquery.fileupload.css">';
$config['jfu_jqfu_ui_css']				= '<link rel="stylesheet" href="' . $config['jfu_css_url'] . 'jquery.fileupload-ui.css">';
$config['jfu_jqfu_noscript_css']		= '<noscript><link rel="stylesheet" href="' . $config['jfu_css_url'] . 'jquery.fileupload-noscript.css"></noscript>';
$config['jfu_jqfu_ui_noscript_css']		= '<noscript><link rel="stylesheet" href="' . $config['jfu_css_url'] . 'jquery.fileupload-ui-noscript.css"></noscript>';

$config['jfu_jq_js']					= '<script src="'. $config['jfu_js_url'] .'jquery.min.1-11-3.js"></script>';
$config['jfu_jq_ui_widget_js']			= '<script src="'. $config['jfu_js_url'] .'vendor/jquery.ui.widget.js"></script>';
$config['jfu_jq_iframe_transport_js']	= '<script src="'. $config['jfu_js_url'] .'jquery.iframe-transport.js"></script>';
$config['jfu_jq_fileupload_js']			= '<script src="'. $config['jfu_js_url'] .'jquery.fileupload.js"></script>';
$config['jfu_jq_fileupload_process_js']	= '<script src="'. $config['jfu_js_url'] .'jquery.fileupload-process.js"></script>';
$config['jfu_jq_fileupload_image_js']	= '<script src="'. $config['jfu_js_url'] .'jquery.fileupload-image.js"></script>';
$config['jfu_jq_fileupload_audio_js']	= '<script src="'. $config['jfu_js_url'] .'jquery.fileupload-audio.js"></script>';
$config['jfu_jq_fileupload_video_js']	= '<script src="'. $config['jfu_js_url'] .'jquery.fileupload-video.js"></script>';
$config['jfu_jq_fileupload_validate_js']= '<script src="'. $config['jfu_js_url'] .'jquery.fileupload-validate.js"></script>';
$config['jfu_jq_fileupload_ui_js']		= '<script src="'. $config['jfu_js_url'] .'jquery.fileupload-ui.js"></script>';

$config['jfu_bs_js']					= '<script src="'. $config['jfu_js_url'] .'bootstrap.min.3-2-0.js"></script>';

$config['jfu_main_js']					= '<script src="'. $config['jfu_js_url'] .'main.js"></script>';

$config['jfu_blueimp_tmpl_js']			= '<script src="'. $config['jfu_js_url'] .'blueimp/tmpl.min.js"></script>';
$config['jfu_blueimp_loadimgall_js']	= '<script src="'. $config['jfu_js_url'] .'blueimp/load-image.all.min.js"></script>';
$config['jfu_blueimp_canvas2blob_js']	= '<script src="'. $config['jfu_js_url'] .'blueimp/canvas-to-blob.min.js"></script>';
$config['jfu_blueimp_gallery_js']		= '<script src="'. $config['jfu_js_url'] .'blueimp/jquery.blueimp-gallery.min.js"></script>';

// if (gte IE 8)&(lt IE 10)
$config['jfu_jq_xdr_transport_js']		= '<!--[if (gte IE 8)&(lt IE 10)]><script src="'. $config['jfu_js_url'] .'cors/jquery.xdr-transport.js"></script><![endif]-->';

// Combine it all (include Bootstrap CSS and jQuery from the Alte template configuration)
$config['jfu_head_inc']					= /*$config['jfu_bs_css'] .*/
										$config['jfu_style_css'] . 
										$config['jfu_blueimp_gallery_css'] . 
										$config['jfu_jqfu_css'] . 
										$config['jfu_jqfu_ui_css'] ;
										//$config['jfu_jqfu_noscript_css') . 
										//$config['jfu_jqfu_ui_noscript_css') ;

$config['jfu_tail_inc']					= /* $config['jfu_jq_js'] . already covered by jQuery defined in ALTE template */
										$config['jfu_jq_ui_widget_js'] . 
										$config['jfu_blueimp_tmpl_js'] . 
										$config['jfu_blueimp_loadimgall_js'] . 
										$config['jfu_blueimp_canvas2blob_js'] . 
										/* $config['jfu_bs_js'] . //already loaded by the template */
										$config['jfu_blueimp_gallery_js'] . 
										$config['jfu_jq_iframe_transport_js'] . 
										$config['jfu_jq_fileupload_js'] . 
										$config['jfu_jq_fileupload_process_js'] . 
										$config['jfu_jq_fileupload_image_js'] . 
										$config['jfu_jq_fileupload_audio_js'] . 
										$config['jfu_jq_fileupload_video_js'] . 
										$config['jfu_jq_fileupload_validate_js'] . 
										$config['jfu_jq_fileupload_ui_js'] . 
										/*moved to the correspondence view 
										$config['jfu_main_js'] . 
										*/
										$config['jfu_jq_xdr_transport_js'] ;

/*--------------------------------------------------------------------------------------------------
End Of - jQuery File Upload of blueimp
--------------------------------------------------------------------------------------------------*/



/* End of file app_config.php */
/* Location: ./application/config/app_config.php */