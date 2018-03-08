<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*--------------------------------------------------------------------------------------------------
File management

	created 2017-04-08 16:35:13 <pippin.zaenul@gmail.com>
--------------------------------------------------------------------------------------------------*/
class Lookup extends CI_Controller {

	var $id;
	var $userid;
	var $username;
	var $aBreadcrumb;
	var $aPageTitle;
	var $aData;

	function __construct() 
	{

		parent::__construct();

		/* Load libraries */
		$this->load->library(array('app_html', 'app_util', 'session', 'form_validation', 'ion_auth'));

		/* Authentication */
		if (!$this->ion_auth->logged_in()) redirect($this->config->item('uri_login'));
		$this->username = $this->ion_auth->get_user_name();
		$this->userid = $this->ion_auth->get_user_id();

		/* Load account model */
		$this->load->model('General_model', 'gmodel');

		/* Load config */
		$this->load->config('app_uri');
		
		/* Load language for user attributes */
		$this->lang->load('general', 'english');
		$this->lang->load('lookup', 'english');

		/* Load helpers */
		$this->load->helper('url');
		$this->load->helper('language');
		$this->load->helper('date');
		$this->load->helper('form');
		$this->load->helper('file');

		/* Breadcrumb */
		$this->aBreadcrumb = array(
			'phrase' => array(
				0 => $this->lang->line('menu_lkp') 
			));

		/* Page title */
		$this->aPageTitle = array(
			'phrase' => array(
				0 => $this->lang->line('menu_file')
			)
		);
		
		/* Plugin */

		/* HTML head attributes */
		$this->aData['htmlheadattr'] = 
			$this->config->item('alte_bs_css') .
			$this->config->item('fontawesome_css') .
			$this->config->item('ionicons_css') .
			$this->config->item('alte_css') .
			$this->config->item('alte_skin_purple_css') .
			$this->config->item('app_css') .
			/* javascript, moved from the bottom page since the page content needs the jquery (and bootstrap) to be initialized first */
			$this->config->item('alte_jq_js') .
			$this->config->item('alte_bs_js') ;
		
		$this->aData['htmltailattr'] = 
			$this->config->item('alte_app_js') ;

		/* Default vars */
		$this->form_validation->set_error_delimiters('', '');
		$this->aData['filter'] = array();
		$this->aData['pcode'] = 'lookup';
		$this->aData['contentheader01'] = $this->lang->line('menu_lookup');
		//$this->aData['contentheader02'] = $this->lang->line('form');
		$this->aData['pagetitle'] = $this->aData['contentheader01'];
	}

	public function _remap($method, $params = array())
	{
		//$code = trim($this->uri->segment(1));
		$code = $method;
		$this->aBreadcrumb['phrase'][1] = $this->lang->line('menu_lookup');
		$this->aData['breadcrumb'] = $this->app_html->set_breadcrumb($this->aBreadcrumb);

		$this->aData['htmlheadattr'] .= 
			$this->config->item('alte_dttables_css') ;

		$this->aData['htmltailattr'] .= 
			$this->config->item('alte_dttables_js') .
			$this->config->item('alte_dttablesbs_js') .
			$this->config->item('alte_slimscroll_js') .
			$this->config->item('alte_fastclick_js') ;

		$aTmp = $this->gmodel->read(array(
			'table' => 'tb_lkp',
			'fields' => 'lkp, access, type, name, creator',
			'filter' => array(array('lkp', '=', $code))
			));
		$sBoxTitle = '';
		if ($aTmp['isrecord'])
		{
			$this->aData['sBoxTitle'] = $aTmp['name'];
		}
		
		$fqs = '';
		foreach ($_GET as $key => $val)
		{
			$val = $this->input->get($key);
			if ( !( $val === '' OR $key === 'offset' ) )
			{
				$this->aData['attr']['filter'][] = array( $key, '=', $val );
				$fqs = $fqs . $key . '='. $val . '&amp;';
			}
		}
		$fqs = ($fqs == '' ? '' : rtrim($fqs, '&amp;'));

		$this->aData['attr']['table'] = 'tb_lkpi';
		$this->aData['attr']['fields'] = 'id, lkp, num, str, name';
		$this->aData['attr']['filter'][] = array( 'lkp', '=', $method );
		$this->aData['attr']['filter'][] = array( 'creator', '=', $this->username );
		$this->aData['attr']['orderby'][] = array( 'id', 'name' );
		$aRec = $this->gmodel->listing( $this->aData['attr'] );
		$this->aData['record'] = $aRec['rec_list'];
		
		$listing['base_url'] = $this->config->item('uri_lookup');

		$listing['query_string_trail'] = $fqs;
		
		$this->template->load('alte', 'lookup_list', $this->aData);

	}

}