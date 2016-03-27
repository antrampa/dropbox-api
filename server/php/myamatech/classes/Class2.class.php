<?php
include("tbl_param_class_AddEditDelete.php");


//New Class
class Class2 extends TtblParamAddEditDelete  
{
	
	/*
	* @existStyleDiplaDipla( $code3,$patternCode,$primColorCode,$secColorCode )
	*
	*/
	public function existStyleDiplaDipla( $code3,$patternCode,$primColorCode,$secColorCode )
	{
		$styleCode = $code3."-".$patternCode.$primColorCode.$secColorCode;
		$styleCodeAnapoda = $code3."-".$patternCode.$secColorCode.$primColorCode;
		$sql = "SELECT tb4_unique
				FROM kodikos_4
				WHERE tb4_code = '".$styleCode."' 
				OR tb4_code = '".$styleCodeAnapoda."'  ";
		$res = $this->excQuery($sql);
		
		if( is_numeric($res[0]['tb4_unique']) )
			return true;
		else
			return false;	
		
	}
	
	
	/*
	* @existStyle( $code3,$patternCode,$primColorCode,$secColorCode )
	*
	*/
	public function existStyle( $code3,$patternCode,$primColorCode,$secColorCode )
	{
		$styleCode = $code3."-".$patternCode.$primColorCode.$secColorCode;
		$sql = "SELECT tb4_unique
				FROM kodikos_4
				WHERE tb4_code = '".$styleCode."' 
				";
		$res = $this->excQuery($sql);
		
		if( is_numeric($res[0]['tb4_unique']) )
			return true;
		else
			return false;	
	}
	
	/*
	* @createNewStyle( $shape,$pattern,$primColor,$secColor )
	*
	*/
	public function createNewStyle( $shape,$pattern,$primColor,$secColor )
	{
		$code3 = $this->getSomeDesc( $shape,"general_table_tp","3code","gentable_id");
		$patternCode = $this->getSomeDesc($pattern,"Patterns","code","id");
		$primColorCode = $this->getSomeDesc($primColor,"prototype_colors","color_code","color_id");
		$secColorCode = $this->getSomeDesc($secColor,"prototype_colors","color_code","color_id");
		
		//$price_category = $this->getSomeDesc($pattern,"Patterns","price_category","id");
		//$price_category += $this->getSomeDesc($primColor,"prototype_colors","color_code","color_id");
	
		$styleCode = $code3."-".$patternCode.$primColorCode.$secColorCode;
		if( strlen($styleCode) )
		{
			$sql = "INSERT INTO kodikos_4
					(
						tb4_code,
						primary_color_id,
						secondary_color_id,
						pattern_id
					)
					VALUES
					(
						'".$styleCode."',
						'".$primColor."',
						'".$secColor."',
						'".$pattern."'
					)
					";
			$res = mysql_query($sql);
			if( $res )
				return $res;
			else
			{
				$str = mysql_error();
				return $str;
			}	
		}
		
	}
	
	
	
	/*
	* @updateAStyle( $shape,$pattern,$primColor,$secColor )
	*
	*/
	public function updateAStyle( $shape,$pattern,$primColor,$secColor )
	{
		$code3 = $this->getSomeDesc( $shape,"general_table_tp","3code","gentable_id");
		$patternCode = $this->getSomeDesc($pattern,"Patterns","code","id");
		$primColorCode = $this->getSomeDesc($primColor,"prototype_colors","color_code","color_id");
		$secColorCode = $this->getSomeDesc($secColor,"prototype_colors","color_code","color_id");
		
		//$price_category = $this->getSomeDesc($pattern,"Patterns","price_category","id");
		//$price_category += $this->getSomeDesc($primColor,"prototype_colors","color_code","color_id");
	
		$styleCode = $code3."-".$patternCode.$primColorCode.$secColorCode;
		if( strlen($styleCode) )
		{
			$sql = "UPDATE kodikos_4 SET 
						primary_color_id = '".$primColor."',
						secondary_color_id = '".$secColor."',
						pattern_id = '".$pattern."'
					WHERE tb4_code = '".$styleCode."' 
					";
			$res = mysql_query($sql);
			if( $res )
				return $res;
			else
			{
				$str = mysql_error();
				return $str;
			}
		}
				
	}
	

	/*
	* @getStyleFiled($code3,$patternCode,$primColorCode,$secColorCode,$returnField)
	*
	*/
	public function getStyleFiled($code3,$patternCode,$primColorCode,$secColorCode,$returnField)
	{
		$styleCode = $code3."-".$patternCode.$primColorCode.$secColorCode;
		$styleCodeAnapoda = $code3."-".$patternCode.$secColorCode.$primColorCode;
		if( strlen( $returnField ) )
		{
			$sql = "SELECT $returnField
					FROM kodikos_4
					WHERE tb4_code = '".$styleCode."' 
					OR tb4_code = '".$styleCodeAnapoda."'  ";
			$res = $this->excQuery($sql);
		
			if( strlen( $res[0][$returnField] ) )
				return $res[0][$returnField];
			else
				return 0;	
		}
	}
	
	
	
	/*
	* @myglassplate_4code( $code )
	*
	*/
	public function myglassplate_4code( $code )
	{
		if( strlen( $code ) )
		{
			$newCode = "12345";
			return $newCode;
		}
		else
			return $code;
	}
	
	
	/*
	* @tiger_glass_4code( $code )
	*
	*/
	public function tiger_glass_4code( $code )
	{
		
	}
	
	
	public function getMyGlassPlateTotalAmount($order_id)
	{
		if( is_numeric( $order_id ) )
		{
			$sql = "SELECT *
					FROM wishbasket_glassplate W
					LEFT JOIN glas_apps_all.tbl_ts_4code FC ON W.4code_id = FC.tbl_ts_4code_id 
					
					WHERE W.order_id = '".$order_id."' ";
			$res = $this->excQuery($sql);
			$total = 0;
			for( $i=0;$i<count($res);$i++ )
			{
				    $pattrnPC = $this->getSomeDesc( $res[$i]['tbl_ts_4code_pattern_id'],"Patterns","price_category","id" );
					$color1 = $this->getSomeDesc( $res[$i]['tbl_ts_4code_color1_id'],"prototype_colors","color_price_cat","color_id" );
					$pcAll = $pattrnPC + $color1;// + $color2;
					$shape_id =  $res[$i]['tbl_ts_4code_shape_id'];
					
					if( strlen($shape_id) && is_numeric($pcAll) && $pcAll <= 13 && $pcAll > 0  )
					{
						$fieldPR = "priceMGP2";
						if( $pattrnPC == B400_PATTERN && $color1 == B400_COLOR )
							$fieldPR = "priceMGP1";
								
						//echo $fieldPR;
						$sql = "SELECT $fieldPR 
								FROM price_shape_v3 
								WHERE shape_id = '".$shape_id."' ";
						$res_pr = $myClass->excQuery($sql);		
						$euro = $res_pr[0][$fieldPR]; //$myClass->getSomeDesc( "B1-C2-00","price_shape","price10","3code" );
						
					}
					
				$total += $res[$i]['quantity'] * $res[$i]['tbl_ts_4code_masterpack_pcs'] * $euro; 	
			}
			
			return $total;
					
		}
		else
			return 0;
	}
	
	
	public function getPatternsIdsFromShape($shape_id)
	{
		//Get tbtech4_unique IDs and SR DEB Ginetai I Ginetai ( tbl_ts_shape_ts_glue_nontransp )
		$sql = "SELECT LGT.tbl_param_technic_shapes_group_link_technic_technic_id, 	TSHP.tbl_ts_shape_ts_glue_nontransp
				FROM general_table_tp  G 
				INNER JOIN tbl_param_technic_shapes_group GT ON GT.tbl_param_technic_shapes_group_id = G.gentable_technic_group_id 
				INNER JOIN tbl_param_technic_shapes_group_link_technic LGT ON GT.tbl_param_technic_shapes_group_id = LGT.tbl_param_technic_shapes_group_link_technic_group_id  	
		
				LEFT JOIN glass_apps_all.tbl_ts_shape_ts TSHP ON G.gentable_id = TSHP.tbl_ts_shape_ts_shape_id
		
				WHERE gentable_id = '".$shape_id."'";
		$res_sh = $this->excQuery($sql);

		$patternsID = "";
		$koma = "";

		for( $i=0;$i<count($res_sh);$i++ )		
		{
			//Get Patterns
			$sql = "SELECT id, sr_glue_id 
					FROM Patterns 
					WHERE tbtech4_unique = '".$res_sh[$i]['tbl_param_technic_shapes_group_link_technic_technic_id']."' ";
			$res_p = $this->excQuery($sql);		
	
			//$j = 0;
			for( $j=0;$j<count($res_p);$j++ )
			{
				if( $res_p[$j]['sr_glue_id'] == '1' && $res_sh[$i]['tbl_ts_shape_ts_glue_nontransp'] == '5' ) //Den ginontai SR Pattern kai Shape
				{
					//do nothing
				}	
				else
				{
					$patternsID .= $koma.$res_p[$j]['id'];
					$koma = ",";
				}
			}
		}
		
		return $patternsID;
	
	}
	
	
	/*
	* @remvlDate($opening_date,'m',5)
	*
	* Kanei afairesi imerominivn: 
	* p.x. $opening_date = 2009/6/01 $type = month kai $remvValue = 5 =>
	* 2009/6/01 - 5 = 2009/1/01
	*/
	public function remvlDate($opening_date,$type,$remvValue)
	{
		$dateAr = array();
		$dateAr = explode('-',$opening_date);
		
		$year  = $dateAr[0];	//date('y',$opening_date);
		$month = $dateAr[1];	//date('m',$opening_date);
		$day   = $dateAr[2];	//date('d',$opening_date);
		
		//echo "month:".$month;
		switch($type)
		{
			case 'y':
				$year -= $remvValue;
				break;
			case 'm':
				$month -= $remvValue;
				if( $month < 1 )
				{
					$year--;
					$month = 12 + $month;
				}
				break;
			case 'd':
				$day -= $remvValue;
				if( $month != 2 )
				{
					if( $day < 1 )
					{	
						$month--;
						$day = 30 + $day;
					}
					
				}
				break;
			default:
				$day -= $remvValue;
				break;			
		}
		
		$new_date = $year."-".$month."-".$day."";
		
		return $new_date;
	}
	
	/*
	* @addDate($opening_date,'m',5)
	*
	* Kanei prosthesi imerominivn: 
	* p.x. $opening_date = 2009/6/01 $type = month kai $addValue = 5 =>
	* 2009/6/01 - 5 = 2009/11/01
	*/
	public function addDate($opening_date,$type,$addValue)
	{
		$dateAr = array();
		$dateAr = explode('-',$opening_date);
		
		$year  = $dateAr[0];	//date('y',$opening_date);
		$month = $dateAr[1];	//date('m',$opening_date);
		$day   = $dateAr[2];	//date('d',$opening_date);
		
		//echo "month:".$month;
		switch($type)
		{
			case 'y':
				$year += $addValue;
				break;
			case 'm':
				$month += $addValue;
				if( $month > 12 )
				{
					$year++;
					$month = $month - 12;
				}
				break;
			case 'd':
				$day += $addValue;
				if( $month != 2 )
				{
					if( $day > 30 )
					{	
						$month++;
						$day = $day - 30;
					}
					
				}
				break;
			default:
				$day += $addValue;
				break;			
		}
		
		$new_date = $year."-".$month."-".$day."";
		
		return $new_date;
	}
	
	
	
	
	
}			//end of Class TLogin

?>