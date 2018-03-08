<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {
	/*--------------------------------------------------------------------------------------------------
	Custom form validation class

		2011-01-14 06:50:17 <moxerian@gmail.com>
	--------------------------------------------------------------------------------------------------*/

	var $ci;
	var $lang = 'english'; // Set user language, 'english' as the default value
	var $forbidden_words = '';

    function __construct()
    {
        //parent::CI_Form_validation();
		parent::__construct();

		$this->ci =& get_instance();
		$this->ci->lang->load('my_form_validation', $this->lang);
    }

	function initialize ( $params = array() )
	{
		/*--------------------------------------------------------------------------------------------------
		Initialization, to set variable values thru parameters passed

			2011-02-11 19:04:40 <moxerian@gmail.com>
		--------------------------------------------------------------------------------------------------*/
		if ( count( $params ) > 0 )
		{
			foreach( $params as $key => $value )
			{
				if ( isset( $this->$key ) )
				{
					$this->$key = $value;
				}
			}
		}

		$this->ci =& get_instance();
		$this->ci->lang->load('my_form_validation', $this->lang);
	}

	function full_booked_date ( $str, $val )
	{
		/*--------------------------------------------------------------------------------------------------
		SPECIFIC Svarga
		If booking date range contains full-booked date then reject it
			Pars
				$str: value submitted
				$val: value written in set_rule function, comma delimiter
					0: table name
					1: column name
					2: data type of the column [string|numeric]

			created 2011-03-31 13:05:26 <moxerian@gmail.com>
		--------------------------------------------------------------------------------------------------*/
		return FALSE;
	}

	function unique ( $str, $val )
	{
		/*--------------------------------------------------------------------------------------------------
		Minimum value
			Pars
				$str: value submitted
				$val: value written in set_rule function, comma delimiter
					0: table name
					1: column name
					2: data type of the column [string|numeric]

			created 2011-03-31 13:05:26 <moxerian@gmail.com>
		--------------------------------------------------------------------------------------------------*/
		list($table, $column, $type) = explode(".", $val, 3);
		if ($type == 'string') $str = "'" . $str . "'";
		$sSql = "SELECT COUNT(0) AS numrow FROM " . $table . " WHERE " . $column . " = " . $str . "";
		$query = $this->ci->db->query($sSql);
		$row = $query->row();
		return ($row->numrow > 0) ? FALSE : TRUE;
	}

	function min_val ( $str, $val )
	{
		/*--------------------------------------------------------------------------------------------------
		Minimum value
			Pars
				$str: value submitted
				$val: value written in set_rule function

			created 2011-01-14 06:50:17 <moxerian@gmail.com>
		--------------------------------------------------------------------------------------------------*/
		if ( preg_match( "/[^0-9.]/", $val ) )
		{
			return FALSE;
		}
		return ( $str >= $val ) ? TRUE : FALSE;
	}

	function max_val ( $str, $val )
	{
		/*--------------------------------------------------------------------------------------------------
		Maximum value
			Pars
				$str: value submitted
				$val: value written in set_rule function

			created 2011-01-14 06:50:17 <moxerian@gmail.com>
		--------------------------------------------------------------------------------------------------*/
		if ( preg_match( "/[^0-9.]/", $val ) )
		{
			return FALSE;
		}
		return ( $str <= $val ) ? TRUE : FALSE;
	}

	function in_list ($str, $val)
	{
		/*--------------------------------------------------------------------------------------------------
		To ensure that the data is in the predefined list

			created 2011-01-18 15:42:05 <moxerian@gmail.com>
		--------------------------------------------------------------------------------------------------*/
		//if ( $str == '' or is_null( $str ) ) return FALSE;
		$aList = split(",", $val);
		return ( in_array( $str, $aList ) ) ? TRUE : FALSE;
	}

	function valid_date($str) 
	{
		/*--------------------------------------------------------------------------------------------------
		To check valid date format

			created 2011-01-25 14:51:17 <moxerian@gmail.com>
		--------------------------------------------------------------------------------------------------*/
		//if (ereg("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})", $str)) {
		if (preg_match("/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/", $str)) 
		{
			//$arr = split("-", $str);
			$arr = preg_split("/-/", $str);
			$yyyy = (int) $arr[0];
			$mm = (int) $arr[1];
			$dd = (int) $arr[2];
			return checkdate($mm, $dd, $yyyy);
		} else {
			return false;
		}
	}

	function exact_value ( $str, $val )
	{
		/*--------------------------------------------------------------------------------------------------
		The value submitted must equals to a particular value

			created 2011-01-26 11:31:33 <moxerian@gmail.com>
		--------------------------------------------------------------------------------------------------*/
		if ( strcmp( strval( $str ), strval( $val ) )  !== 0 ) return FALSE;
		return TRUE;
	}

	function min_date ( $str, $field )
	{
		/*--------------------------------------------------------------------------------------------------
		Minimum value of date supplied

			created 2011-01-25 16:17:14 <moxerian@gmail.com>
		--------------------------------------------------------------------------------------------------*/
	}

	function compare_date ( $str, $val )
	{
		/*--------------------------------------------------------------------------------------------------
		To compare two date data
			Pars

			created 2011-01-25 14:51:48 <moxerian@gmail.com>
		--------------------------------------------------------------------------------------------------*/
		//$aVal = split( "[.]", $val );
		$aVal = explode( ".", $val );
		$sOperator = $aVal[ 0 ];
		$field = $aVal[ 1 ];
		if ( isset($_POST[$field]))
		{
			$field = $_POST[$field];
		}

		if ( !$this->valid_date( $field ) ) return FALSE;
		if ( !$this->valid_date( $str ) ) return FALSE;

		/* Avoid using strtotime because it reads the Unix timestamp which has maximum valid value is 19 Jan 2038 03:14:07 UTC
		$nStr = strtotime( $str );
		$nField = strtotime( $field );
		*/

		$aStr = explode( '-', $str );
		if ( strlen( $aStr[ 1 ] ) == 1 ) $aStr[ 1 ] = "0" . $aStr[ 1 ];
		if ( strlen( $aStr[ 2 ] ) == 1 ) $aStr[ 2 ] = "0" . $aStr[ 2 ];
		$sStr = $aStr[ 0 ] . $aStr[ 1 ] . $aStr[ 2 ];
		$nStr = ( int ) $sStr;

		$aField = explode( '-', $field );
		if ( strlen( $aField[ 1 ] ) == 1 ) $aField[ 1 ] = "0" . $aField[ 1 ];
		if ( strlen( $aField[ 2 ] ) == 1 ) $aField[ 2 ] = "0" . $aField[ 2 ];
		$sField = $aField[ 0 ] . $aField[ 1 ] . $aField[ 2 ];
		$nField = ( int ) $sField;

		$nRet = FALSE;
		switch ( $sOperator )
		{
			case "gt": // greater than
				if ( $nStr > $nField ) $nRet = TRUE;
				break;
			case "ge": // greater equal
				if ( $nStr >= $nField ) $nRet = TRUE;
				break;
			case "lt": // less than
				if ( $nStr < $nField ) $nRet = TRUE;
				break;
			case "le": // less equal
				if ( $nStr <= $nField ) $nRet = TRUE;
				break;
			default:
				$bRet = FALSE;
		}
		return $nRet;
	}

	function valid_words ( $str )
	{
		/*--------------------------------------------------------------------------------------------------
		To prevent the submitted field contains forbidden words

			created 2011-02-11 21:16:04 <moxerian@gmail.com>
		--------------------------------------------------------------------------------------------------*/
		$bReturn = TRUE;
		if ( $this->forbidden_words === '') return FALSE;
		$aWords = explode( ',', $this->forbidden_words );
		foreach( $aWords as $sWord )
		{
			$sWord = trim( $sWord );
			$uPos = stripos( $str, $sWord );
			if (ereg("([0-9])", $uPos)) // Avoid using boolean because the word can be in 0 (first) position
			{
				$bReturn = FALSE;
				break;
			}
		}
		return $bReturn;
	}

	function lower_alpha_numeric( $str )
	{
		/*--------------------------------------------------------------------------------------------------
		Only allow a-z (lowercase) and 0-9

			created 2011-03-17 21:54:21 <moxerian@gmail.com>
		--------------------------------------------------------------------------------------------------*/
		return ( preg_match("([^a-z0-9])", $str)) ? FALSE : TRUE;
	}

	function alpha_underscore($str)
	{
		/*--------------------------------------------------------------------------------------------------
		Only allow a-z (lowercase), 0-9 and underscore (_)

			created 2011-03-17 21:54:21 <moxerian@gmail.com>
		--------------------------------------------------------------------------------------------------*/
		return ( ! preg_match("/^([a-z0-9_])+$/i", $str)) ? FALSE : TRUE;
	}
	
	function block_url_and_email($str)
	{
		/*--------------------------------------------------------------------------------------------------
		Forbid entry from filling URL & email

			created 2011-06-16 16:31:13 <moxerian@gmail.com>
		--------------------------------------------------------------------------------------------------*/
		return ( preg_match("/[\w\[@\]&.%*-]+\.[\w*.]*[\w-*]{2,}\/?/", $str)) ? FALSE : TRUE;
	}

	function block_web_extension($str)
	{
		/*--------------------------------------------------------------------------------------------------
		If the URL has a web extension, only allow the defined extension

			created 2011-06-16 16:31:13 <moxerian@gmail.com>
		--------------------------------------------------------------------------------------------------*/
		return ( ! preg_match("/(https?:\/\/)([\w*-]+)\.([\w*.-]*)([\w*]{2,3})(.+)(\.(as[ap]?x?|php|[ps]?html?|cgi|jsp|cfm|pl|pm)\b|\/\B)/", $str)) ? FALSE : TRUE;
	}

	function block_multi_capital($str)
	{
		/*--------------------------------------------------------------------------------------------------
		Forbid entry with multiple capitalized sentences

			created 2011-06-29 08:19:42 <moxerian@gmail.com>
		--------------------------------------------------------------------------------------------------*/
		$pattern = "/[A-Z]{2,}/";
		$matched = array();
		preg_match_all( $pattern, $str, $matched );
		$count = count( $matched,1 );
		$count = ( $count - 1 );
		return ( $count > 1 ) ? FALSE : TRUE;
	}

	function http_prefix($str)
	{
		/*--------------------------------------------------------------------------------------------------
		URL must start with http://

			created 2011-06-29 10:04:19 <moxerian@gmail.com>
		--------------------------------------------------------------------------------------------------*/
		/*
		$pattern = "/[A-Z]{2,}/";
		$matched = array();
		preg_match_all( $pattern, $str, $matched );
		$count = count( $matched,1 );
		$count = ( $count - 1 );
		return ( $count > 1 ) ? FALSE : TRUE;
		*/
		return TRUE;
	}

	function serial_date ( $str, $val )
	{
		/*--------------------------------------------------------------------------------------------------
		To ensure that is no back date submitted which cause double data in surcharge
			Pars
				$str: value submitted
				$val: value written in set_rule function, comma delimiter

			created 2013-07-11 11:25:27 <moxerian@gmail.com>
		--------------------------------------------------------------------------------------------------*/
		//if ( !$this->valid_date( $str ) ) return FALSE; Already handle by valid_date function in form validation rule in the controller

		list($table, $column) = explode(".", $val, 2);
		$sSql = "SELECT COUNT(0) AS numrow FROM " . $table . " WHERE " . $column . " >= '" . $str . "'";
		$query = $this->ci->db->query($sSql);
		$row = $query->row();
		return ($row->numrow > 0) ? FALSE : TRUE;
	}

}
