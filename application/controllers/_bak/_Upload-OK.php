<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Upload extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}

	public function index()
	{
		$this->load->view('upload/index_view');
	}

	public function blank()
	{
		$this->load->view('upload/index_blank');
	}
	
	public function blank_show()
	{
		$this->load->view('upload/index_blank_jfu');
	}

	public function json($nId, $nDocId = 0)
	{
		/*

		HARD-CODED - For testing purposes only

		update /assets/jfu/js/main.js to update the parameter
		url: 'http://recordsmanager.loc/upload/json/1/2

		*/

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
			'script_url' => site_url('upload/json/'. $sTrailScript),
			'upload_dir' => APPPATH . '../uploads/file/'. $sTrailDir,
			'upload_url' => site_url('uploads/file/'. $sTrailDir)
		];
		$this->load->library('UploadHandler', $options);

	}
}