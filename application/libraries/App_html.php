<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*--------------------------------------------------------------------------------------------------
HTML form class
	To create HTML elements

	created 2010-03-04 10:37:46 <pippin.zaenul@gmail.com>
--------------------------------------------------------------------------------------------------*/

class App_html {

	var $CI;
	
	/* Refere to CI class when instantiated */
	function __construct()
	{
		$this->CI =& get_instance();
	}

	/*--------------------------------------------------------------------------------------------------
	Input in group

		created 2017-04-19 13:03:18 <pippin.zaenul@gmail.com>
	--------------------------------------------------------------------------------------------------*/
	public function form_group ($p)
	{
		$sR = '';
		$sR .= '<div class="form-group">';
		$sR .= $this->form_label($p);

		switch ($p['type'])
		{
			case 'text':
				$sR .= $this->form_text($p);
				break;
			case 'date':
				$sR .= $this->form_date($p);
				break;
			case 'select':
				$sR .= $this->form_select($p);
				break;
			case 'area':
				$sR .= $this->form_area($p);
				break;
			default:
		}

		if (array_key_exists('errmsg', $p) AND $p['errmsg'])
		{
			$sR .= $this->form_errmsg(array('id'=>$p['id'].'err'));
		}

		$sR .= '</div>';
		return $sR;
	}
	
	/*--------------------------------------------------------------------------------------------------
	To write a label on the page

		vnOpt : 1 = code from lang; 2 = write as it is
		updated 2017-04-19 01:13:30 <pippin.zaenul@gmail.com>	for AdminLTE
		created 2010-03-04 19:55:03 <pippin.zaenul@gmail.com>

		Par is array of
			text	: raw text to be printed as label, or
			line	: text is taken from the language file
			id		: id of the form input

	--------------------------------------------------------------------------------------------------*/
	public function form_label ($p) {
		
		$sR = '';
		$sR .= '<label';
		if (array_key_exists('id', $p)) $sR .= ' for="'. $p['id'] .'"';
		$sR .= '>';
		if (array_key_exists('text', $p)) $sR .= $p['text'];
		if (array_key_exists('line', $p)) $sR .= $this->CI->lang->line($p['line']);
		$sR .= '</label>';

		return $sR;
	}

	/*--------------------------------------------------------------------------------------------------
	Input text

		updated 2017-04-19 01:22:06 <pippin.zaenul@gmail.com> for AdminLTE
		created 2010-03-04 20:22:55 <pippin.zaenul@gmail.com>
	--------------------------------------------------------------------------------------------------*/
	public function form_text ($p)
	{
		$sR = '';

		$sR .= '<input type="text"';
		$sR .= ' id="'. $p['id'] .'"';
		if (array_key_exists('name', $p)) $sR .= ' name="'. $p['name'] .'"';
		if (array_key_exists('val', $p)) $sR .= ' value="'. $p['val'] .'"';
		if (array_key_exists('class', $p)) $sR .= ' class="'. $p['class'] .'"';
		if (array_key_exists('placeholder', $p)) $sR .= ' placeholder="'. $p['placeholder'] .'"';
		if (array_key_exists('max', $p)) $sR .= ' maxlength="'. $p['max'] .'"';
		if (array_key_exists('size', $p)) $sR .= ' size="'. $p['size'] .'"';
		$sR .= ' />';

		return $sR;
	}

	/*--------------------------------------------------------------------------------------------------
	Date input

		created 2017-04-19 11:22:04 <pippin.zaenul@gmail.com>
	--------------------------------------------------------------------------------------------------*/
	public function form_date($p)
	{
		$sClass = 'form-control pull-right';
		$sR = '<div class="input-group date">'
			. '<div class="input-group-addon">'
			. '<i class="fa fa-calendar"></i>'
			. '</div>'
			. '<input type="text" id="'. $p['id'] .'"';
		$sR .= array_key_exists('name', $p) ? ' name="'. $p['name'] .'"' : '';
		$sR .= array_key_exists('val', $p) ? ' value="'. $p['val'] .'"' : '';
		$sR .= ' class="'. ( (array_key_exists('class', $p)) ? $p['class'] : $sClass ) .'"';
		$sR .= array_key_exists('ph', $p) ? ' placeholder="'. $p['ph'] .'"' : '';
		$sR .= '>';
		$sR .= '</div>';
		return $sR;
	}

	/*--------------------------------------------------------------------------------------------------
	Combo box selection
	pars (array):
		lkp	= lookup value in list of array
		val	= selected value

		created 2017-04-19 11:22:04 <pippin.zaenul@gmail.com>
	--------------------------------------------------------------------------------------------------*/
	public function form_select($p)
	{
		$sBlank = '';
		$sClass = 'form-control select2';
		$sPh = '';
		$sStyle = "width: 100%;";

		$sR = '<select id="'. $p['id'] .'"';
		$sR .= array_key_exists('name', $p) ? ' name="'. $p['name'] .'"' : '';
		$sR .= ' class="'. ( (array_key_exists('class', $p)) ? $p['class'] : $sClass ) .'"';
		$sR .= array_key_exists('ph', $p) ? ' data-placeholder="'. $p['ph'] .'"' : '';
		$sR .= ' style="'. ( (array_key_exists('style', $p)) ? $p['style'] : $sStyle ) .'"';
		$sR .= '>';

		$sR .= '<option>'. $sBlank .'</option>';

		foreach($p['lkp'] as $k=>$v)
		{
			$k = (string) $k;
			$p['val'] = (string) $p['val'];
			$sSelected = ($p['val'] === $k) ? ' selected="selected"' : '';
			$sR .= '<option value="'. $k .'"'. $sSelected .'>'. $v .'</option>';
		}

		$sR .= '</select>';
		return $sR;
	}

	/*--------------------------------------------------------------------------------------------------
	Text area

		created 2017-04-19 11:22:04 <pippin.zaenul@gmail.com>
	--------------------------------------------------------------------------------------------------*/
	public function form_area($p)
	{
		$sClass = 'form-control';
		$nRow = 3;
		$sPh = '';

		$sR = '<textarea id="'. $p['id'] .'"';
		$sR .= array_key_exists('name', $p) ? ' name="'. $p['name'] .'"' : '';
		$sR .= ' class="'. ( (array_key_exists('class', $p)) ? $p['class'] : $sClass ) .'"';
		$sR .= ' row="'. ( (array_key_exists('class', $p)) ? $p['row'] : $nRow ) .'"';
		$sR .= array_key_exists('ph', $p) ? ' placeholder="'. $p['ph'] .'"' : '';
		$sR .= '>';
		$sR .= array_key_exists('val', $p) ? $p['val'] : '';
		$sR .= '</textarea>';
		return $sR;
	}

	/*--------------------------------------------------------------------------------------------------
	Error message

		created 2017-04-19 11:22:04 <pippin.zaenul@gmail.com>
	--------------------------------------------------------------------------------------------------*/
	public function form_errmsg ($p)
	{
		$sClassDef = 'help-block';

		$sR = '<span ';
		$sR .= ' id="'. $p['id'] .'"';
		$sR .= ' class="' . ( (array_key_exists('class', $p)) ? $p['class'] : $sClassDef ) . '"';
		$sR .= '></span>';

		return $sR;
	}

	/*--------------------------------------------------------------------------------------------------
	Breadcrumb

		$vaAttr		Additional attributes : array(style, tabindex, accesskey, etc)

		created 2010-03-10 16:26:48 <pippin.zaenul@gmail.com>
	--------------------------------------------------------------------------------------------------*/
	public function set_breadcrumb ($vaVal) 
	{
		$sRet = ''; $sTmp = '';
		if (is_array($vaVal))
		{
			$sRet .= '<ol class="breadcrumb">';
			$sRet .= '<li><i class="fa fa-anchor"></i></li>';
			$nCount = count($vaVal['phrase']);
			for ($i=0; $i < $nCount; $i++)
			{
				if (array_key_exists($i, $vaVal['phrase']))
				{
					$sTmp .= '<li>';
					if (array_key_exists('link', $vaVal) && array_key_exists($i, $vaVal['link'])) 
					{
						$sTmp .= '<a class="breadcrumb" href="'. $vaVal['link'][$i] .'">'. $vaVal['phrase'][$i] .'</a>';
					}
					else
					{
						$sTmp .= $vaVal['phrase'][$i];
					}
					$sTmp .= '</li>';
				}
			}
			$sRet .= $sTmp . '</ol>';
		}
		return $sRet;
	}

	/*--------------------------------------------------------------------------------------------------
	Breadcrumb

		$vaAttr		Additional attributes : array(style, tabindex, accesskey, etc)

		created 2010-03-10 16:26:48 <pippin.zaenul@gmail.com>
	--------------------------------------------------------------------------------------------------*/
	function set_breadcrumb_old ($vaValue, $vsDelimiter = '-&nbsp;', $vsPhraseClass = NULL, $vsLinkClass = NULL, $vaAttr = NULL) 
	{
		$sReturn = '';

		if (is_array($vaValue))
		{
			
			// Get the higher index number between phrase and link
			$nPhraseCount = count($vaValue['phrase']);
			//$nLinkCount = (is_array($vaValue['link'])) ? count($vaValue['link']) : 0;
			$nLinkCount = (array_key_exists('link', $vaValue)) ? count($vaValue['link']) : 0;

			$nLoop = ($nPhraseCount > $nLinkCount ? $nPhraseCount : $nLinkCount);

			for ($i = 0; $i < $nLoop; $i++)
			{
				
				// Check wheter a phrase for a particular index is available or not?
				if (array_key_exists($i, $vaValue['phrase']))
				{

					if ( ! ($sReturn == '') ) $sReturn .= ' ' . $vsDelimiter;

					// Check whether a link for a particular phrase is available or not?
					if (array_key_exists('link', $vaValue) && array_key_exists($i, $vaValue['link'])) 
					{
						$sReturn .= '<a href="' . $vaValue['link'][$i] . '"';
						if (isset($vsLinkClass)) $sReturn .= ' class="' . $vsLinkClass . '"';
						$sReturn .= '>';

						$sClosingLinkTag = '</a>';
					}
					
					else
					{
						$sClosingLinkTag = '';
					}
					
					$sReturn .= $vaValue['phrase'][$i];						
					$sReturn .= $sClosingLinkTag;					

				}

			}

		} 
		
		else 
		{
			if ( ! ($vaValue == '') || is_null($vaValue) ) $sReturn = $vaValue;
		}

		if (!$vsPhraseClass == NULL)
		{
			$sReturn = '<span class="' . $vsPhraseClass . '">'. $sReturn . '</span>';
		}

		return $sReturn;

	}

	/*--------------------------------------------------------------------------------------------------
	Input text

		$vaAttr		Additional attributes : array(style, tabindex, accesskey, etc)

		created 2010-03-04 20:22:55 <pippin.zaenul@gmail.com>
	--------------------------------------------------------------------------------------------------*/
	function form_input ($vsName, $vsId, $vuValue = '', $vsClass = '', $vnSize = 0, $vnLen = 0, $vaAttr = NULL)
	{
		$sReturn = '<input type="text" name="' . $vsName . '" id="' . $vsId . '" value="' . $vuValue . '"';
		if ( ! $vsClass == '' ) $sReturn .= ' class="' . $vsClass . '"';
		if ( ! $vnSize == 0 ) $sReturn .= ' size="' . $vnSize . '"';
		if ( ! $vnLen == 0 ) $sReturn .= ' maxlength="' . $vnLen . '"';
		if ( is_array($vaAttr) )
		{
			foreach ($vaAttr as $key => $val)
			{
				$sReturn .= ' ' . $key . '="' . $val . '"';
			}
		}
		$sReturn .= ' />';
		return $sReturn;
	}

	/*--------------------------------------------------------------------------------------------------
	Input text

		$vaAttr		Additional attributes : array(style, tabindex, accesskey, etc)

		created 2010-11-13 10:23:18 <pippin.zaenul@gmail.com>
	--------------------------------------------------------------------------------------------------*/
	function form_password ($vsName, $vsId, $vuValue = '', $vsClass = '', $vnSize = 0, $vnLen = 0, $vaAttr = NULL)
	{
		$sReturn = '<input type="password" name="' . $vsName . '" id="' . $vsId . '" value="' . $vuValue . '"';
		if ( ! $vsClass == '' ) $sReturn .= ' class="' . $vsClass . '"';
		if ( ! $vnSize == 0 ) $sReturn .= ' size="' . $vnSize . '"';
		if ( ! $vnLen == 0 ) $sReturn .= ' maxlength="' . $vnLen . '"';
		$sReturn .= ' />';
		return $sReturn;
	}

	/*--------------------------------------------------------------------------------------------------
	Table record

		created 2017-04-19 13:03:18 <pippin.zaenul@gmail.com>
	--------------------------------------------------------------------------------------------------*/
	function tblrec($label, $record, $separator = '')
	{
		$sLbl = $this->CI->lang->line($label);
		if ($sLbl == '') $sLbl = $label;
		$sRet = '<div class="form-group">'
				. '<label class="col-sm-2">'. $sLbl . $separator .'</label>'
				. '<div class="col-sm-10">'. $record .'</div>'
				. '</div>';
		return $sRet;
	}

	/*--------------------------------------------------------------------------------------------------
	Text area

		$vaAttr		Additional attributes : array(style, tabindex, accesskey, etc)

		created 2010-03-04 23:50:09 <pippin.zaenul@gmail.com>
	--------------------------------------------------------------------------------------------------*/
	function form_area_0 ($vsName, $vsId, $vsValue = '', $vsClass = '', $vnRow = 0, $vnCol = 0, $vaAttr = NULL, $vaStyle = NULL)
	{
		$sReturn = '<textarea name="' . $vsName . '" id="' . $vsId . '"';
		if ( ! $vsClass == '' ) $sReturn .= ' class="' . $vsClass . '"';
		if ( ! $vnRow == 0 ) $sReturn .= ' rows="' . $vnRow . '"';
		if ( ! $vnCol == 0 ) $sReturn .= ' cols="' . $vnCol . '"';
		if (is_array($vaStyle))
		{
			$sReturn .= ' style="';
			foreach($vaStyle as $key => $val)
			{
				$sReturn .= $key . ':' . $val . ';';
			}
			$sReturn .= '"';
		}
		$sReturn .= '>' . $vsValue . '</textarea>';

		return $sReturn;
	}

	/*--------------------------------------------------------------------------------------------------
	Dropdown menu

		$vaAttr		Additional attributes : array(style, tabindex, accesskey, etc)

		created 2010-03-04 21:08:46 <pippin.zaenul@gmail.com>
	--------------------------------------------------------------------------------------------------*/
	function form_select_0 (
		$vsName, 
		$vsId, 
		$vaOption = array(), 
		$vaValue = array(), 
		$vsClass = '', 
		$vbBlankOption = TRUE, 
		$vnSize = 1, 
		$vaAttr = NULL)
	{
		if (!is_array($vaAttr)) $vaAttr = array();
		
		if ( ! is_array($vaValue))
		{
			$vaValue = array($vaValue);
		}

		$sReturn = '<select name="' . $vsName . '" id="' . $vsId . '" size="' . $vnSize . '"';
		if ( ! $vsClass == '' ) $sReturn .= ' class="' . $vsClass . '"';

		if (array_key_exists('disabled', $vaAttr))
		{
			$sReturn .= ' disabled="disabled"';
		}

		$sReturn .= '>';

		if ($vbBlankOption)
		{
			$sReturn .= '<option value="">' . $this->CI->lang->line('gen_blank_option') . '</option>';
		}
		
		if (is_array($vaOption))
		{
			foreach ($vaOption as $key => $val)
			{
				$key = (string) $key;
				$sSelected = (in_array($key, $vaValue)) ? ' selected="selected"' : '';
				//$sSelected = ($key ) ? ' selected="selected"' : '';
				$sReturn .= '<option value="' . $key . '"' . $sSelected . '>' . (string) $val . '</option>';
			}
		}

		$sReturn .= '</select>';

		unset($vaAttr);
		
		return $sReturn;
	}

	/*--------------------------------------------------------------------------------------------------
	Button

		$vaAttr		Additional attributes : array(style, tabindex, accesskey, etc)

		created 2010-03-05 13:58:50 <pippin.zaenul@gmail.com>
	--------------------------------------------------------------------------------------------------*/
	function form_button ($vsName, $vsId, $vsValue, $vsClass = '', $vsType = 'submit', $vaAttr = NULL) 
	{
		$sReturn = '<input type="' . $vsType . '" name="' . $vsName . '" id="' . $vsId . '" value="' . $vsValue . '"';
		if ( ! $vsClass == '' ) $sReturn .= ' class="' . $vsClass . '"';
		if ( is_array($vaAttr) )
		{
			foreach ($vaAttr as $key => $val)
			{
				$sReturn .= ' ' . $key . '="' . $val . '"';
			}
		}
		$sReturn .= ' />';

		return $sReturn;

	}


	/*--------------------------------------------------------------------------------------------------
	Image

		$vaAttr		Additional attributes : array(style, tabindex, accesskey, etc)

		created 2010-03-16 14:22:47 <pippin.zaenul@gmail.com>
	--------------------------------------------------------------------------------------------------*/
	function show_image ($vsLocation, $vsTitle = '', $vsClass = NULL, $vnBorder = NULL, $vnWidth = NULL, $vnHeight = NULL, $vsLink = NULL)
	{
		$sReturn = '<img src="' . $vsLocation . '" border="' . $vnBorder . '"';
		if ( ! is_null($vsTitle) ) $sReturn .= ' title="' . $vsTitle . '"';
		if ( ! is_null($vsClass) ) $sReturn .= ' class="' . $vsClass . '"';
		if ( ! is_null($vsClass) ) $sReturn .= ' class="' . $vsClass . '"';
		if ( ! is_null($vnWidth) ) $sReturn .= ' width="' . $vnWidth . '"';
		if ( ! is_null($vnHeight) ) $sReturn .= ' height="' . $vnHeight . '"';
		$sReturn .= ' />';

		return $sReturn;

	}

	/*--------------------------------------------------------------------------------------------------
	Checkbox

		$vaAttr		Additional attributes : array(style, tabindex, accesskey, etc)

		created 2010-03-18 20:05:31 <pippin.zaenul@gmail.com>
	--------------------------------------------------------------------------------------------------*/
	function form_checkbox ($vsName, $vsId, $vsValue, $vaChecked = NULL, $vsClass = NULL, $vsTitle = NULL, $vaAttr = NULL)
	{
		
		if ( ! is_array($vaChecked) ) $vaChecked = array();
		
		$sReturn = '<input type="checkbox" name="' . $vsName . '" id="' . $vsId . '" value="' . $vsValue . '"';
		if (in_array($vsValue, $vaChecked)) $sReturn .= ' checked="checked"';
		if ( ! is_null($vsClass) ) $sReturn .= ' class="' . $vsClass . '"';
		if ( ! is_null($vsTitle) ) $sReturn .= ' title="' . $vsTitle . '"';
		$sReturn .= ' />';

		unset($vaValue);

		return $sReturn;
	}

	/*--------------------------------------------------------------------------------------------------
	Radio

		$vaAttr		Additional attributes : array(style, tabindex, accesskey, etc)

		created 2010-03-18 20:05:31 <pippin.zaenul@gmail.com>
	--------------------------------------------------------------------------------------------------*/
	function form_radio ($vsName, $vsId, $vsValue, $vsChecked, $vsClass = NULL, $vsTitle = NULL, $vaAttr = NULL)
	{
		
		$sReturn = '<input type="radio" name="' . $vsName . '" id="' . $vsId . '" value="' . $vsValue . '"';
		if ($vsValue == $vsChecked) $sReturn .= ' checked="checked"';
		if ( ! is_null($vsClass) ) $sReturn .= ' class="' . $vsClass . '"';
		if ( ! is_null($vsTitle) ) $sReturn .= ' title="' . $vsTitle . '"';
		$sReturn .= ' />';

		return $sReturn;
	}

	/*--------------------------------------------------------------------------------------------------
	Set default value for a particular variable
		Variable passed by reference otherwise the view will throw Message: Undefined variable


		created 2010-08-19 16:40:17 <pippin.zaenul@gmail.com>
	--------------------------------------------------------------------------------------------------*/
	function set_defval (&$ruVar, $vuDef = '', $vnOpt = null)
	{
		$uRet = (isset($ruVar) ? $ruVar : $vuDef);
		return $uRet;
	}

	/*
	function form_jquery_datepick ($vsElement, $vsDateFormat = 'yy-mm-dd', $vaAttr = NULL)
	{
		$sReturn = '<script type="text/javascript">' . 
			'$(document).ready(function() {' .
			'$(\'#' . $vsElement . '\').datepick({dateFormat: \'' . $vsDateFormat . '\'});' . 
			'$(\'#inlineDatepicker\').datepick({onSelect: showDate});' . 
			'});' . 
			'</script>';
		
		return $sReturn;

	}
	*/
	
}

/* End of file App_html.php */
/* Location: ./system/application/libraries/App_html.php */