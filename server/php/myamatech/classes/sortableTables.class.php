<?php
include("tbl_param_class_AddEditDelete.php");

class TSortableTables extends TtblParamAddEditDelete
{
	var $TableName;
	var $position;
	
	
	public function TSortableTables()
	{
		$this->TableName = "";
		$this->position = "";
	}
	
	
	/*
	* @getSectionPosition($catalog_id,$section_id)
	*
	*/
	public function getSectionPosition($catalog_id,$section_id)
	{
		$sql = "SELECT prospectus_link_ctopic_topic_position
				FROM prospectus_link_ctopic
				WHERE prospectus_link_ctopic_catalog_id = '".$catalog_id."' 
				AND prospectus_link_ctopic_topic_id = '".$section_id."' ";
		$res = $this->excQuery($sql);		
		return $res[0]['prospectus_link_ctopic_topic_position'];
	}
	
	/*
	* @existOtherSectionToPosition( $section_id,$moveToPosition)
	*
	*/
	public function existOtherSectionToPosition( $catalog_id,$moveToPosition)
	{
		$sql = "SELECT prospectus_link_ctopic_id
				FROM prospectus_link_ctopic
				WHERE prospectus_link_ctopic_catalog_id = '".$catalog_id."' 
				AND prospectus_link_ctopic_topic_position = '".$moveToPosition."' ";
		$res = $this->excQuery($sql);
		
		if( is_numeric( $res[0]['prospectus_link_ctopic_id'] ) )//Has other section to this position
			echo true;
		else if( ! is_numeric( $res[0]['prospectus_link_ctopic_id'] ) )
			echo false;	
				
	}
	
	
	/*
	* @putSectionToPosition( $catalog_id,$section_id,$position )
	*
	*/
	public function putSectionToPosition( $catalog_id,$section_id,$position )
	{
		if( is_numeric( $position ) )
		{
			$sql = "UPDATE prospectus_link_ctopic SET
						prospectus_link_ctopic_topic_position = '".$position."'
					
					WHERE prospectus_link_ctopic_catalog_id = '".$catalog_id."' 
					AND prospectus_link_ctopic_topic_id = '".$section_id."' ";
			$res = mysql_query($sql);
			if( $res )		
				return $res;
			else
				return mysql_error();	
		}
		else 
			return 0;
	}
	
	
	/*
	* @accrueSectionsPosition( $catalog_id,$section_id,$position )
	*
	* Αυξάνει κατά ένα τις θέσεις των Section που βρίσκονται 
	* πάνω από την δηλωμένη θέση Position
	*/
	public function accrueSectionsPosition( $catalog_id,$section_id,$position )
	{
		$sql = "SELECT * 
				FROM prospectus_link_ctopic
				WHERE prospectus_link_ctopic_catalog_id = '".$catalog_id."' 
				AND prospectus_link_ctopic_topic_position >= '".$position."' ";
		$res = $this->excQuery($sql);
		
		for( $i=0;$i<count($res);$i++ )		
		{
			$newPosition = $res[$i]['prospectus_link_ctopic_topic_position'] + 1;
			$sql = "UPDATE prospectus_link_ctopic SET 
						prospectus_link_ctopic_topic_position = '".$newPosition."'
					WHERE prospectus_link_ctopic_id = '".$res[$i]['prospectus_link_ctopic_id']."' ";
			$res_up = mysql_query($sql) or die( mysql_error() );		
		}
		return "a".mysql_error();
	}
	
	
	/*
	* @accrueSectionsPosition( $catalog_id,$section_id,$position )
	*
	* Μειώνει κατά ένα τις θέσεις των Section που βρίσκονται 
	* κάτω από την δηλωμένη θέση Position
	*/
	public function lessenSectionsPosition( $catalog_id,$section_id,$position )
	{
		$sql = "SELECT *
				FROM prospectus_link_ctopic
				WHERE prospectus_link_ctopic_catalog_id = '".$catalog_id."'
				AND prospectus_link_ctopic_topic_position <= '".$position."' ";
		$res = $this->excQuery($sql);
		for( $i=0;$i<count($res);$i++ )		
		{
			$newPosition = $res[$i]['prospectus_link_ctopic_topic_position'] - 1;
			if( $newPosition < 0 )
				$newPosition = 0;
			$sql = "UPDATE prospectus_link_ctopic SET 
						prospectus_link_ctopic_topic_position = '".$newPosition."'
					WHERE prospectus_link_ctopic_id = '".$res[$i]['prospectus_link_ctopic_id']."' ";
			$res_up = mysql_query($sql) or die( mysql_error() );				
		}		
		return "a".mysql_error();
	}
	
	
} //End of Class







?>