<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*--------------------------------------------------------------------------------------------------
File management

	created 2017-04-08 16:35:13 <pippin.zaenul@gmail.com>
--------------------------------------------------------------------------------------------------*/
class Reports extends CI_Controller {

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
		$this->load->library(array('app_html', 'app_util', 'session', 'ion_auth'));

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
		$this->lang->load('reports', 'english');

		/* Load helpers */
		$this->load->helper('url');
		$this->load->helper('language');
		$this->load->helper('date');
		$this->load->helper('form');
		$this->load->helper('file');

		/* Breadcrumb */
		$this->aBreadcrumb = array(
			'phrase' => array(
				0 => $this->lang->line('menu_reports') 
			));

		/* Page title */
		$this->aPageTitle = array(
			'phrase' => array(
				0 => $this->lang->line('menu_reports')
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
		$this->aData['filter'] = array();
		$this->aData['pcode'] = 'reports';
		$this->aData['contentheader01'] = $this->lang->line('menu_reports');
		$this->aData['pagetitle'] = $this->aData['contentheader01'];
		$this->aData['aLocation'] = $this->app_util->rs2arrkeyval($this->gmodel->listing(
			array(
				'table' => 'tb_lkpi',
				'fields' => 'str as id, name',
				'filter' => array(array('lkp', '=', 'file.location'), array('creator', '=', $this->username)), 
				'orderby' => array(array('name', 'ASC'))
				)
			)['rec_list']);
		$this->aData['aCategory'] = $this->app_util->rs2arrkeyval($this->gmodel->listing(
			array(
				'table' => 'tb_lkpi',
				'fields' => 'str as id, name',
				'filter' => array(array('lkp', '=', 'file.category'), array('creator', '=', $this->username)), 
				'orderby' => array(array('name', 'ASC'))
				)
			)['rec_list']);
		$this->aData['aVolume'] = $this->app_util->rs2arrkeyval($this->gmodel->listing(
			array(
				'table' => 'tb_lkpi',
				'fields' => 'str as id, name',
				'filter' => array(array('lkp', '=', 'file.volume'), array('creator', '=', $this->username)), 
				'orderby' => array(array('name', 'ASC'))
				)
			)['rec_list']);
		$this->aData['aPic'] = $this->app_util->rs2arrkeyval($this->gmodel->listing(
			array(
				'table' => 'tb_lkpi',
				'fields' => 'str as id, name',
				'filter' => array(array('lkp', '=', 'document.pic'), array('creator', '=', $this->username)), 
				'orderby' => array(array('name', 'ASC'))
				)
			)['rec_list']);
	}

	public function index()
	{
		$this->files();
	}

	public function files ($vuId = '')
	{
		$nId = (int) $vuId;
		if ( $nId == 0)
		{
			$this->aData['contentheader02'] = $this->lang->line('files');
			$this->aBreadcrumb['phrase'][1] = $this->lang->line('menu_file_list');
			$this->aData['breadcrumb'] = $this->app_html->set_breadcrumb($this->aBreadcrumb);

			$this->aData['htmlheadattr'] .= 
				$this->config->item('alte_dttables_css') ;

			$this->aData['htmltailattr'] .= 
				$this->config->item('alte_dttables_js') .
				$this->config->item('alte_dttablesbs_js') .
				$this->config->item('alte_slimscroll_js') .
				$this->config->item('alte_fastclick_js') ;
			
			$this->aData['attr']['table'] = 'tb_file';
			$this->aData['attr']['fields'] = 'id, name, location, date, year, category, volume';
			$this->aData['attr']['filter'][] = array( 'creator', '=', $this->username );
			$this->aData['attr']['orderby'][] = array( 'id', 'DESC' );
			$aRec = $this->gmodel->listing( $this->aData['attr'] );
			$this->aData['record'] = $aRec['rec_list'];		
			$this->template->load('alte', 'reports/files', $this->aData);
		}
		else
		{
			$this->aData = array_merge($this->aData, $this->gmodel->read( array( 
				'table' => 'tb_file', 
				'fields' => 'id, name, location, date, year, category, volume, desc, directory', 
				'filter' => array( array( 'id', '=', $vuId ), array( 'creator', '=', $this->username ) )
				) ) );
			$this->file_listing_docs( $nId );
			$this->aData['contentheader02'] = $this->aData['name'];
			$this->aBreadcrumb['phrase'][1] = $this->lang->line('menu_file_list');
			if ($this->aData['isrecord']) $this->aBreadcrumb['phrase'][2] = $this->aData['name'];
			$this->aBreadcrumb['link'][1] = $this->config->item('uri_reports_files');
			$this->aData['breadcrumb'] = $this->app_html->set_breadcrumb($this->aBreadcrumb);
			$this->template->load('alte', 'reports/file_info', $this->aData);
		}
	}

	public function file_listing_docs( $vuId )
	{
		$vuId = (int) $vuId;
		$this->aData['attr']['table'] = 'tb_file_doc';
		$this->aData['attr']['fields'] = 'id, fileid, name, doc_date, process_date, pic';
		$this->aData['attr']['filter'][] = array( 'fileid', '=', $vuId );
		$this->aData['attr']['filter'][] = array( 'creator', '=', $this->username );
		$this->aData['attr']['orderby'][] = array( 'id', 'DESC' );
		$aRec = $this->gmodel->listing( $this->aData['attr'] );
		$this->aData['doc']['record_count'] = $aRec['rec_count'];
		$this->aData['doc']['record'] = $aRec['rec_list'];
	}

	public function documents($vuFileId = 0, $vuDocId = 0)
	{
		$nFileId = (int) $vuFileId;
		$nDocId = (int) $vuDocId;
		if ($nFileId !== 0 AND $nDocId !== 0)
		{
			$this->aData = array_merge($this->aData, $this->gmodel->read( array( 
				'table' => 'vi_docs_files', 
				'fields' => 'docname, docdate, docprocessdate, docpic, docdesc, filename, fileid', 
				'filter' => array( array( 'fileid', '=', $nFileId ), array( 'docid', '=', $nDocId ), array( 'doccreator', '=', $this->username ) )
				) ) );
			$this->aData['contentheader02'] = $this->aData['docname'];
			$this->aBreadcrumb['phrase'][1] = $this->lang->line('menu_doc_list');
			if ($this->aData['isrecord']) $this->aBreadcrumb['phrase'][2] = $this->aData['docname'];
			$this->aBreadcrumb['link'][1] = $this->config->item('uri_reports_docs');
			$this->aData['breadcrumb'] = $this->app_html->set_breadcrumb($this->aBreadcrumb);
			$this->template->load('alte', 'reports/doc_info', $this->aData);
		}
		else
		{
			$this->aData['contentheader02'] = $this->lang->line('documents');

			$this->aData['htmlheadattr'] .= 
				$this->config->item('alte_dttables_css') ;

			$this->aData['htmltailattr'] .= 
				$this->config->item('alte_dttables_js') .
				$this->config->item('alte_dttablesbs_js') .
				$this->config->item('alte_slimscroll_js') .
				$this->config->item('alte_fastclick_js') ;
			
			$this->aData['attr']['table'] = 'vi_docs_files';
			$this->aData['attr']['fields'] = 'docid, fileid, filename, docname, docdate, docprocessdate, docpic';
			$this->aData['attr']['filter'][] = array( 'doccreator', '=', $this->username );
			$this->aData['attr']['orderby'][] = array( 'fileid', 'DESC' );
			$this->aData['attr']['orderby'][] = array( 'docid', 'DESC' );
			$aRec = $this->gmodel->listing( $this->aData['attr'] );
			$this->aData['record_count'] = $aRec['rec_count'];		
			$this->aData['record'] = $aRec['rec_list'];	
			$this->aBreadcrumb['phrase'][1] = $this->lang->line('menu_doc_list');
			$this->aData['breadcrumb'] = $this->app_html->set_breadcrumb($this->aBreadcrumb);
			$this->template->load('alte', 'reports/docs', $this->aData);
		}
	}
}