<?php


class TtblParamAddEditDeleteSecond extends TtblParamAddEditDelete 
{
	
	/*
	*@function getCategoriesSates($category)
	*
	*/
	public function getCategoriesSates($category,$lang_id)
	{
		if( $category == 0 ){
			return "";	
		}
		
		$sql = "SELECT tbl_param_category_id,tbl_param_category_name_name,tbl_param_category_category_id
				FROM tbl_param_category C
				LEFT JOIN tbl_param_category_name L ON C.tbl_param_category_category_id = L.tbl_param_category_name_category_id
				WHERE tbl_param_category_id = '".$category."'
				AND tbl_param_category_name_lang_id = '".$lang_id."'
				";
		//echo $sql;		
		$res = $this->excQuery($sql);
		$res_text = "";
		for( $i=0;$i<count($res);$i++ )
		{
			$res_text .= "<a href=\"categories.php?selectedCategory=".$res[$i]['tbl_param_category_category_id']."\" class=\"stigmata\">".$res[$i]['tbl_param_category_name_name']."</a>&nbsp;/&nbsp;";	
		}
		
		if( count($res) == 0 ){
			$res_text .= "<a href=\"categories.php?selectedCategory=".$res[$i]['tbl_param_category_category_id']."\" class=\"stigmata\">Κατηγορίες</a>&nbsp;/&nbsp;";	
		}
		
		
		//This Category
		$sql = "SELECT tbl_param_category_name_name
				FROM tbl_param_category_name L
				WHERE  L.tbl_param_category_name_category_id = '".$category."'
				AND tbl_param_category_name_lang_id = '".$lang_id."'
				";
		$res = $this->excQuery($sql);
		
		$res_text .= "".$res[0]['tbl_param_category_name_name'];
		
		return $res_text;
	}
	
	
	/*
	*@function getCategorySubCategoriesLinks($category)
	*
	*/
	public function getCategorySubCategoriesLinks($category,$lang_id)
	{
		if( $category == 0 ){
			return "";	
		}
		
		$sql = "SELECT tbl_param_category_id,tbl_param_category_name_name,tbl_param_category_category_id
				FROM tbl_param_category C
				LEFT JOIN tbl_param_category_name L ON C.tbl_param_category_id = L.tbl_param_category_name_category_id
				WHERE tbl_param_category_category_id = '".$category."'
				AND tbl_param_category_name_lang_id = '".$lang_id."'
				";
		//echo $sql;		
		$res = $this->excQuery($sql);
		
		if( count($res) > 0 ):
			$res_text = "<ul>";
			for( $i=0;$i<count($res);$i++ )
			{
				$res_text .= "<li>";
					$res_text .= '<a href="categories.php?selectedCategory='.$res[$i]['tbl_param_category_id'].'" >'.$res[$i]['tbl_param_category_name_name'].'</a>';	
                
                
				$res_text .= $this->getCategorySubCategoriesLinks($res[$i]['tbl_param_category_id'],$lang_id);
				
				$res_text .= "</li>";    
			}
			
			$res_text .= "</ul>";
			
		endif;
		
		return $res_text;
		
	}
	
	
	/*
	*@function getCategorySubCategoriesLinks_products($category)
	*
	*/
	public function getCategorySubCategoriesLinks_products($category,$lang_id)
	{
		if( $category == 0 ){
			return "";	
		}
		
		$sql = "SELECT tbl_param_category_id,tbl_param_category_name_name,tbl_param_category_category_id
				FROM tbl_param_category C
				LEFT JOIN tbl_param_category_name L ON C.tbl_param_category_id = L.tbl_param_category_name_category_id
				WHERE tbl_param_category_category_id = '".$category."'
				AND tbl_param_category_name_lang_id = '".$lang_id."'
				";
		//echo $sql;		
		$res = $this->excQuery($sql);
		
		if( count($res) > 0 ):
			$res_text = "<ul>";
			for( $i=0;$i<count($res);$i++ )
			{
				$res_text .= "<li>";
					$res_text .= '<a href="products.php?selectedCategory='.$res[$i]['tbl_param_category_id'].'" >'.$res[$i]['tbl_param_category_name_name'].'</a>';	
                
                
				$res_text .= $this->getCategorySubCategoriesLinks_products($res[$i]['tbl_param_category_id'],$lang_id);
				
				$res_text .= "</li>";    
			}
			
			$res_text .= "</ul>";
			
		endif;
		
		return $res_text;
		
	}
	
	
	/*
	* @getSomeDescLang($id,$table,$desciptionFiled,$idField,$lang_field_id,$lang_id)
	*
	* Βρίσκει την περιγραφή ($desciptionFiled) 
	* από μία εγγραφή ενός πίνακα ($table) με βάση
	* το ID (πεδίο : $idField) (τιμή : $id) 
	*/
	public function getSomeDescLang($id,$table,$desciptionFiled,$idField,$lang_field_id,$lang_id)
	{
		if( isset($id) )
		{
			$sql = "SELECT $desciptionFiled
					FROM $table N
					
					WHERE $idField = '".$id."'
					
					AND $lang_field_id = '".$lang_id."'
					";
			$res = mysql_query($sql);		
			if( isset($res) )
			{
				$row = @mysql_fetch_array($res);
				return $row[$desciptionFiled];
			}
			else
				return "";	
		}
		else
			return "";
				
	}

}

?>