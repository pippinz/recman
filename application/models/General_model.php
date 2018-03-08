<?php

/*--------------------------------------------------------------------------------------------------
	2012-10-05 11:52:38 <moxerian@gmail.com>
--------------------------------------------------------------------------------------------------*/

class General_model extends CI_Model {

	function __construct() 
	{
		 parent::__construct();
		 $this->load->library('app_util');
	}

	function listing( $aAttr )
	{
		// Need it to update the where clause query
		$this->db->flush_cache();

		$this->db->start_cache();
		//$this->db->_compile_select();

		if (array_key_exists( 'filter', $aAttr))
		{
			foreach( $aAttr['filter'] as $a )
			{
				$sEquiv = $a[1];
				switch( $sEquiv )
				{
					case '':
						break;
					case 'in':
						$this->db->where_in( $a[0], $a[2] );
						break;
					default:
						$this->db->where( $a[0], $a[2] );
				}
			}
		}

		// Populate list
		$this->db->from( $aAttr['table'] );
		$aRec['rec_count'] = $this->db->count_all_results();
		$this->db->select( $aAttr['fields'] );
		if ( array_key_exists( 'limit', $aAttr ) AND array_key_exists( 'offset', $aAttr ) ) $this->db->limit( $aAttr['limit'], $aAttr['offset'] );
		if ( array_key_exists( 'orderby', $aAttr ) )
		{
			foreach( $aAttr['orderby'] as $a )
			{
				$this->db->order_by( $a[0], $a[1] );
			}
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		$this->db->flush_cache();
		$aRec['rec_list'] = $query->result_array();
		return $aRec;
	}

	function read( $aAttr )
	{

		// Update to the most recent where clause query
		$this->db->flush_cache();
		
		$this->db->select( $aAttr['fields'] );
		if (array_key_exists( 'filter', $aAttr))
		{
			foreach( $aAttr['filter'] as $a )
			{
				$sEquiv = $a[1];
				switch( $sEquiv )
				{
					case '':
						break;
					default:
						$this->db->where( $a[0], $a[2] );
				}
			}
		}
		$this->db->from( $aAttr['table'] );
		$this->db->limit(1);
		$query = $this->db->get();
		//echo $this->db->last_query();
		$fields = $query->list_fields();
		$row = $query->row_array();
		if (count($row) > 0)
		{
			$row['isrecord'] = TRUE;
		}
		else
		{
			$row['isrecord'] = FALSE;
			$this->app_util->generate_null_fields($row, $fields);
			$row['status'] = 1;
		}
		return $row;
	}

	function insert( $aModel )
	{
		$this->db->trans_start();
		//$this->db->_compile_select();
		$trans_status = TRUE;
		$bExec = $this->db->insert( $aModel['table'], $aModel['data'] );
		if ( $bExec )
		{
			$aDb['id'] = $this->db->insert_id();
		}
		else
		{
			$aDb['id'] = "0";
			$aDb['error_number'] = $this->db->_error_number();
			$trans_status = FALSE;
		}
		//echo $this->db->last_query();
		$this->db->trans_complete();
		$aDb['trans_status'] = $trans_status;
		return $aDb;
	}

	function update( $aModel )
	{
		$this->db->trans_start();
		//$this->db->_compile_select();
		$trans_status = TRUE;
		foreach ( $aModel['where'] as $key => $val )
		{
			$this->db->where( $key, $val );
		}
		if (array_key_exists('whereop', $aModel))
		{
			$this->db->where( $aModel['whereop'] );
		}
		if (array_key_exists('where', $aModel))
		{
			if (array_key_exists('id', $aModel['where']))
			{
				$aDb['id'] = $aModel['where']['id'];
			}
		}

		$bExec = $this->db->update( $aModel['table'], $aModel['data'] );
		if ( !$bExec )
		{
			$aDb['error_number'] = $this->db->_error_number();
			$trans_status = FALSE;
		}
		//echo $this->db->last_query();
		$this->db->trans_complete();
		$aDb['trans_status'] = $trans_status;
		if (!array_key_exists('id', $aDb)) $aDb['id'] = 0;
		return $aDb;
	}

	function del( $aModel )
	{
		$this->db->flush_cache();

		$this->db->start_cache();


		$this->db->trans_start();
		//$this->db->_compile_select();
		$trans_status = TRUE;
		$bExec = $this->db->delete( $aModel['table'], $aModel['where'] );
		if ( !$bExec )
		{
			$aDb['error_number'] = $this->db->_error_number();
			$trans_status = FALSE;
		}
		//echo $this->db->last_query();
		$this->db->trans_complete();
		$aDb['trans_status'] = $trans_status;
		return $aDb;
	}


} // end of class

