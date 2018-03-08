<?php

/*--------------------------------------------------------------------------------------------------
	2017-04-10 15:02:24 <moxerian@gmail.com>
--------------------------------------------------------------------------------------------------*/
function main_menu()
{
	$ci =& get_instance();
	$ci->load->helper('url');
	$class = $ci->uri->segment(1);
	$func = $ci->uri->segment(2);

	$str = '';

	$str .= '<ul class="sidebar-menu">'
		. '<li class="header">MAIN NAVIGATION</li>'
		. '<li class="treeview '. (($class == 'file') ? 'active' : '') .'">'
		. '<a class="hand">'
		. '<i class="fa fa-folder"></i> <span>File Management</span>'
		. '<span class="pull-right-container">'
		. '<i class="fa fa-angle-left pull-right"></i>'
		. '</span>'
		. '</a>'
		. '<ul class="treeview-menu">'
		. '<li '. (($func == 'listing') ? 'class="active"' : '') .'><a href="'. $ci->config->item('uri_files_list') .'"><i class="fa fa-list"></i>'. $ci->lang->line('menu_file_list') .'</a></li>'
		. '<li '. (($func == 'form') ? 'class="active"' : '') .'><a href="'. $ci->config->item('uri_files_form') .'"><i class="fa fa-edit"></i>'. $ci->lang->line('menu_file_form') .'</a></li>'
		. '</ul>'
		. '</li>'
		. '<li class="treeview '. (($class == 'lkploclassification') ? 'active' : '') .'">'
		. '<a class="hand">'
		. '<i class="fa fa-dot-circle-o"></i> <span>'. $ci->lang->line('menu_lookup') .'</span>'
		. '<span class="pull-right-container">'
		. '<i class="fa fa-angle-left pull-right"></i>'
		. '</span>'
		. '</a>'
		. '<ul class="treeview-menu">'
		. '<li><a href="'. $ci->config->item('uri_lookup_list_file_loc') .'"><i class="fa fa-circle-o"></i> '. $ci->lang->line('menu_lkp_file_loc') .'</a></li>'
		. '<li><a href="'. $ci->config->item('uri_lookup_list_file_cat') .'"><i class="fa fa-circle-o"></i> '. $ci->lang->line('menu_lkp_file_cat') .'</a></li>'
		. '<li><a href="'. $ci->config->item('uri_lookup_list_file_vol') .'"><i class="fa fa-circle-o"></i> '. $ci->lang->line('menu_lkp_file_vol') .'</a></li>'
		. '<li><a href="'. $ci->config->item('uri_lookup_list_doc_pic') .'"><i class="fa fa-circle-o"></i> '. $ci->lang->line('menu_lkp_doc_pic') .'</a></li>'
		. '</ul>'
		. '</li>'
		. '<li class="treeview">'
		. '<a class="hand">'
		. '<i class="fa fa-user-circle"></i> <span>Users</span>'
		. '<span class="pull-right-container">'
		. '<i class="fa fa-angle-left pull-right"></i>'
		. '</span>'
		. '</a>'
		. '<ul class="treeview-menu">'
		. '<li><a href="#" class="uc"><i class="fa fa-users"></i> Current Users</a></li>'
		. '<li><a href="#" class="uc"><i class="fa fa-users"></i> Pending Users</a></li>'
		. '<li><a href="#" class="uc"><i class="fa fa-users"></i> Inactive Users</a></li>'
		. '<li><a href="#" class="uc"><i class="fa fa-user-plus"></i> Add New User</a></li>'
		. '</ul>'
		. '</li>'
		. '</ul>';
	return $str;
}
