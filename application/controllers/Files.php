<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*--------------------------------------------------------------------------------------------------
File management

	created 2017-04-08 16:35:13 <pippin.zaenul@gmail.com>
--------------------------------------------------------------------------------------------------*/
class Files extends CI_Controller {

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
		//$this->load->config('app_lookup');
		
		/* Load language for user attributes */
		$this->lang->load('general', 'english');
		$this->lang->load('file', 'english');

		/* Load helpers */
		$this->load->helper('url');
		$this->load->helper('language');
		$this->load->helper('date');
		$this->load->helper('form');
		$this->load->helper('file');

		/* Breadcrumb */
		$this->aBreadcrumb = array(
			'phrase' => array(
				0 => $this->lang->line('menu_file') 
			), 
			'link' => array(
				0 => $this->config->item('uri_files')
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
			/*
			$this->config->item('alte_jq_js') .
			$this->config->item('alte_bs_js') .
			*/
			$this->config->item('alte_app_js') ;

		/* Default vars */
		$this->form_validation->set_error_delimiters('', '');
		$this->aData['filter'] = array();
		$this->aData['pcode'] = 'file';
		$this->aData['contentheader01'] = $this->lang->line('fi_page_title');
		$this->aData['contentheader02'] = $this->lang->line('form');
		$this->aData['pagetitle'] = $this->aData['contentheader01'];
		$this->aData['aStatus'] = $this->config->item('list_active_status');
		$this->aData['aLocation'] = $this->app_util->rs2arrkeyval($this->gmodel->listing(
			array(
				'table' => 'tb_lkpi',
				'fields' => 'str as id, name',
				'filter' => array(array('lkp', '=', 'file.location')), 
				'orderby' => array(array('name', 'ASC'))
				)
			)['rec_list']);
		$this->aData['aCategory'] = $this->app_util->rs2arrkeyval($this->gmodel->listing(
			array(
				'table' => 'tb_lkpi',
				'fields' => 'str as id, name',
				'filter' => array(array('lkp', '=', 'file.category')), 
				'orderby' => array(array('name', 'ASC'))
				)
			)['rec_list']);
		$this->aData['aVolume'] = $this->app_util->rs2arrkeyval($this->gmodel->listing(
			array(
				'table' => 'tb_lkpi',
				'fields' => 'str as id, name',
				'filter' => array(array('lkp', '=', 'file.volume')), 
				'orderby' => array(array('name', 'ASC'))
				)
			)['rec_list']);
		$this->aData['aPic'] = $this->app_util->rs2arrkeyval($this->gmodel->listing(
			array(
				'table' => 'tb_lkpi',
				'fields' => 'str as id, name',
				'filter' => array(array('lkp', '=', 'document.pic')), 
				'orderby' => array(array('name', 'ASC'))
				)
			)['rec_list']);
	}

	public function index()
	{
		$this->listing();
	}

	public function listing ()
	{
		$this->aBreadcrumb['phrase'][1] = $this->lang->line('menu_file_list');
		$this->aData['breadcrumb'] = $this->app_html->set_breadcrumb($this->aBreadcrumb);

		$this->aData['sModalInfo'] = $this->lang->line('fi_modal_del');
		$this->aData['htmlheadattr'] .= 
			$this->config->item('alte_dttables_css') ;

		$this->aData['htmltailattr'] .= 
			$this->config->item('alte_dttables_js') .
			$this->config->item('alte_dttablesbs_js') .
			$this->config->item('alte_slimscroll_js') .
			$this->config->item('alte_fastclick_js') ;
		
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

		$this->aData['attr']['table'] = 'tb_file';
		$this->aData['attr']['fields'] = 'id, name, location, date, year, category, volume';
		$this->aData['attr']['filter'][] = array( 'creator', '=', $this->username );
		$this->aData['attr']['orderby'][] = array( 'id', 'DESC' );
		$aRec = $this->gmodel->listing( $this->aData['attr'] );
		$this->aData['record'] = $aRec['rec_list'];
		
		$listing['base_url'] = $this->config->item('uri_file_list');

		$listing['query_string_trail'] = $fqs;
		
		$this->template->load('alte', 'files/file_list', $this->aData);
	}

	public function jfu($nId, $nDocId = 0)
	{
		$nDocId = (int) $nDocId;
		if ($nDocId == 0)
		{
			$sTrailScript = $nId;
			$sTrailDir = $nId . '/';
		}
		else
		{
			$sTrailScript = $nId . '/' . $nDocId;
			$sTrailDir = $nId . '/' . $this->config->item('dir_document_code') . '/' . $nDocId .'/';
		}
		$options = [
			'script_url' => site_url('files/jfu/'. $sTrailScript),
			'upload_dir' => APPPATH . '../uploads/files/'. $sTrailDir,
			'upload_url' => site_url('uploads/files/'. $sTrailDir)
		];
		$this->load->library('UploadHandler', $options);
	}

	public function form( $vuId = 0 )
	{
		$this->aBreadcrumb['phrase'][1] = $this->lang->line('menu_file_form');
		$this->aData['breadcrumb'] = $this->app_html->set_breadcrumb($this->aBreadcrumb);

		$this->aData['sModalInfo'] = $this->lang->line('fd_modal_del');
		$this->aData['htmlheadattr'] .= 
			$this->config->item('alte_select2_css') .
			$this->config->item('alte_datepicker3_css') .
			$this->config->item('jfu_head_inc') ;

		$this->aData['htmltailattr'] .= 
			$this->config->item('alte_select2_js') .
			$this->config->item('alte_datepicker_js') .
			$this->config->item('jfu_tail_inc') ;
		
		$aReturn['isJfu'] = '1';
		$aReturn['jfu_view_uri'] = $this->config->item('uri_files_jfu_show') . $vuId;
		$vuId = (int) $vuId;
		$this->aData['mode'] = ( $vuId == 0 ) ? 'insert' : 'update'; // to check wether in New, Update or Insert mode when the page is being loaded
		$nYear = date('Y');
		$this->aData['aYear'] = $this->app_util->year_lkp(array('start'=>$this->config->item('file_year_start'), 'end'=>$nYear));
		if ($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			$vuId = (int) $_POST['id'];
			$this->aData['mode'] = ( $vuId == 0 ) ? 'insert' : 'update';
			$aRules = array(
				array(
					'field' => 'name', 
					'label' => 'lang:fi_name', 
					'rules' => 'trim|required|max_length[128]'
					), 
				array(
					'field' => 'date', 
					'label' => 'lang:fi_date', 
					'rules' => 'trim|valid_date'
					), 
				array(
					'field' => 'year', 
					'label' => 'lang:fi_year', 
					'rules' => 'trim'
					), 
				array(
					'field' => 'location', 
					'label' => 'lang:fi_location', 
					'rules' => 'trim'
					), 
				array(
					'field' => 'category', 
					'label' => 'lang:fi_category', 
					'rules' => 'trim'
					), 
				array(
					'field' => 'volume', 
					'label' => 'lang:fi_volume', 
					'rules' => 'trim'
					),
				array(
					'field' => 'desc', 
					'label' => 'lang:fi_desc', 
					'rules' => 'trim'
					)
				);
			$this->form_validation->set_rules($aRules);
			$aModel['table'] = 'tb_file';
			if ($this->form_validation->run()) {

				$aReturn['mode'] = $this->aData['mode'];
				
				$aModel['data'] = array(
					'name' => $this->input->post('name'), 
					'date' => $this->app_util->input_date($this->input->post('date')), 
					'year' => $this->app_util->input_num($this->input->post('year')), 
					'location' => $this->input->post('location'),
					'category' => $this->input->post('category'),
					'volume' => $this->input->post('volume'),
					'desc' => $this->input->post('desc'),
					);
				if ( $this->aData['mode'] == 'insert' )
				{
					$aModel['data'] = array_merge( $aModel['data'], 
						array (
							'created' => date('Y-m-d H:i:s'),
							'creator' => $this->username
							)
						);
					$aDb = $this->gmodel->insert( $aModel );
				}
				else
				{
					$aModel['data'] = array_merge( $aModel['data'], 
						array( 
							'edited' => date('Y-m-d H:i:s'), 
							'editor' => $this->username
							)
						);
					$aModel['where'] = array(
						'id' => $vuId
						);
					$aDb = $this->gmodel->update( $aModel );
				}

				$aReturn['id'] = $aDb['id'];
				$aReturn['jfu_view_uri'] = $this->config->item('uri_files_jfu_show') . $aReturn['id'];
				$aReturn['state'] = '1';
				// If form successfully saved
				if ( $aDb['trans_status'] )
				{
					$aReturn['state_msg'] = $this->lang->line('form_ok');
					/* Already handled by JFU 
					if ( $this->aData['mode'] == 'insert' )
					{
						$sDir = $this->config->item('dir_uploads_file') . $aDb['id'];
						$aP = array('path' => $sDir, 'mode' => $this->config->item('dir_uploads_file_mode'));
						$bDir = $this->app_util->create_dir($aP);
						// create thumbnail folder
						if ($bDir) 
						{
							$sDir .= '/' . $this->config->item('dir_thumbnail_code');
							$aP = array('path' => $sDir, 'mode' => $this->config->item('dir_uploads_file_mode'));
							$bDir = $this->app_util->create_dir($aP);
						}
					}
					*/
				}
				else
				{
					$aReturn['state'] = '0'; // Indicated as error
					$aReturn['state_msg'] = $this->lang->line('form_failed');
					if ( isset( $aDb['error_number'] ) )
					{
						if ( $aDb['error_number'] == 1062 )
							$aReturn['name'] = $this->lang->line('err_db_1062');
					}
				}
			}

			else
			{
				// Rule validation failed
				$aReturn['id'] = '0';
				$aReturn['state'] = '0';
				// Populate error generated from validation rules above
				if ( is_array( $aRules ) )
				{
					foreach ( $aRules as $aField )
					{
						if ( !form_error( $aField['field'] ) == '' ) $aReturn[ $aField['field'] ] = form_error( $aField['field'] );
					}
				}
				$aReturn['state_msg'] = $this->lang->line('form_failed');
			}

			echo json_encode($aReturn);
			unset($aReturn);
		}
		else
		{
			$this->aData = array_merge($this->aData, $this->gmodel->read( array( 
				'table' => 'tb_file', 
				'fields' => 'id, name, location, date, year, category, volume, desc, directory', 
				'filter' => array( array( 'id', '=', $vuId ), array( 'creator', '=', $this->username ) )
				) ) );
			$this->listing_docs( $vuId );
			$this->template->load('alte', 'files/file_form', $this->aData);
		}
	}

	public function jfu_view()
	{
		$this->load->view('jfu_view');
	}

	public function listing_docs( $vuId )
	{
		$vuId = (int) $vuId;
		$this->aData['attr']['table'] = 'tb_file_doc';
		$this->aData['attr']['fields'] = 'id, fileid, name, doc_date, process_date, pic';
		$this->aData['attr']['filter'][] = array( 'fileid', '=', $vuId );
		$this->aData['attr']['orderby'][] = array( 'id', 'DESC' );
		$aRec = $this->gmodel->listing( $this->aData['attr'] );
		$this->aData['record_count'] = $aRec['rec_count'];
		$this->aData['record'] = $aRec['rec_list'];
	}

	public function document( $vuFileId = 0, $vuId = 0 )
	{
		$vuFileId = (int) $vuFileId;
		$vuId = (int) $vuId; // Document ID
		$this->aData['contentheader01'] = $this->lang->line('fd_doc');
		$this->aData['htmlheadattr'] .= 
			$this->config->item('alte_select2_css') .
			$this->config->item('alte_datepicker3_css') .
			$this->config->item('jfu_head_inc') ;

		$this->aData['htmltailattr'] .= 
			$this->config->item('alte_select2_js') .
			$this->config->item('alte_datepicker_js') .
			$this->config->item('jfu_tail_inc') ;
		
		$aReturn['isJfu'] = '1';
		$aReturn['jfu_view_uri'] = $this->config->item('uri_files_jfu_show') . $vuFileId . '/' . $vuId;
		$this->aData['mode'] = ( $vuId == 0 ) ? 'insert' : 'update'; // to check wether in New, Update or Insert mode when the page is being loaded
		if ($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			$vuFileId = (int) $_POST['fileid'];
			$vuId = (int) $_POST['id'];
			$this->aData['mode'] = ( $vuId == 0 ) ? 'insert' : 'update';
			$aRules = array(
				array(
					'field' => 'name', 
					'label' => 'lang:fd_name', 
					'rules' => 'trim|required|max_length[128]'
					), 
				array(
					'field' => 'doc_date', 
					'label' => 'lang:fd_doc_date', 
					'rules' => 'trim|valid_date'
					), 
				array(
					'field' => 'process_date', 
					'label' => 'lang:fd_process_date', 
					'rules' => 'trim|valid_date'
					), 
				array(
					'field' => 'desc', 
					'label' => 'lang:fd_desc', 
					'rules' => 'trim'
					), 
				array(
					'field' => 'pic', 
					'label' => 'lang:fd_pic', 
					'rules' => 'trim'
					)
				);
			$this->form_validation->set_rules($aRules);
			$aModel['table'] = 'tb_file_doc';
			if ($this->form_validation->run()) {

				$aReturn['mode'] = $this->aData['mode'];
				
				$aModel['data'] = array(
					'fileid' => $vuFileId, 
					'name' => $this->input->post('name'), 
					'doc_date' => $this->app_util->input_date($this->input->post('doc_date')), 
					'process_date' => $this->app_util->input_date($this->input->post('process_date')), 
					'desc' => $this->input->post('desc'),
					'pic' => $this->input->post('pic')
					);
				if ( $this->aData['mode'] == 'insert' )
				{
					$aModel['data'] = array_merge( $aModel['data'], 
						array (
							'created' => date('Y-m-d H:i:s'),
							'creator' => $this->username
							)
						);
					$aDb = $this->gmodel->insert( $aModel );
				}
				else
				{
					$aModel['data'] = array_merge( $aModel['data'], 
						array( 
							'edited' => date('Y-m-d H:i:s'), 
							'editor' => $this->username
							)
						);
					$aModel['where'] = array(
						'id' => $vuId
						);
					$aDb = $this->gmodel->update( $aModel );
				}

				$aReturn['id'] = $aDb['id'];
				$aReturn['jfu_view_uri'] = $this->config->item('uri_files_jfu_show') . $vuFileId . '/' . $aReturn['id'];
				$aReturn['state'] = '1';
				// If form successfully saved
				if ( $aDb['trans_status'] )
				{
					$aReturn['state_msg'] = $this->lang->line('form_ok');
					/* Already handled by JFU 
					if ( $this->aData['mode'] == 'insert' )
					{
						$sDir = $this->config->item('dir_uploads_file') . $vuFileId . '/' . $this->config->item('dir_document_code') . '/' . $aDb['id'];
						$aP = array('path' => $sDir, 'mode' => $this->config->item('dir_uploads_file_mode'));
						$bDir = $this->app_util->create_dir($aP);
						// create thumbnail folder
						if ($bDir) 
						{
							$sDir .= '/' . $this->config->item('dir_thumbnail_code');
							$aP = array('path' => $sDir, 'mode' => $this->config->item('dir_uploads_file_mode'));
							$bDir = $this->app_util->create_dir($aP);
						}
					}
					*/
				}
				else
				{
					$aReturn['state'] = '0'; // Indicated as error
					$aReturn['state_msg'] = $this->lang->line('form_failed');
					if ( isset( $aDb['error_number'] ) )
					{
						if ( $aDb['error_number'] == 1062 )
							$aReturn['name'] = $this->lang->line('err_db_1062');
					}
				}
			}

			else
			{
				// Rule validation failed
				$aReturn['id'] = '0';
				$aReturn['state'] = '0';
				// Populate error generated from validation rules above
				if ( is_array( $aRules ) )
				{
					foreach ( $aRules as $aField )
					{
						if ( !form_error( $aField['field'] ) == '' ) $aReturn[ $aField['field'] ] = form_error( $aField['field'] );
					}
				}
				$aReturn['state_msg'] = $this->lang->line('form_failed');
			}

			echo json_encode($aReturn);
			unset($aReturn);
		}
		else
		{
			$this->aData = array_merge($this->aData, $this->gmodel->read( array( 
				'table' => 'tb_file_doc', 
				'fields' => 'fileid, id, name, doc_date, process_date, desc, pic', 
				'filter' => array( array( 'id', '=', $vuId ), array( 'creator', '=', $this->username ) )
				) ) );
			$this->aData['fileid'] = $vuFileId;

			// breadcrumb
			$aTmp = $this->gmodel->read(array(
				'table' => 'tb_file',
				'fields' => 'name',
				'filter' => array(array('id', '=', $vuFileId))
				));
			$sFileTitle = '';
			if ($aTmp['isrecord'])
			{
				$sFileTitle = $aTmp['name'];
			}
			$this->aBreadcrumb['phrase'][1] = $sFileTitle;
			$this->aBreadcrumb['phrase'][2] = $this->lang->line('document');
			$this->aBreadcrumb['link'][1] = $this->config->item('uri_files_form') . $vuFileId;
			$this->aData['breadcrumb'] = $this->app_html->set_breadcrumb($this->aBreadcrumb);

			$this->template->load('alte', 'files/file_doc_form', $this->aData);
		}
	}

	function delete ($sId = '')
	{
		/*--------------------------------------------------------------------------------------------------
		Par(s)	:
			sId = String form of id, format: fileid::documentid
				documentid is optional
				if documentid is supplied, action is to delete Document & document attachment only
				if documentid is NOT supplied, action is to delete File and all related Document & attachments

		created 2017-04-21 12:36:05 <pippin.zaenul@gmail.com>
		--------------------------------------------------------------------------------------------------*/
		$sId = $_POST['id'];
		$aId = explode('::', $sId);
		$nFileId = $aId[0];
		$nCount = count($aId);

		if ($nCount > 1) // fileid & documentid are supplied, meaning delete only document data
		{
			$nDocId = $aId[1];
			$aModel['table'] = 'tb_file_doc';
			$aModel['where'] = array( 'id' => $nDocId );
			$aDb = $this->gmodel->del( $aModel );

			// delete document attachment
			$sDir = $this->config->item('dir_uploads_file') . $nFileId . '/' . $this->config->item('dir_document_code') . '/' . $nDocId;
			$aDb['delfile'] = delete_files($sDir, TRUE);
			if ($aDb['delfile'] == 1) $aDb['delfile'] = rmdir($sDir);
		}
		
		if ($nCount == 1) // only fileid is supplied, meaning delete the file data and all related documents
		{
			// delete all document records related to the file
			$aModel['table'] = 'tb_file_doc';
			$aModel['where'] = array( 'fileid' => $nFileId );
			$aDb = $this->gmodel->del( $aModel );

			// delete file record
			$aModel['table'] = 'tb_file';
			$aModel['where'] = array( 'id' => $nFileId );
			$aDb = $this->gmodel->del( $aModel );
			
			// delete file attachments directory and its all subdirs including the document attachments
			$sDir = $this->config->item('dir_uploads_file') . $nFileId;
			$aDb['delfile'] = delete_files($sDir, TRUE);
			if ($aDb['delfile'] == 1) $aDb['delfile'] = rmdir($sDir);
		}

		$aDb['state'] = 1; //( $aDb['trans_status'] === TRUE) ? 1 : 0;
		echo json_encode( $aDb );
		unset( $aDb );
	}

}