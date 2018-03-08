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
				0 => $this->lang->line('menu_lookup') 
			));

		/* Page title */
		$this->aPageTitle = array(
			'phrase' => array(
				0 => $this->lang->line('menu_lookup')
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
		//$this->aData['contentheader01'] = $this->lang->line('menu_lookup');
		//$this->aData['contentheader02'] = $this->lang->line('form');
	}

	public function get_lkp ($vsLkp = '')
	{
		$this->aData['sLookupCode'] = $vsLkp;
		$this->aData['aLkp'] = $this->gmodel->read(array(
			'table' => 'tb_lkp',
			'fields' => 'lkp, access, type, name',
			'filter' => array(array('lkp', '=', $this->aData['sLookupCode']))
			));
		$this->aData['sLookupTitle'] = '';
		if ($this->aData['aLkp']['isrecord'])
		{
			$this->aData['sLookupTitle'] = $this->aData['aLkp']['name'];
		}
	}

	public function listing ($vsLkp = '')
	{
		$this->get_lkp($vsLkp);

		$this->aData['sModalInfo'] = $this->lang->line('fi_modal_del');
		$this->aData['htmlheadattr'] .= 
			$this->config->item('alte_dttables_css') ;

		$this->aData['htmltailattr'] .= 
			$this->config->item('alte_dttables_js') .
			$this->config->item('alte_dttablesbs_js') .
			$this->config->item('alte_slimscroll_js') .
			$this->config->item('alte_fastclick_js') ;
		
			$this->aData['attr']['table'] = 'tb_lkpi';
			$this->aData['attr']['fields'] = 'id, lkp, num, str, name';
			$this->aData['attr']['filter'][] = array( 'lkp', '=', $vsLkp );
			$this->aData['attr']['filter'][] = array( 'creator', '=', $this->username );
			$this->aData['attr']['orderby'][] = array( 'id', 'name' );
			$aRec = $this->gmodel->listing( $this->aData['attr'] );
			$this->aData['record'] = $aRec['rec_list'];
		
		$this->aBreadcrumb['phrase'][1] = $this->aData['sLookupTitle'];
		$this->aBreadcrumb['phrase'][2] = $this->lang->line('list');
		$this->aData['contentheader01'] = $this->lang->line('menu_lookup');
		$this->aData['contentheader02'] = $this->lang->line('list');
		$this->aData['pagetitle'] = $this->aData['contentheader01'];
		// delete
		$this->aData['sModalInfo'] = $this->lang->line('li_modal_del');
		
		$this->aData['breadcrumb'] = $this->app_html->set_breadcrumb($this->aBreadcrumb);
		$this->template->load('alte', 'lookup_list', $this->aData);
	}

	public function form ($vsLkp = '', $vuId = '')
	{
		$this->get_lkp($vsLkp);

		$nId = (int) $vuId;
		$this->aData['mode'] = ( $nId == 0 ) ? 'insert' : 'update';
		if ($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			$nId = (int) $_POST['id'];
			$this->aData['mode'] = ( $nId == 0 ) ? 'insert' : 'update';
			$aRules = array(
				array(
					'field' => 'code', 
					'label' => 'lang:li_code', 
					'rules' => 'trim|required|max_length[64]'
					), 
				array(
					'field' => 'name', 
					'label' => 'lang:li_name', 
					'rules' => 'trim|required|max_length[64]'
					)
				);
			$this->form_validation->set_rules($aRules);
			$aModel['table'] = 'tb_lkpi';
			if ($this->form_validation->run()) {

				$aReturn['mode'] = $this->aData['mode'];
				
				$aModel['data'] = array(
					'lkp' => $this->aData['aLkp']['lkp'], 
					'name' => $this->input->post('name')
					);
				if ($this->aData['aLkp']['type'] == 'num') $aModel['data']['num'] = $this->input->post('code');
				if ($this->aData['aLkp']['type'] == 'str') $aModel['data']['str'] = $this->input->post('code');

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
						'id' => $nId, 
						'creator' => $this->username
						);

					$aDb = $this->gmodel->update( $aModel );
				}

				$aReturn['id'] = $aDb['id'];
				$aReturn['state'] = '1';
				// If form successfully saved
				if ( $aDb['trans_status'] )
				{
					$aReturn['state_msg'] = $this->lang->line('form_ok');
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
				'table' => 'tb_lkpi', 
				'fields' => 'id, lkp, num, str, name', 
				'filter' => array( array( 'id', '=', $nId ), array( 'creator', '=', $this->username ) )
				) ) );
			if ($this->aData['aLkp']['type'] == 'num') $this->aData['code'] = $this->aData['num'];
			if ($this->aData['aLkp']['type'] == 'str') $this->aData['code'] = $this->aData['str'];

			$this->aData['contentheader01'] = $this->lang->line('menu_lookup');
			$this->aData['contentheader02'] = $this->lang->line('form');
			$this->aData['pagetitle'] = $this->aData['contentheader01'];
			$this->aBreadcrumb['phrase'][1] = $this->aData['sLookupTitle'];
			$this->aBreadcrumb['link'][1] = $this->config->item('uri_lookup_list') . $this->aData['aLkp']['lkp'];
			$this->aBreadcrumb['phrase'][2] = $this->aData['name'];
			$this->aBreadcrumb['phrase'][3] = $this->lang->line('form');
			if (!$this->aData['isrecord']) $this->aBreadcrumb['phrase'][2] = $this->lang->line('add_new');
			$this->aData['breadcrumb'] = $this->app_html->set_breadcrumb($this->aBreadcrumb);
			$this->template->load('alte', 'lookup_form', $this->aData);
		}
	}

	public function delete ($vsLkp = '', $vuId = 0)
	{
		$sLkp = $_POST['lkp'];
		$nId = (isset($_POST['id'])) ? (int) $_POST['id'] : $vuId;
		$aModel['table'] = 'tb_lkpi';
		$aModel['where'] = array('lkp' => $sLkp, 'id' => $nId, 'creator' => $this->username);
		$aDb = $this->gmodel->del( $aModel );
		$aDb['state'] = 1; //( $aDb['trans_status'] === TRUE) ? 1 : 0;
		echo json_encode( $aDb );
		unset( $aDb );
	}
}