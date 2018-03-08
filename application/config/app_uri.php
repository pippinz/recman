<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*--------------------------------------------------------------------------------------------------
Application links
--------------------------------------------------------------------------------------------------*/

/* Create a CI object to retrieve the config values */
$CI =& get_instance();

$config['uri_base_url'] = $CI->config->item('base_url');
$config['uri_active'] = rtrim($config['uri_base_url'], '/') . $_SERVER['REQUEST_URI'];

$config['uri_home'] = $config['uri_base_url'];

/* Search */
$config['uri_search'] = $config['uri_base_url'] . '/search/';

$config['uri_register'] = $config['uri_base_url'] . '/register/';
$config['uri_auth'] = $config['uri_base_url'] . '/auth/';
$config['uri_login'] = $config['uri_base_url'] . '/auth/login/';
$config['uri_logout'] = $config['uri_base_url'] . '/auth/logout/';
$config['uri_change_password'] = $config['uri_base_url'] . '/auth/change_password/';

$config['uri_files'] = $config['uri_base_url'] . '/files/';
$config['uri_files_list'] = $config['uri_files'] . 'listing/';
$config['uri_files_form'] = $config['uri_files'] . 'form/';
$config['uri_files_del'] = $config['uri_files'] . 'delete/';
$config['uri_files_jfu'] = $config['uri_files'] . 'jfu/';
$config['uri_files_json'] = $config['uri_files'] . 'json/';
$config['uri_files_jfu_show'] = $config['uri_files'] . 'jfu_view/';
$config['uri_files_doc_form'] = $config['uri_files'] . 'document/';
$config['uri_files_doc_del'] = $config['uri_files'] . 'delete/';

$config['uri_lookup'] = $config['uri_base_url'] . '/lookup/';
$config['uri_lookup_list'] = $config['uri_lookup'] . 'listing/';
$config['uri_lookup_list_file_loc'] = $config['uri_lookup_list'] . 'file.location/';
$config['uri_lookup_list_file_cat'] = $config['uri_lookup_list'] . 'file.category/';
$config['uri_lookup_list_file_vol'] = $config['uri_lookup_list'] . 'file.volume/';
$config['uri_lookup_list_doc_pic'] = $config['uri_lookup_list'] . 'document.pic/';
$config['uri_lookup_form'] = $config['uri_lookup'] . 'form/';
$config['uri_lookup_del'] = $config['uri_lookup'] . 'delete/';

// Reports
$config['uri_reports'] = $config['uri_base_url'] . '/reports/';
$config['uri_reports_files'] = $config['uri_reports'] . 'files/';
$config['uri_reports_docs'] = $config['uri_reports'] . 'documents/';

/* End of file app_uri.php */
/* Location: ./system/application/config/app_uri.php */
