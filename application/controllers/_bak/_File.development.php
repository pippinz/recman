<?php defined('BASEPATH') OR exit('No direct script access allowed');

class File extends CI_Controller {

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

	public function jfu($nId, $nDocId = 0)
	{
		/*
		$options = [
			'script_url' => site_url('upload/json/'. $nId . '/' . $nDocId),
			'upload_dir' => APPPATH . '../uploads/files/'. $nId .'/doc/'. $nDocId . '/',
			'upload_url' => site_url('uploads/files/'. $nId .'/doc/'. $nDocId . '/')
		];
		$this->load->library('UploadHandler', $options);
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
			'script_url' => site_url('file/jfu/'. $sTrailScript),
			'upload_dir' => APPPATH . '../uploads/file/'. $sTrailDir,
			'upload_url' => site_url('uploads/file/'. $sTrailDir)
		];
		$this->load->library('UploadHandler', $options);

	}
}