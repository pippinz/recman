<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*--------------------------------------------------------------------------------------------------
Utility functions

	created 2010-11-08 16:35:13 <zaenul@gmail.com>
--------------------------------------------------------------------------------------------------*/

class App_util {

	function year_lkp ($p)
	{
		/*--------------------------------------------------------------------------------------------------
		Year lookup

			created 2017-04-29 01:34:55 <zaenul@gmail.com>
		--------------------------------------------------------------------------------------------------*/
		$aR = NULL;
		for ($i = $p['start']; $i <= $p['end']; $i++)
		{
			$aR[$i] = $i;
		}
		return $aR;
		unset($aR);
	}
	
	function rs2arrkeyval ($voRs = NULL)
	{
		/*--------------------------------------------------------------------------------------------------
		Restructure recordset to become array key based suits to HTML select input

			voRs = recordset data type in form of result_array();
			created 2010-11-08 16:35:13 <zaenul@gmail.com>
		--------------------------------------------------------------------------------------------------*/
		$aRet = NULL;
		if (is_array($voRs))
		{
			foreach ($voRs as $arr)
			{
				$id = $arr['id'];
				$name = $arr['name'];
				$aRet[$id] = $name;
			}
		}
		return $aRet;
		unset($aRet);
	}

	function db_lookup_combo ($vsSql)
	{
		/*--------------------------------------------------------------------------------------------------
		Lookup into db and format it as db combo box array

			vsSql = Sql syntax to retrieve data from database
			created 2010-11-08 16:35:13 <zaenul@gmail.com>
		--------------------------------------------------------------------------------------------------*/
		$ci =& get_instance();
		$query = $ci->db->query($vsSql);
		$ra = $query->result_array();
		$aRet = $this->rs2arrkeyval($ra);
		return $aRet;
	}

	function generate_null_fields (&$row, $voFields)
	{
		/*--------------------------------------------------------------------------------------------------
		To give NULL value to defined fields

		created 2010-11-11 17:07:05 <zaenul@gmail.com>
		--------------------------------------------------------------------------------------------------*/
		foreach ($voFields as $field)
		{
			$row[$field] = NULL;
		}
		return $row;
	}

	function pad ($vsVal, $vsPad, $vnLength, $vnOption = 'left'){
		/*--------------------------------------------------------------------------------------------------
		To format a string by giving it paddings
			$vsVal		: value needs padding
			$vsPad		: character used as padding
			$vnLength	: length of the final result
			$vnOpt		: option: left = padding as prefix; right = padding as suffix

		created 2010-12-09 13:17:16 <zaenul@gmail.com>
		--------------------------------------------------------------------------------------------------*/
		$sTmp = $vsVal;
		if (is_null($vsVal) || $vsVal=="") {
			$nLen = 0;
		} else {
			$vsVal = trim($vsVal);
			$nLen = strlen($vsVal);
		}
		for ($nLoop = $nLen; $nLoop < $vnLength; $nLoop++){
			if ($vnOption == 'left') {
				$sTmp = $vsPad . $sTmp;
			}else{
				$sTmp .= $vsPad;
			}
		}
		return $sTmp;
	}

	function check_empty_var ($vuVar, $vuVarType = 'str', $vuDef = NULL)
	{
		/*--------------------------------------------------------------------------------------------------
		Replace empty entri to NULL

			voRs = recordset data type in form of result_array();
			created 2010-11-08 16:35:13 <zaenul@gmail.com>
		--------------------------------------------------------------------------------------------------*/
		$uVar = $vuVar;
		if ( is_null($uVar) || trim($uVar === '') )
		{
			$uVar = $vuDef;
		}
		return $uVar;
	}

	function valid_date($str) 
	{
		/*--------------------------------------------------------------------------------------------------
		To check valid date format

			created 2011-01-25 14:51:17 <pippin.zaenul@gmail.com>
		--------------------------------------------------------------------------------------------------*/
		if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$str)) {
			$arr = explode("-", $str);
			$yyyy = (int) $arr[0];
			$mm = (int) $arr[1];
			$dd = (int) $arr[2];
			return checkdate($mm, $dd, $yyyy);
		} else {
			return false;
		}
	}

	function input_date($str, $ret = NULL)
	{
		if ($this->valid_date($str)) return $str;
		return $ret;
	}

	function input_num($str, $ret = NULL)
	{
		if ((int) $str == 0) return $ret;
		return $str;
	}

	function valid_year($str)
	{
		if (ereg("([0-9]{4})", $str)) {
			return true;
		} else {
			return false;
		}
	}

	function date_add ( $vdSource, $vnOpt = 1, $vaTime )
	{
		/*--------------------------------------------------------------------------------------------------
		To add date with particular period of time

			Pars
				$vdSource	: Date to add in UNIX timestamp format
				$vnOpt		: Input & output option: 
								1 = Unix timestamp
								2 = Human format date Y-m-d H:i:s; 
				$vaTime		: Array of time with single or all below keys
								Array (
									'year' => 0, 
									'month' => 0, 
									'week' => 0,
									'day' => 0,
									'minute' => 0, 
									'second' =>
									);

			Return
				based on the vnOpt

			created 2011-06-03 10:02:23 <pippin.zaenul@gmail.com>
		--------------------------------------------------------------------------------------------------*/

		$nSecond = array_key_exists( 'second', $vaTime ) ? $vaTime[ 'second' ] : 0;
		$nMinute = array_key_exists( 'minute', $vaTime ) ? $vaTime[' minute' ] : 0;
		$nHour = array_key_exists( 'hour', $vaTime ) ? $vaTime[ 'hour' ] : 0;
		$nDay = array_key_exists( 'day', $vaTime ) ? $vaTime[ 'day' ] : 0;
		if ( array_key_exists( 'week', $vaTime ) ) $nDay = $nDay + ( $vaTime[ 'week' ] * 7 );
		$nMonth = array_key_exists( 'month', $vaTime ) ? $vaTime[ 'month' ] : 0;
		$nYear = array_key_exists( 'year', $vaTime ) ? $vaTime[ 'year' ] : 0;

		$dSource = $vdSource;
		$dTmp = mktime(
			date( 'H', $dSource ) + $nHour, 
			date( 'i', $dSource ) + $nMinute, 
			date( 's', $dSource ) + $nSecond, 
			date( 'm', $dSource ) + $nMonth, 
			date( 'd', $dSource ) + $nDay, 
			date( 'Y', $dSource ) + $nYear 
			);
		
		switch ( $vnOpt )
		{
			case 1:
				$dRet = $dTmp;
				break;
			case 2:
				$dRet = date( 'Y-m-d H:i:s', $dTmp );
				break;
			case 3:
				$dRet = date( 'Y-m-d', $dTmp );
				break;
		}

		return $dRet;
	}

	function date_substract ( $vdSource, $vnOpt = 1, $vaTime )
	{
		/*--------------------------------------------------------------------------------------------------
		To substract date with particular period of time

			It will call date_add function with reversed value paramaters.
			See date_add function for detail.

			Return
				based on the vnOpt

			created 2011-06-05 10:01:13 <pippin.zaenul@gmail.com>
		--------------------------------------------------------------------------------------------------*/

		foreach( $vaTime as $key => $val )
		{
			$vaTime[ $key ] = - ( $val );
		}

		return $this->date_add( $vdSource, $vnOpt, $vaTime );

	}

	function blank_to_null($str)
	{
		if (trim($str) == '') $str = NULL;
		return $str;
	}

	function uniquekey ( $length=9, $strength=0 ) 
	{
		$vowels = 'aeuy';
		$consonants = 'bdghjmnpqrstvz';
		if ($strength & 1) {
			$consonants .= 'BDGHJLMNPQRSTVWXZ';
		}
		if ($strength & 2) {
			$vowels .= "AEUY";
		}
		if ($strength & 4) {
			$consonants .= '23456789';
		}
		if ($strength & 8) {
			$consonants .= '@#$%';
		}
	 
		$password = '';
		$alt = time() % 2;
		for ($i = 0; $i < $length; $i++) {
			if ($alt == 1) {
				$password .= $consonants[(rand() % strlen($consonants))];
				$alt = 0;
			} else {
				$password .= $vowels[(rand() % strlen($vowels))];
				$alt = 1;
			}
		}
		return $password;
	}

	function create_dir( $p )
	{
		/*--------------------------------------------------------------------------------------------------
		To create a folder
		Par	is array of:
			path		: directory location to be created
			mode		: permission mode 
			recursive	: true

		created 2017-04-10 07:06:00 <pippin.zaenul@gmail.com>
		--------------------------------------------------------------------------------------------------*/
		if (!is_dir($p['path']))
		{
			mkdir($p['path'], $p['mode'], true);
			return true;
		}
		return false;
	}

}
