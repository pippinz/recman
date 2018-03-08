<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*--------------------------------------------------------------------------------------------------
File management

	created 2017-04-08 16:35:13 <pippin.zaenul@gmail.com>
--------------------------------------------------------------------------------------------------*/
class Register extends CI_Controller {

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
		if ($this->ion_auth->logged_in()) redirect($this->config->item('uri_files'));

		/* Load account model */
		$this->load->model('General_model', 'gmodel');

		/* Load config */
		$this->load->config('app_uri');
		
		/* Load language for user attributes */
		$this->lang->load('general', 'english');
		$this->lang->load('auth', 'english');

		/* Load helpers */
		$this->load->helper('url');
		$this->load->helper('language');
		$this->load->helper('form');
		$this->load->helper('file');

		/* Page title */
		$this->aPageTitle = array(
			'phrase' => array(
				0 => $this->lang->line('register_new_membership')
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
		$this->aData['pcode'] = 'register';
		//$this->aData['contentheader01'] = $this->lang->line('menu_lookup');
		//$this->aData['contentheader02'] = $this->lang->line('form');
	}

	public function index ()
	{
		$this->aData['username'] = $this->input->post('username');
		$this->aData['email'] = strtolower($this->input->post('email'));
		$this->aData['first_name'] = $this->input->post('first_name');
		$this->aData['last_name'] = $this->input->post('last_name');
		$this->aData['company'] = $this->input->post('company');
		$this->aData['phone'] = $this->input->post('phone');
		$this->aData['password'] = $this->input->post('password');
		$this->aData['password_confirm'] = $this->input->post('password_confirm');

		if ($_SERVER['REQUEST_METHOD'] === 'POST')
		{
            $this->aData['additional_data'] = array(
                'first_name' => $this->aData['first_name'],
                'last_name'  => $this->aData['last_name'],
                'company'    => $this->aData['company'],
                'phone'      => $this->aData['phone']
            );

			$aRules = array(
				array(
					'field' => 'username', 
					'label' => 'lang:create_user_validation_identity_label', 
					'rules' => 'trim|required|min_length[4]|max_length[32]|is_unique[users.username]'
					), 
				array(
					'field' => 'email', 
					'label' => 'lang:create_user_validation_email_label', 
					'rules' => 'trim|required|valid_email|is_unique[users.email]'
					), 
				array(
					'field' => 'first_name', 
					'label' => 'lang:create_user_validation_fname_label', 
					'rules' => 'trim|required|max_length[50]'
					), 
				array(
					'field' => 'last_name', 
					'label' => 'lang:create_user_validation_lname_label', 
					'rules' => 'trim|required|max_length[50]'
					), 
				array(
					'field' => 'phone', 
					'label' => 'lang:create_user_validation_phone_label', 
					'rules' => 'trim'
					),
				array(
					'field' => 'company', 
					'label' => 'lang:create_user_validation_company_label', 
					'rules' => 'trim'
					),
				array(
					'field' => 'password', 
					'label' => 'lang:create_user_validation_password_label', 
					'rules' => 'trim|required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]'
					),
				array(
					'field' => 'password_confirm', 
					'label' => 'lang:create_user_validation_password_confirm_label', 
					'rules' => 'trim|required'
					)
				);
			$this->form_validation->set_rules($aRules);
			if ($this->form_validation->run()) 
			{
				$this->aData['bReg'] = $this->ion_auth->register(
					$this->aData['username'], 
					$this->aData['password'], 
					$this->aData['email'], 
					$this->aData['additional_data']
					);
				redirect($this->config->item('uri_login'), 'refresh');
			}
			else
			{
			}
			$this->load->view('register', $this->aData);
		}
		else
		{
			$this->load->view('register', $this->aData);
		}
	}

}