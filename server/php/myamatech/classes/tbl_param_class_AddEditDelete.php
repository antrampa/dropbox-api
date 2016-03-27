<?php
include("tbl_param_class_connect.php");
include("my_new_functions.php");


/*
 * TtblParamAddEditDelete
 *
 * @version 1.6.7
 * @Last Update 13-12-2008
 *
 * Το αντικείμενο TtblParamAddEditDelete κληρονομεί χαρακτηριστικά από την TConnect. 
 * Πραγματοποιεί INSERT, UPDATE και DELETE δεδομένων στην βάση και στους πίνακες
 * που δίνεται από τον χρήστη. 
 * Κάνει την σύνδεση με την βάση καλώντας την setValue και την connectToDatabase 
 * από την κλάση TConnect.
 *
 *	Συναρτήσεις μέλη:
 *	getTableFields($tbl_name) : << δέχεται σαν όρισμα το όνομα του πίνακα
 *                            : >> επιστρέφει σε μορφή πίνακα (array) τα ονόματα των πεδιών του πίνακα   			
 *
 *  updateRows($tbl_name,$whereField,$whereValue,$values,$fields) : << δέχεται ορίσματα το όνομα του πίνακα της βάσης, το όνομα του πεδίου για το κρητήριο του WHERE,
 *																  :    την τιμή του κρητηρίου WHERE, τις τιμές των πεδιών που θα επεξεργαστούν 
 *																  :    και τα πεδία που θα επεξεργαστούν
 *																  : >> πραγματοποιεί την εντολή UPDATE της MySQL με το κρητήριο που δόθηκε από τον χρήστη.						 						
 *
 *  insertRows($tbl_name,$values,$fields)                         : << δέχεται ορίσματα το όνομα του πίνακα της βάσης, 
 *																  :	   τις τιμές των πεδιών που θα επεξεργαστούν 
 *																  :    και τα πεδία που θα επεξεργαστούν
 *																  : >> πραγματοποιεί την εντολή INSERT της MySQL με τα πεδία και δεδομένα που δόθηκε από τον χρήστη.
 *
 *  deleteRows($tbl_name,$whereField,$whereValue)                 : << δέχεται ορίσματα το όνομα του πίνακα της βάσης, 
 *																  :	   το πεδιο για το κρητήριο της WHERE 
 *																  :    και την τιμή του πεδίου για το κρητήριο WHERE
 *																  : >> πραγματοποιεί την εντολή DELETE της MySQL με το κρητήριο που δόθηκε από τον χρήστη.
 *
 * @link 
 * @author  Αντώνης - Αντρανίκ Αμπαρτσουμιάν
 * @package tbl_param_frorm ( Parametric Forms for tpp and address book )
 * @version 1.0
 * @Created Thursday, July 24, 2008

*/

class TtblParamAddEditDelete extends TConnect 
{
	var $tempVar;
	
	var $bgColor;
	var $IDCOUNTER;
	
	/*
	*	Δήλωση του αντικειμ΄ςνου χωρίς ορίσματα
	*/
	public function  TtblParamAddEditDelete()
	{
		$this->tempVar = "Hello World!";
	}
	
	public function GetValue()
	{
		return $this->tempVar;
	}
	
	
	/*
	* @getTableFields($tbl_name)
	*
	* H συνάρτηση επιστέρφει σε μορφή πίνακα (array) τα πεδία 
	* του πίνακα $tbl_name.
	* $tbl_name    : το όνομα του πίνακα που δίνεται,
	*/
	public function getTableFields($tbl_name)
	{
		$fields_sql = "SELECT * FROM $tbl_name";//"SHOW fields $tbl_name";
		$fields_result = mysql_query($fields_sql,$this->conn_id);
		$fields_num = mysql_num_fields($fields_result);
		for( $f = 0; $f<$fields_num; $f++ )
		{
			$fields_name[$f] = mysql_field_name($fields_result, $f);
			$fields_type[$f] = mysql_field_type($fields_result, $f);
		}
		return $fields_name; 
		
	}
	
	/*
	* @updateRows($tbl_name,$whereField,$whereValue,$values,$fields)
	*
	* H συνάρτηση πραγματοποιεί update του πίνακα του θα δωθεί.
	* $tbl_name    : το όνομα του πίνακα που δίνεται,
	* $whererField : το πεδίο του πίνακα που θα καθορίσει την συνθήκη του WHERE
	* $WhereValue  : η τιμή του πεδίου της συνθήκης WHERE
	* $values      : (array) είναι οι τιμές του πίνακα
	* $fields      : τα πεδία του πίνακα που θα ενημερωθούν
	*/
	public function updateRows($tbl_name,$whereField,$whereValue,$values,$fields)
	{
		$UpdateData = "";
		//$fields = getTableFields($tbl_name);
		
		for($i=1;$i<count($fields);$i++)
		{
			if( $i == (count($fields) - 1) ) 	//Τελευταία εγγραφή
				$koma = " ";				 	//άρα δεν θέλει κόμα ","			
			else
				$koma = ",";	
				
			$UpdateData .= $fields[$i]. " = '" . $values[$i] . "'".$koma;
		}
	
		$sql = "UPDATE $tbl_name
				SET
				".$UpdateData."
				WHERE $whereField = $whereValue";
		//echo $sql; 		
		$res = mysql_query($sql,$this->conn_id);
		if( $res )
			return $res;
		else
			return mysql_error();	
				
	}
	
	
	/*
	* @insertRows($tbl_name,$whereField,$whereValue,$values,$fields)
	*
	* H συνάρτηση πραγματοποιεί INSERT του πίνακα που θα δωθεί.
	* $tbl_name    : το όνομα του πίνακα που δίνεται,
	* $values      : (array) είναι οι τιμές του πίνακα
	* $fields      : τα πεδία του πίνακα που θα ενημερωθούν
	*/
	public function insertRows($tbl_name,$values,$fields)
	{
		$InsertData = "";
		$InsertFields = "";
		//$fields = getTableFields($tbl_name);
		
		for($i=1;$i<count($fields);$i++)
		{
			if( $i == (count($fields) - 1) ) 	//Τελευταία εγγραφή
				$koma = " ";				 	//άρα δεν θέλει κόμα ","			
			else
				$koma = ",";	
				
			$InsertFields .= $fields[$i]. " " . $koma;		    //Εισαγωγή των πεδίωνν	
			$InsertData   .= "'" . $values[$i] . "'".$koma;		//Εισαγωγή των δεδομένων
			
		}
	
		$sql = "INSERT INTO $tbl_name
				(". $InsertFields .")
				VALUES
				(". $InsertData .")
				";
		//echo "$sql<br>";		
		$res = mysql_query($sql,$this->conn_id);
		if( $res )
			return $res;
		else
			return mysql_error();	
				
	}
	
			
	
	/*
	* @deleteRows($tbl_name,$whereField,$whereValue,$values,$fields)
	*
	* H συνάρτηση πραγματοποιεί DELETE των εγγραφών του πίνακα που θα δωθεί.
	* $tbl_name    : το όνομα του πίνακα που δίνεται,
	* $whererField : το πεδίο του πίνακα που θα καθορίσει την συνθήκη του WHERE
	* $WhereValue  : η τιμή του πεδίου της συνθήκης WHERE
	*/
	public function deleteRows($tbl_name,$whereField,$whereValue)
	{
		$sql = "DELETE FROM $tbl_name
				WHERE $whereField = '" . $whereValue . "'";
		$res = mysql_query($sql,$this->conn_id);		
		
		if( $res )
			return $res;
		else
			return mysql_error();	
	}
	
	/*
	* @excQuery($sql)
	*
	* Εκτέλεση sql ερωτημάτων
	*/
	public function excQuery($sql)
	{
		$res = mysql_query($sql);		
		
		if( $res )
		{
			$i = 0;
			$j = 0;
			$array = array();
			while( $row = mysql_fetch_array($res) )
			{
				$array[$i] = $row;
				$i++;
			}	
		
			return $array;
		}
		else
		{	
			$error = die( mysql_error() );
			return $error;	
		}
			
	}
	
	/*
	* @excQueryInsUp($sql)
	*
	* Εκτέλεση sql ερωτημάτων
	*/
	public function excQueryInsUp($sql)
	{
		$res = mysql_query($sql,$this->conn_id);		
		
		if( $res )
		{
			return $res;
		}
		else
			return mysql_error();	
	}
	
	
	/*
	* @excQuery($sql)
	*
	* Δημιουργία options για select input
	*/
	public function createOptions($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc)
	{
		$sql = "SELECT $fieldsID,$fieldsText
				FROM $table ";
		if( strlen($where) > 0 )		
			$sql .= " WHERE ".$where . " " ;
		$sql .= " ORDER BY $orderBy $descAsc";	
		
		$res = mysql_query($sql);
		
		if( $res )
		{
			while( $row = mysql_fetch_array($res) )
			{
				if( $row[$fieldsID] == $SelectedID  )
					$selected = "selected";
				else
					$selected = "";	
				$option .= "<option value=\"".$row[$fieldsID]."\" $selected>".$row[$fieldsText]."</option>";	
			}
			
			return $option;
		}
		else
			return mysql_error();
		
	}
	
	
	/*
	* @createOptionsWithSecTable($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$secTableName,$secTblFirstConnector)
	*
	* Δημιουργία options για select input
	*/
	public function createOptionsWithSecTable($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$secTableName,$secTblFirstConnector)
	{
		$sql = "SELECT $fieldsID,$fieldsText
				FROM $table FT 
				JOIN $secTableName ST ON FT.".$fieldsID." = ST.".$secTblFirstConnector."
				";
		if( strlen($where) > 0 )		
			$sql .= " WHERE ".$where . " " ;
		$sql .= " ORDER BY $orderBy $descAsc";	
		
		$res = mysql_query($sql);
		
		if( $res )
		{
			while( $row = mysql_fetch_array($res) )
			{
				if( $row[$fieldsID] == $SelectedID  )
					$selected = "selected";
				else
					$selected = "";	
				$option .= "<option value=\"".$row[$fieldsID]."\" $selected>".$row[$fieldsText]."</option>";	
			}
			
			return $option;
		}
		else
			return mysql_error();
		
	}
	
	
	/*
	* @excQuery($sql)
	*
	* Δημιουργία options για select input
	*/
	public function createOptgroups($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc)
	{
		global $bssb;
		
		$sql = "SELECT $fieldsID,$fieldsText
				FROM $table  TB
				JOIN tbl_param_category_name L ON TB.$fieldsID = L.tbl_param_category_name_category_id
				";
		if( strlen($where) > 0 )		
			$sql .= " WHERE ".$where . " AND tbl_param_category_category_id = '0' " ;
		$sql .= " ORDER BY $orderBy $descAsc";	
		
		$res = mysql_query($sql);
		
		if( $res )
		{
			while( $row = mysql_fetch_array($res) )
			{
				if( $row[$fieldsID] == $SelectedID  )
					$selected = "selected";
				else
					$selected = "";	
				$option .= "<option value=\"".$row[$fieldsID]."\" $selected>".$row[$fieldsText]."</option>";	
				
				//Get Sub Categories
				$bssb = "";
				$option .= $this->createSubOptions($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$row[$fieldsID],"&nbsp;&nbsp;");
				$bssb = "";
			}
			
			return $option;
		}
		else
			return mysql_error();
		
	}
	
	/*
	* @createSubOptions($sql)
	*
	* Δημιουργία options για select input
	*/
	public function createSubOptions($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$montherCategoryID,$bssb2)
	{
		global $bssb;
		$bssb .= "&nbsp;&nbsp;";
		//$bssb2 .= "&nbsp;&nbsp;";
		
		$sql = "SELECT $fieldsID,$fieldsText
				FROM $table  TB
				JOIN tbl_param_category_name L ON TB.$fieldsID = L.tbl_param_category_name_category_id
				";
		$sql .= " WHERE tbl_param_category_category_id = '".$montherCategoryID."' ";
		
		if( strlen($where) > 0 )		
			$sql .= " AND ".$where . " " ;
		$sql .= " ORDER BY $orderBy $descAsc";	
		
		$res = mysql_query($sql);
		
		if( $res )
		{
				while( $row = mysql_fetch_array($res) )
				{
					if( $row[$fieldsID] == $SelectedID  )
						$selected = "selected";
					else
						$selected = "";	
					$option .= "<option value=\"".$row[$fieldsID]."\" $selected> $bssb2 ".$row[$fieldsText]."</option>";	
				
					$option .= $this->createSubOptions($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$row[$fieldsID],"".$bssb2."&nbsp;&nbsp;");
				}
				return $option;
		}
		else
			return mysql_error();
		
	}
	
	/*
	* @excQuery($sql)
	*
	* Δημιουργία options για select input
	*/
	public function createOptgroupsShope($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc)
	{
		global $bssb;
		
		$sql = "SELECT $fieldsID,$fieldsText
				FROM $table  TB
				JOIN tbl_param_shopcategory_name L ON TB.$fieldsID = L.tbl_param_shopcategory_name_cat_id
				";
		if( strlen($where) > 0 )		
			$sql .= " WHERE ".$where . " AND tbl_param_shopcategory_cat_id = '0' " ;
		$sql .= " ORDER BY $orderBy $descAsc";	
		
		$res = mysql_query($sql);
		
		if( $res )
		{
			while( $row = mysql_fetch_array($res) )
			{
				if( $row[$fieldsID] == $SelectedID  )
					$selected = "selected";
				else
					$selected = "";	
				$option .= "<option value=\"".$row[$fieldsID]."\" $selected>".$row[$fieldsText]."</option>";	
				
				//Get Sub Categories
				$bssb = "";
				$option .= $this->createSubOptionsShopes($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$row[$fieldsID],"&nbsp;&nbsp;");
				$bssb = "";
			}
			
			return $option;
		}
		else
			return mysql_error();
		
	}
	
	
	/*
	* @createSubOptions($sql)
	*
	* Δημιουργία options για select input
	*/
	public function createSubOptionsShopes($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$montherCategoryID,$bssb2)
	{
		global $bssb;
		$bssb .= "&nbsp;&nbsp;";
		//$bssb2 .= "&nbsp;&nbsp;";
		
		$sql = "SELECT $fieldsID,$fieldsText
				FROM $table  TB
				JOIN tbl_param_shopcategory_name L ON TB.$fieldsID = L.tbl_param_shopcategory_name_cat_id
				";
		$sql .= " WHERE tbl_param_shopcategory_cat_id = '".$montherCategoryID."' ";
		
		if( strlen($where) > 0 )		
			$sql .= " AND ".$where . " " ;
		$sql .= " ORDER BY $orderBy $descAsc";	
		
		$res = mysql_query($sql);
		
		if( $res )
		{
				while( $row = mysql_fetch_array($res) )
				{
					if( $row[$fieldsID] == $SelectedID  )
						$selected = "selected";
					else
						$selected = "";	
					$option .= "<option value=\"".$row[$fieldsID]."\" $selected> $bssb2 ".$row[$fieldsText]."</option>";	
				
					$option .= $this->createSubOptionsShopes($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$row[$fieldsID],"".$bssb2."&nbsp;&nbsp;");
				}
				return $option;
		}
		else
			return mysql_error();
		
	}
	
	/*
	* @createOptionsGroupBy($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$groupBy)
	*
	* Δημιουργία options για select input
	*/
	public function createOptionsGroupBy($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$groupBy)
	{
		$sql = "SELECT $fieldsID,$fieldsText
				FROM $table ";
		if( strlen($where) > 0 )		
			$sql .= " WHERE ".$where . " " ;
		$sql .= " GROUP BY ".$groupBy. " " ;
		$sql .= " ORDER BY $orderBy $descAsc";	
		
		$res = mysql_query($sql);
		
		if( $res )
		{
			while( $row = mysql_fetch_array($res) )
			{
				if( $row[$fieldsID] == $SelectedID  )
					$selected = "selected";
				else
					$selected = "";	
				$option .= "<option value=\"".$row[$fieldsID]."\" $selected>".$row[$fieldsText]."</option>";	
			}
			
			return $option;
		}
		else
			return mysql_error();
		
	}
	
	
	/*
	* @createOptionsGroupByTag($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$groupBy,$tag)
	*
	* Δημιουργία options για select input
	*/
	public function createOptionsGroupByTag($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$groupBy,$tag)
	{
		$sql = "SELECT $fieldsID,$fieldsText,$tag
				FROM $table ";
		if( strlen($where) > 0 )		
			$sql .= " WHERE ".$where . " " ;
		$sql .= " GROUP BY ".$groupBy. " " ;
		$sql .= " ORDER BY $orderBy $descAsc";	
		
		$res = mysql_query($sql);
		
		if( $res )
		{
			while( $row = mysql_fetch_array($res) )
			{
				if( $row[$fieldsID] == $SelectedID  )
					$selected = "selected";
				else
					$selected = "";	
				$option .= "<option value=\"".$row[$fieldsID]."\" $selected>".$row[$fieldsText]." | ".$row[$tag]."</option>";	
			}
			
			return $option;
		}
		else
			return mysql_error();
		
	}
	
	
	/*
	* @createOptionsGroupByTagCashReceivablesWeeks($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$groupBy,$tag)
	*
	* Δημιουργία options για select input
	*/
	public function createOptionsGroupByTagCashReceivablesWeeks($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$groupBy,$tag)
	{
		$sql = "SELECT $fieldsID,$fieldsText,$tag,tbl_fin_calendar_week,tbl_fin_calendar_year
				FROM $table ";
		if( strlen($where) > 0 )		
			$sql .= " WHERE ".$where . " " ;
		$sql .= " GROUP BY ".$groupBy. " " ;
		$sql .= " ORDER BY $orderBy $descAsc";	
		
		$res = mysql_query($sql);
		
		if( $res )
		{
			$color1 = "";
			$color2 = "#e0e0e0";
			$bgcolor = $color1;
			while( $row = mysql_fetch_array($res) )
			{
				if( $bgcolor == $color2 )
					$bgcolor = $color1;
				else
					$bgcolor = $color2;	
				
				if( $row[$fieldsID] == $SelectedID  )
					$selected = "selected";
				else
					$selected = "";	
				
				//Receivable
				//Get caxac aprakner@
				$sql = "SELECT sum(tbl_fin_receivables_orders_link_amount) AS sumAmount
						FROM glass_apps_all.tbl_fin_receivables_orders_link OL
						LEFT JOIN glass_apps_all.tbl_fin_calendar C ON OL.tbl_fin_receivables_orders_link_calendar_id = C.tbl_fin_calendar_id
						WHERE C.tbl_fin_calendar_week = '".$row['tbl_fin_calendar_week']."'
						AND C.tbl_fin_calendar_year = '".$row['tbl_fin_calendar_year']."'
						AND tbl_fin_receivables_orders_link_paid = 'No'
						";	
				$res_amount = $this->excQuery($sql);
				$amount = $res_amount[0]['sumAmount'];
				
				//Get caxac aprakner@
				$sql = "SELECT sum(tbl_fin_receivables_projectlist_link_amount) AS sumAmount
						FROM glass_apps_all.tbl_fin_receivables_projectlist_link OL
						LEFT JOIN glass_apps_all.tbl_fin_calendar C ON OL.tbl_fin_receivables_projectlist_link_calendar_id = C.tbl_fin_calendar_id
						WHERE C.tbl_fin_calendar_week = '".$row['tbl_fin_calendar_week']."'
						AND C.tbl_fin_calendar_year = '".$row['tbl_fin_calendar_year']."'
						AND tbl_fin_receivables_projectlist_link_paid = 'Yes'
						";	
				$res_amount = $this->excQuery($sql);
				$amount += $res_amount[0]['sumAmount'];	
				
				//Get caxac aprakner@
				$sql = "SELECT sum(tbl_fin_receivables_replnmnts_link_amount) AS sumAmount
						FROM glass_apps_all.tbl_fin_receivables_replnmnts_link OL
						LEFT JOIN glass_apps_all.tbl_fin_calendar C ON OL.tbl_fin_receivables_replnmnts_link_calendar_id = C.tbl_fin_calendar_id
						WHERE C.tbl_fin_calendar_week = '".$row['tbl_fin_calendar_week']."'
						AND C.tbl_fin_calendar_year = '".$row['tbl_fin_calendar_year']."'
						AND tbl_fin_receivables_replnmnts_link_paid = 'Yes'
						";	
				$res_amount = $this->excQuery($sql);
				$amount += $res_amount[0]['sumAmount'];	
				
				//Get caxac aprakner@
				$sql = "SELECT sum(tbl_fin_receivables_underdisc_link_amount) AS sumAmount
						FROM glass_apps_all.tbl_fin_receivables_underdisc_link OL
						LEFT JOIN glass_apps_all.tbl_fin_calendar C ON OL.tbl_fin_receivables_underdisc_link_calendar_id = C.tbl_fin_calendar_id
						WHERE C.tbl_fin_calendar_week = '".$row['tbl_fin_calendar_week']."'
						AND C.tbl_fin_calendar_year = '".$row['tbl_fin_calendar_year']."'
						AND tbl_fin_receivables_underdisc_link_paid = 'Yes'
						";	
				$res_amount = $this->excQuery($sql);
				$amount += $res_amount[0]['sumAmount'];	
				
				//Payable
				//Get caxac aprakner@
				$sql = "SELECT sum(tbl_fin_paymentexp_link_amount) AS sumAmount
						FROM glass_apps_all.tbl_fin_paymentexp_link OL
						LEFT JOIN glass_apps_all.tbl_fin_calendar C ON OL.tbl_fin_paymentexp_link_calendar_id = C.tbl_fin_calendar_id
						WHERE C.tbl_fin_calendar_week = '".$row['tbl_fin_calendar_week']."'
						AND C.tbl_fin_calendar_year = '".$row['tbl_fin_calendar_year']."'
						AND ( tbl_fin_paymentexp_link_paid = 'No'
							  OR 
							  tbl_fin_paymentexp_link_paid = 'Cheque'
							)
						";	
				$res_amount = $this->excQuery($sql);
				$amount -= $res_amount[0]['sumAmount'];	
				
				//Get caxac aprakner@
				$sql = "SELECT sum(tbl_fin_payment_loansinst_link_amount) AS sumAmount
						FROM glass_apps_all.tbl_fin_payment_loansinst_link OL
						LEFT JOIN glass_apps_all.tbl_fin_calendar C ON OL.tbl_fin_payment_loansinst_link_calendar_id = C.tbl_fin_calendar_id
						WHERE C.tbl_fin_calendar_week = '".$row['tbl_fin_calendar_week']."'
						AND C.tbl_fin_calendar_year = '".$row['tbl_fin_calendar_year']."'
						AND tbl_fin_payment_loansinst_link_paid = 'No'
						";	
				$res_amount = $this->excQuery($sql);
				$amount -= $res_amount[0]['sumAmount'];	
				
				//Get caxac aprakner@
				$sql = "SELECT sum(tbl_fin_payment_otherexpbuget_link_amount) AS sumAmount
						FROM glass_apps_all.tbl_fin_payment_otherexpbuget_link OL
						LEFT JOIN glass_apps_all.tbl_fin_calendar C ON OL.tbl_fin_payment_otherexpbuget_link_calendar_id = C.tbl_fin_calendar_id
						WHERE C.tbl_fin_calendar_week = '".$row['tbl_fin_calendar_week']."'
						AND C.tbl_fin_calendar_year = '".$row['tbl_fin_calendar_year']."'
						AND tbl_fin_payment_otherexpbuget_link_paid = 'Yes'
						";	
				$res_amount = $this->excQuery($sql);
				$amount -= $res_amount[0]['sumAmount'];
				
				//Get caxac aprakner@
				$sql = "SELECT sum(tbl_fin_payment_cheque_link_amount) AS sumAmount
						FROM glass_apps_all.tbl_fin_payment_cheque_link CH
						LEFT JOIN glass_apps_all.tbl_fin_calendar C ON CH.tbl_fin_payment_cheque_link_calendar_id = C.tbl_fin_calendar_id
						WHERE C.tbl_fin_calendar_week = '".$row['tbl_fin_calendar_week']."'
						AND C.tbl_fin_calendar_year = '".$row['tbl_fin_calendar_year']."'
						AND tbl_fin_payment_cheque_link_paid = 'No'
						";	
				$res_amount = $this->excQuery($sql);
				$amount -= $res_amount[0]['sumAmount'];
				
				
				if( $amount < 0 )
					$bgcolor = "#FFCECE;";
					
				$option .= "<option value=\"".$row[$fieldsID]."\" style=\"background-color:".$bgcolor."\" $selected>".$row[$fieldsText]." | ".$row[$tag]." | ".number_format($amount,0,'.',',')."&euro;</option>";	
			}
			
			return $option;
		}
		else
			return mysql_error();
		
	} 
	
	/*
	* @createOptionsGroupByTagCashPaymentsWeeks($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$groupBy,$tag)
	*
	* Δημιουργία options για select input
	*/
	public function createOptionsGroupByTagCashPaymentsWeeks($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$groupBy,$tag)
	{
		$sql = "SELECT $fieldsID,$fieldsText,$tag,tbl_fin_calendar_week,tbl_fin_calendar_year
				FROM $table ";
		if( strlen($where) > 0 )		
			$sql .= " WHERE ".$where . " " ;
		$sql .= " GROUP BY ".$groupBy. " " ;
		$sql .= " ORDER BY $orderBy $descAsc ";	
		
		$res = mysql_query($sql);
		
		if( $res )
		{
			$color1 = "";
			$color2 = "#e0e0e0";
			$bgcolor = $color1;
			while( $row = mysql_fetch_array($res) )
			{
				if( $bgcolor == $color2 )
					$bgcolor = $color1;
				else
					$bgcolor = $color2;	
					
				if( $row[$fieldsID] == $SelectedID  )
					$selected = "selected";
				else
					$selected = "";	
				
				//Receivable
				//Get caxac aprakner@
				$sql = "SELECT sum(tbl_fin_receivables_orders_link_amount) AS sumAmount
						FROM glass_apps_all.tbl_fin_receivables_orders_link OL
						LEFT JOIN glass_apps_all.tbl_fin_calendar C ON OL.tbl_fin_receivables_orders_link_calendar_id = C.tbl_fin_calendar_id
						WHERE C.tbl_fin_calendar_week = '".$row['tbl_fin_calendar_week']."'
						AND C.tbl_fin_calendar_year = '".$row['tbl_fin_calendar_year']."'
						AND tbl_fin_receivables_orders_link_paid = 'No'
						";	
				$res_amount = $this->excQuery($sql);
				$amount = $res_amount[0]['sumAmount'];
				
				//Get caxac aprakner@
				$sql = "SELECT sum(tbl_fin_receivables_projectlist_link_amount) AS sumAmount
						FROM glass_apps_all.tbl_fin_receivables_projectlist_link OL
						LEFT JOIN glass_apps_all.tbl_fin_calendar C ON OL.tbl_fin_receivables_projectlist_link_calendar_id = C.tbl_fin_calendar_id
						WHERE C.tbl_fin_calendar_week = '".$row['tbl_fin_calendar_week']."'
						AND C.tbl_fin_calendar_year = '".$row['tbl_fin_calendar_year']."'
						AND tbl_fin_receivables_projectlist_link_paid = 'Yes'
						";	
				$res_amount = $this->excQuery($sql);
				$amount += $res_amount[0]['sumAmount'];	
				
				//Get caxac aprakner@
				$sql = "SELECT sum(tbl_fin_receivables_replnmnts_link_amount) AS sumAmount
						FROM glass_apps_all.tbl_fin_receivables_replnmnts_link OL
						LEFT JOIN glass_apps_all.tbl_fin_calendar C ON OL.tbl_fin_receivables_replnmnts_link_calendar_id = C.tbl_fin_calendar_id
						WHERE C.tbl_fin_calendar_week = '".$row['tbl_fin_calendar_week']."'
						AND C.tbl_fin_calendar_year = '".$row['tbl_fin_calendar_year']."'
						AND tbl_fin_receivables_replnmnts_link_paid = 'Yes'
						";	
				$res_amount = $this->excQuery($sql);
				$amount += $res_amount[0]['sumAmount'];	
				
				//Get caxac aprakner@
				$sql = "SELECT sum(tbl_fin_receivables_underdisc_link_amount) AS sumAmount
						FROM glass_apps_all.tbl_fin_receivables_underdisc_link OL
						LEFT JOIN glass_apps_all.tbl_fin_calendar C ON OL.tbl_fin_receivables_underdisc_link_calendar_id = C.tbl_fin_calendar_id
						WHERE C.tbl_fin_calendar_week = '".$row['tbl_fin_calendar_week']."'
						AND C.tbl_fin_calendar_year = '".$row['tbl_fin_calendar_year']."'
						AND tbl_fin_receivables_underdisc_link_paid = 'Yes'
						";	
				$res_amount = $this->excQuery($sql);
				$amount += $res_amount[0]['sumAmount'];	
				
				//Payable
				//Get caxac aprakner@
				$sql = "SELECT sum(tbl_fin_paymentexp_link_amount) AS sumAmount
						FROM glass_apps_all.tbl_fin_paymentexp_link OL
						LEFT JOIN glass_apps_all.tbl_fin_calendar C ON OL.tbl_fin_paymentexp_link_calendar_id = C.tbl_fin_calendar_id
						WHERE C.tbl_fin_calendar_week = '".$row['tbl_fin_calendar_week']."'
						AND C.tbl_fin_calendar_year = '".$row['tbl_fin_calendar_year']."'
						AND ( tbl_fin_paymentexp_link_paid = 'No' 
							 OR
							 tbl_fin_paymentexp_link_paid = 'Cheque' 
							 )
						";	
				$res_amount = $this->excQuery($sql);
				$amount -= $res_amount[0]['sumAmount'];	
				
				//Get caxac aprakner@
				$sql = "SELECT sum(tbl_fin_payment_loansinst_link_amount) AS sumAmount
						FROM glass_apps_all.tbl_fin_payment_loansinst_link OL
						LEFT JOIN glass_apps_all.tbl_fin_calendar C ON OL.tbl_fin_payment_loansinst_link_calendar_id = C.tbl_fin_calendar_id
						WHERE C.tbl_fin_calendar_week = '".$row['tbl_fin_calendar_week']."'
						AND C.tbl_fin_calendar_year = '".$row['tbl_fin_calendar_year']."'
						AND tbl_fin_payment_loansinst_link_paid = 'No'
						";	
				$res_amount = $this->excQuery($sql);
				$amount -= $res_amount[0]['sumAmount'];	
				
				//Get caxac aprakner@
				$sql = "SELECT sum(tbl_fin_payment_otherexpbuget_link_amount) AS sumAmount
						FROM glass_apps_all.tbl_fin_payment_otherexpbuget_link OL
						LEFT JOIN glass_apps_all.tbl_fin_calendar C ON OL.tbl_fin_payment_otherexpbuget_link_calendar_id = C.tbl_fin_calendar_id
						WHERE C.tbl_fin_calendar_week = '".$row['tbl_fin_calendar_week']."'
						AND C.tbl_fin_calendar_year = '".$row['tbl_fin_calendar_year']."'
						AND tbl_fin_payment_otherexpbuget_link_paid = 'Yes'
						";	
				$res_amount = $this->excQuery($sql);
				$amount -= $res_amount[0]['sumAmount'];
				
				//Get caxac aprakner@
				$sql = "SELECT sum(tbl_fin_payment_cheque_link_amount) AS sumAmount
						FROM glass_apps_all.tbl_fin_payment_cheque_link CH
						LEFT JOIN glass_apps_all.tbl_fin_calendar C ON CH.tbl_fin_payment_cheque_link_calendar_id = C.tbl_fin_calendar_id
						WHERE C.tbl_fin_calendar_week = '".$row['tbl_fin_calendar_week']."'
						AND C.tbl_fin_calendar_year = '".$row['tbl_fin_calendar_year']."'
						AND tbl_fin_payment_cheque_link_paid = 'No'
						";	
				$res_amount = $this->excQuery($sql);
				$amount -= $res_amount[0]['sumAmount'];	
				
				if( $amount < 0 )
					$bgcolor = "#FFCECE; ";
					
				$option .= "<option value=\"".$row[$fieldsID]."\" style=\"background-color:".$bgcolor."\" $selected>".$row[$fieldsText]." | ".$row[$tag]." | ".number_format($amount,0,'.',',')."&euro;</option>";	
			}
			
			return $option;
		}
		else
			return mysql_error();
		
	}
	
	
	
	/*
	* @createOptionsMultiSelect($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc)
	*
	* Δημιουργία options για select input
	*/
	public function createOptionsMultiSelect($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc)
	{
		$sql = "SELECT $fieldsID,$fieldsText
				FROM $table ";
		if( strlen($where) > 0 )		
			$sql .= " WHERE ".$where . " " ;
		$sql .= " ORDER BY $orderBy $descAsc";	
		
		$res = mysql_query($sql);
		
		if( $res )
		{
			while( $row = mysql_fetch_array($res) )
			{
				$selected = "";	
				for($i=0;$i<count($SelectedID);$i++)
				{
					if( $row[$fieldsID] == $SelectedID[$i]  ){
						$selected = "selected";
						break;
					}
				}
				$option .= "<option title=\"".$row[$fieldsText]."\" value=\"".$row[$fieldsID]."\" $selected>".$row[$fieldsText]."</option>";	
			}
			
			return $option;
		}
		else
			return mysql_error();
		
	}
	
	/*
	* @createOptionsMultiSelectGroupBy($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc)
	*
	* Δημιουργία options για select input
	*/
	public function createOptionsMultiSelectGroupBy($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$groupBy)
	{
		$sql = "SELECT $fieldsID,$fieldsText
				FROM $table ";
		if( strlen($where) > 0 )		
			$sql .= " WHERE ".$where . " " ;
		
		$sql .= " GROUP BY $groupBy	";	
		$sql .= " ORDER BY $orderBy $descAsc";	
		
		$res = mysql_query($sql);
		
		if( $res )
		{
			while( $row = mysql_fetch_array($res) )
			{
				$selected = "";	
				for($i=0;$i<count($SelectedID);$i++)
				{
					if( $row[$fieldsID] == $SelectedID[$i]  ){
						$selected = "selected";
						break;
					}
				}
				$option .= "<option value=\"".$row[$fieldsID]."\" $selected>".$row[$fieldsText]."</option>";	
			}
			
			return $option;
		}
		else
			return mysql_error();
		
	}
	
	/*
	* @createOptionsLimit($sql)
	*
	* Δημιουργία options για select input
	*/
	public function createOptionsLimit($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$limit)
	{
		$sql = "SELECT $fieldsID,$fieldsText
				FROM $table ";
		if( strlen($where) > 0 )		
			$sql .= " WHERE ".$where . " " ;
		$sql .= " ORDER BY $orderBy $descAsc";	
		
		if( strlen($limit)>0 )
			$sql .= " LIMIT ".$limit." " ;
		
		$res = mysql_query($sql,$this->conn_id);
		
		if( $res )
		{
			while( $row = mysql_fetch_array($res) )
			{
				if( $row[$fieldsID] == $SelectedID  )
					$selected = "selected";
				else
					$selected = "";	
				$option .= "<option value=\"".$row[$fieldsID]."\" $selected>".$row[$fieldsText]."</option>";	
			}
			
			return $option;
		}
		else
			return mysql_error();
		
	}
	
	
	
	/*
	* @createOptionsWithTag($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$tagField)
	*
	* Δημιουργία options για select input
	*/
	public function createOptionsWithTag($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$tagField)
	{
		$sql = "SELECT $fieldsID,$fieldsText,$tagField
				FROM $table ";
		if( strlen($where) > 0 )		
			$sql .= " WHERE ".$where . " " ;
		$sql .= " ORDER BY $orderBy $descAsc ";	
		
		$res = mysql_query($sql,$this->conn_id);
		
		if( $res )
		{
			while( $row = mysql_fetch_array($res) )
			{
				if( $row[$fieldsID] == $SelectedID  )
					$selected = "selected";
				else
					$selected = "";	
				$option .= "<option value=\"".$row[$fieldsID]."\" $selected>".$row[$fieldsText]." | ".$row[$tagField]."</option>";	
			}
			
			return $option;
		}
		else
			return mysql_error();
		
	}
	
	/*
	* @createOptionsWithTag($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$tagField)
	*
	* Δημιουργία options για select input
	*/
	public function createOptionsWithTagRowColor($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$tagField,$color1,$color2)
	{
		$sql = "SELECT $fieldsID,$fieldsText,$tagField
				FROM $table ";
		if( strlen($where) > 0 )		
			$sql .= " WHERE ".$where . " " ;
		$sql .= " ORDER BY $orderBy $descAsc ";	
		
		$res = mysql_query($sql,$this->conn_id);
		
		if( $res )
		{
			$bgcolor = $color1;
			while( $row = mysql_fetch_array($res) )
			{
				if( $bgcolor == $color2 )
					$bgcolor = $color1;
				else
					$bgcolor = $color2;	
				
				if( $row[$fieldsID] == $SelectedID  )
					$selected = "selected";
				else
					$selected = "";	
				$option .= "<option value=\"".$row[$fieldsID]."\" $selected style=\"background-color:".$bgcolor."\"><b>".$row[$fieldsText]."</b> | ".$row[$tagField]."</option>";	
			}
			
			return $option;
		}
		else
			return mysql_error();
		
	}
	
	/*
	* @createOptionsWithTwoTagRowColor($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$tagField,$tagField2,$color1,$color2)
	*
	* Δημιουργία options για select input
	*/
	public function createOptionsWithTwoTagRowColor($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$tagField,$tagField2,$color1,$color2)
	{
		$sql = "SELECT $fieldsID,$fieldsText,$tagField,$tagField2
				FROM $table ";
		if( strlen($where) > 0 )		
			$sql .= " WHERE ".$where . " " ;
		$sql .= " ORDER BY $orderBy $descAsc ";	
		
		$res = mysql_query($sql,$this->conn_id);
		
		if( $res )
		{
			$bgcolor = $color1;
			while( $row = mysql_fetch_array($res) )
			{
				if( $bgcolor == $color2 )
					$bgcolor = $color1;
				else
					$bgcolor = $color2;	
				
				if( $row[$fieldsID] == $SelectedID  )
					$selected = "selected";
				else
					$selected = "";	
				$option .= "<option value=\"".$row[$fieldsID]."\" $selected style=\"background-color:".$bgcolor."\"><b>".$row[$fieldsText]."</b> | ".$row[$tagField]." | ".$row[$tagField2]."</option>";	
			}
			
			return $option;
		}
		else
			return mysql_error();
		
	}
	
	
	/*
	* @createOptionsWithTwoTagRowColor($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$tagField,$tagField2,$color1,$color2)
	*
	* Δημιουργία options για select input
	*/
	public function createOptionsRowColor($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$color1,$color2)
	{
		$sql = "SELECT $fieldsID,$fieldsText
				FROM $table ";
		if( strlen($where) > 0 )		
			$sql .= " WHERE ".$where . " " ;
		$sql .= " ORDER BY $orderBy $descAsc ";	
		
		$res = mysql_query($sql,$this->conn_id);
		
		if( $res )
		{
			$bgcolor = $color1;
			while( $row = mysql_fetch_array($res) )
			{
				if( $bgcolor == $color2 )
					$bgcolor = $color1;
				else
					$bgcolor = $color2;	
				
				if( $row[$fieldsID] == $SelectedID  )
					$selected = "selected";
				else
					$selected = "";	
				$option .= "<option value=\"".$row[$fieldsID]."\" $selected style=\"background-color:".$bgcolor."\"><b>".$row[$fieldsText]."</b>  </option>";	
			}
			
			return $option;
		}
		else
			return mysql_error();
		
	}
	
	
	/*
	* @createOptionsShowLotFields($fieldsID,$TBLfieldsTexts,$spliter,$SelectedID,$table,$where,$orderBy,$descAsc)
	*
	* Δημιουργία options για select input δείχνοντας πολλές περιγραφές διαχωρίζοντας με το $spliter
	*/
	public function createOptionsShowLotFields($fieldsID,$TBLfieldsTexts,$spliter,$SelectedID,$table,$where,$orderBy,$descAsc)
	{
		$sql = "SELECT *
				FROM $table ";
		if( strlen($where) > 0 )		
			$sql .= " WHERE ".$where . " " ;
		$sql .= " ORDER BY $orderBy $descAsc ";	
		
		$res = mysql_query($sql,$this->conn_id);
		
		if( $res )
		{
			while( $row = mysql_fetch_array($res) )
			{
				if( $row[$fieldsID] == $SelectedID  )
					$selected = "selected";
				else
					$selected = "";	
					
				$textFields = "";	
				for( $i = 0; $i < count($TBLfieldsTexts); $i++ )	
				{
					$textFields .= $row[$TBLfieldsTexts[$i]]." &nbsp;&nbsp;".$spliter."&nbsp;&nbsp;";		
				}
					
				$option .= "<option value=\"".$row[$fieldsID]."\" $selected>".$textFields."</option>";	
			}
			
			return $option;
		}
		else
			return mysql_error();
		
	}
	
	/*
	* @getSomeDesc($id,$table,$desciptionFiled,$idField)
	*
	* Βρίσκει την περιγραφή ($desciptionFiled) 
	* από μία εγγραφή ενός πίνακα ($table) με βάση
	* το ID (πεδίο : $idField) (τιμή : $id) 
	*/
	public function getSomeDesc($id,$table,$desciptionFiled,$idField)
	{
		if( isset($id) )
		{
			$sql = "SELECT $desciptionFiled
					FROM $table
					WHERE $idField = '".$id."'";
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
	
	/*
	* @sorter($sql,orderField,DescAsc)
	*
	* Ταξινομεί τα αποτελέσματα σύμφωνα με 
	* το πεδίο orderField και με ταξινόμηση DescAsc.
	* Δέχεται το sql ερώτημα και προσθέτει το ORDER BY
	*/
	public function sorter($sql,$orderField,$DescAsc)
	{
		if( isset($sql) )
		{
			$sql = str_replace("ORDER BY","",$sql);
			$sql .= " ORDER BY ".$orderField." ".$DescAsc." ";
			$res = mysql_query($sql,$this->conn_id);
			return $res;
		}
		else
			return 0;
	}
	
	/*
	* @getTblFields($table)
	*
	* Βρίσκει και επιστρέφει τα πεδία ενός
	* πίνακα από την βάση δεδομένων.
	*/
	public function getTblFields($table)
	{
		if( isset($table) )
		{
			$sql = "show fields from $table ";
			$res = mysql_query($sql,$this->conn_id);
			$FIELDS = array();
			$TYPE = array();
			$i = 0;
			while( $row = mysql_fetch_array($res) )
			{
				$FIELDS[$i] = $row['Field'];
				$TYPE[$i]   = $row['Type'];
				$i++;
			}
			return $FIELDS;
		}
		else
			return 0;
	}
	
	/*
	* @closeForm()
	*
	* Κλείνει το παράθυρο
	* καλώντας javascript function
	*/
	public function closeForm()
	{
		print "<script> window.close(); </script>";
	}
	
	/*
	* @goto($url)
	*
	* Πηγαίνει τον χρήστη
	* στο αντίστοιχο url
	*/
	public function goto_v2($url)
	{
		print "<script> self.location.href = '".$url."'; </script>";
	}
	
	/*
	* @gotoTaget($url,$target)
	*
	* Πηγαίνει τον χρήστη
	* στο αντίστοιχο url
	*/
	public function gotoTaget($url,$target,$widthHeight = '')
	{
		if( strlen($widthHeight) )
		{
			print "<script> window.open('".$url."','".$target."','".$widthHeight."') </script>";
		}
		else
			print "<script> window.open('".$url."','".$target."') </script>";
	}
	
	/*
	* @gotoTarget($url,$target)
	*
	* Πηγαίνει τον χρήστη
	* στο αντίστοιχο url
	*/
	public function gotoTarget($url,$target,$widthHeight = '')
	{
		if( strlen($widthHeight) )
		{
			print "<script> window.open('".$url."','".$target."','".$widthHeight."') </script>";
		}
		else
			print "<script> window.open('".$url."','".$target."') </script>";
	}
	
	/*
	* @deleteExec($sql)
	*
	* Εκετλεί ερώτημα DELETE
	*/
	public function deleteExec($sql)
	{
		if( isset($sql) )
		{
			$res = mysql_query($sql,$this->conn_id);
			if( $res )
				return $res;
			else
				return mysql_error();	
		}
		else
			return 0;
		
	}
	
	/*
	* @createOptionsTBLS($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc)
	*
	* Δημιουργία options για select input
	* me dynatotita pollaplis epilogis
	*/
	public function createOptionsTBLS($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc)
	{
		$sql = "SELECT $fieldsID,$fieldsText
				FROM $table ";
		if( strlen($where) > 0 )		
			$sql .= " WHERE ".$where . " " ;
		$sql .= " ORDER BY $orderBy $descAsc ";	
		
		$res = mysql_query($sql,$this->conn_id);
		
		if( $res )
		{
			while( $row = mysql_fetch_array($res) )
			{
				$rtrn = $this->getSelectedID($SelectedID,$row[$fieldsID]);
				if( $rtrn == "true" )
					$selected = "selected";
				else
					$selected = "";	
				$option .= "<option value=\"".$row[$fieldsID]."\" $selected>".$row[$fieldsText]."</option>";	
			}
			
			return $option;
		}
		else
			return mysql_error();
		
	}
	
	/*
	* @getSelectedID($SelectedID,$fieldID)
	*
	* Elegxei tin isotita tvn timvn tou pinaka $SelectedID (Array)
	* me tin timh toy $fieldID. Ean einai isa epistrefei true
	* allivs epistrefei false.
	*/
	public function getSelectedID($SelectedID,$fieldID)
	{
		$return = "false";
		if( count($SelectedID)>0 )
		{
			for( $i=0;$i<count($SelectedID);$i++ )
			{
				if( $SelectedID[$i] == $fieldID )
				{
					//break;
					$return = "true";
				}
				
			}
			return $return;
		}
		else
			return $return;
	}
	
	
	/*
	* @makeFieldSortable($fieldText,$sortField,$descAsc,$REQDescAsc,$REQSorter,$url,$className)
	*
	* Κάνει την στύλει, στην οποία καλείται, sortable.
	* Κάνωντας click το πεδίο ταξινομεί τον πίνακα με το
	* ανάλογο πεδίο και με το ανάλογο desc ή asc.
	*
	* $fieldText : Το εμφανιζόμενο κείμενο
	* $sortField : To όνομα του πεδίου του πίνακα
	* $descAsc   : Η κατάσταση του πίνακα που έχει εμφανιστεί (asc or desc)
	* $REQDescAsc: Το αποτέλεσμα που φέρνει η εντολή $_REQUEST['descAsc']
	* $REQSorter : Το αποτέλεσμα που φέρνει η εντολή $_REQUEST['sortable']
	* $url       : Το url της σελίδας που εμφανίζονται τα δεδομένα
	* $className : το όνομα της class για το link <a /> για αισθησιακούς λόγους
	* $imgDown   : Η διεύθυνση της εικόνας που δείχνει το κάτω βελάκι 
	* $imgUp     : Η διεύθυνση της εικόνας που δείχνει το πάνω βελάκι
	*/
	public function makeFieldSortable($fieldText,$sortField,$descAsc,$REQDescAsc,$REQSorter,$url,$className,$imgDown,$imgUp)
	{
		$sortable = "<a href=\"#\" class=\"".$className."\" onClick=\"self.location = '".$url."?bttnSearch=1&sorter=".$sortField."&descAsc=".$descAsc."';\">".$fieldText."</a>";
		//Sort
		if( $REQDescAsc == "ASC" && $REQSorter == $sortField )
			$sortable .= "<img src=\"".$imgDown."\">";
		else if( $REQDescAsc == "DESC" && $REQSorter == $sortField )
			$sortable .= "<img src=\"".$imgUp."\">";
		else
			$sortable .= "";	
				
		echo $sortable;
	}
	
	
	/*
	* @makeFieldSortable($fieldText,$sortField,$descAsc,$REQDescAsc,$REQSorter,$url,$className,$filter)
	*
	* Κάνει την στύλει, στην οποία καλείται, sortable.
	* Κάνωντας click το πεδίο ταξινομεί τον πίνακα με το
	* ανάλογο πεδίο και με το ανάλογο desc ή asc. Επίσης
	* διατηρεί και το φίλτρο που έχει χρησιμοποιηθεί.
	*
	* $fieldText : Το εμφανιζόμενο κείμενο
	* $sortField : To όνομα του πεδίου του πίνακα
	* $descAsc   : Η κατάσταση του πίνακα που έχει εμφανιστεί (asc or desc)
	* $REQDescAsc: Το αποτέλεσμα που φέρνει η εντολή $_REQUEST['descAsc']
	* $REQSorter : Το αποτέλεσμα που φέρνει η εντολή $_REQUEST['sortable']
	* $url       : Το url της σελίδας που εμφανίζονται τα δεδομένα
	* $className : το όνομα της class για το link <a /> για αισθησιακούς λόγους
	* $imgDown   : Η διεύθυνση της εικόνας που δείχνει το κάτω βελάκι 
	* $imgUp     : Η διεύθυνση της εικόνας που δείχνει το πάνω βελάκι
	*/
	public function makeFieldSortableWithFilter($fieldText,$sortField,$descAsc,$REQDescAsc,$REQSorter,$url,$className,$imgDown,$imgUp,$filter)
	{
		$sortable = "<a href=\"".$url."?sorter=".$sortField."&Myfilter=".$filter."&descAsc=".$descAsc."\" class=\"".$className."\" onClick=\"self.location = '".$url."?sorter=".$sortField."&descAsc=".$descAsc."&Myfilter=".$filter."';\">".$fieldText."</a>";
		//Sort
		if( $REQDescAsc == "ASC" && $REQSorter == $sortField )
			$sortable .= "<img src=\"".$imgDown."\">";
		else if( $REQDescAsc == "DESC" && $REQSorter == $sortField )
			$sortable .= "<img src=\"".$imgUp."\">";
		else
			$sortable .= "";	
				
		echo $sortable;
	}
	
	
	/*
	* @makeFieldSortableSession($fieldText,$sortField,$descAsc,$REQDescAsc,$REQSorter,$url,$className,$filter)
	*
	* Κάνει την στύλει, στην οποία καλείται, sortable.
	* Κάνωντας click το πεδίο ταξινομεί τον πίνακα με το
	* ανάλογο πεδίο και με το ανάλογο desc ή asc. Επίσης
	* διατηρεί και το φίλτρο που έχει χρησιμοποιηθεί.
	*
	* $fieldText : Το εμφανιζόμενο κείμενο
	* $sortField : To όνομα του πεδίου του πίνακα
	* $descAsc   : Η κατάσταση του πίνακα που έχει εμφανιστεί (asc or desc)
	* $REQDescAsc: Το αποτέλεσμα που φέρνει η εντολή $_REQUEST['descAsc']
	* $REQSorter : Το αποτέλεσμα που φέρνει η εντολή $_REQUEST['sortable']
	* $url       : Το url της σελίδας που εμφανίζονται τα δεδομένα
	* $className : το όνομα της class για το link <a /> για αισθησιακούς λόγους
	* $imgDown   : Η διεύθυνση της εικόνας που δείχνει το κάτω βελάκι 
	* $imgUp     : Η διεύθυνση της εικόνας που δείχνει το πάνω βελάκι
	*
	* $querySrting : είναι το $_SERVER['QUERY_STRING'] για να κρατάει τα Requests
	*/
	public function makeFieldSortableWithFilterSession($fieldText,$sortField,$descAsc,$REQDescAsc,$REQSorter,$url,$className,$imgDown,$imgUp,$filter,$querySrting)
	{
		$querySrting = $this->getDuplicatesWorlds($querySrting);					//remove doublicates words
		
		
		$sortable = "<a href=\"".$url."?sorter=".$sortField."&Myfilter=".$filter."&descAsc=".$descAsc."&".$querySrting."\" class=\"".$className."\" onClick=\"self.location = '".$url."?sorter=".$sortField."&descAsc=".$descAsc."&Myfilter=".$filter."&".$querySrting."';\">".$fieldText."</a>";
		//Sort
		if( $REQDescAsc == "ASC" && $REQSorter == $sortField )
			$sortable .= "<img src=\"".$imgDown."\">";
		else if( $REQDescAsc == "DESC" && $REQSorter == $sortField )
			$sortable .= "<img src=\"".$imgUp."\">";
		else
			$sortable .= "";	
				
		echo $sortable;
	}
	
	/*
	* @printMultipleRowsFrnKey($firstForeignKeyValue,$firstForeignKeyField,$secondForeignKeyValue,$secondForeignKeyField,$tableName,$orderByField,$descAsc,$selectID)
	*
	* Βρίσκει και τυπώνει γραμμές από πίνακα που περιέχει 2 ξένα κλειδιά.
	*/
	public function printMultipleRowsFrnKey($firstForeignKeyValue,$firstForeignKeyField,$secondForeignKeyValue,$secondForeignKeyField,$tableName,$orderByField,$descAsc,$selectID)
	{
		if( strlen($firstForeignKeyValue) > 0 )
		{
			$firstValue = " ".$firstForeignKeyField ." = '".$firstForeignKeyValue."'";
			$firstTrue = true;
		}	
		else
			$firstValue = "";
			
		if( strlen($secondForeignKeyValue) > 0 )	
		{
			if($firstTrue)
				$secondValue = " AND ";
			$secondValue .= " ".$secondForeignKeyField." = '".$secondForeignKeyValue."'";	
		}
		else
			$secondValue = "";	
				
		$sql = "SELECT * 
				FROM $tableName
				WHERE $firstValue 
				$secondValue 
				ORDER BY $orderByField $descAsc";
		$res = mysql_query($sql,$this->conn_id);
		
		$returnIDs = array();
				
		if( $res )
		{
			$i = 0;
			while( $row = mysql_fetch_array($res) )
			{
				 $returnIDs[$i] = $row[$selectID];
				 $i++;
			}
		}		
		return $returnIDs; 
	}
	
	
	/*
	* @getDuplicatesWorlds($string)
	*
	* Βρίσκει τις διπλές λέξεις σε ένα string και τις αφαιρεί.
	*/
	public function getDuplicatesWorlds($string)
	{
		$string = preg_replace("/([,.?!])/"," \\1",$string); 
		$parts = explode("&",$string); 
		$unique = array_unique($parts); 
		$unique = implode("&",$unique); 
		$unique = preg_replace("/\s([,.?!])/","\\1",$unique); 
		
		return $unique;
	}
	
	
	/*
	* @getCountFromTable($tableName,$whereField,$wherValue)
	*
	* Βρίσκει το άθροισμα των εγγραφών από ένα πίνακα
	*/
	public function getCountFromTable($tableName,$whereField,$wherValue)
	{
		if( isset($tableName) )
		{
			$sql = "SELECT count(*) AS Count
					FROM $tableName ";
			if( strlen($whereField) && strlen($wherValue)  )		
				$sql .= " WHERE $whereField = '$wherValue' ";
			$res = mysql_query($sql);	
			if( $res )
			{
				$row = mysql_fetch_array($res);
				return $row['Count'];
			}
			else
				return mysql_error();
		}
		else
			return -1;
			
	}
	
	/*
	* @getCountFromTableSxsi($tableName,$whereField,$wherValue,$sxesi,$freeWhile)
	*
	* Βρίσκει το άθροισμα των εγγραφών από ένα πίνακα
	*/
	public function getCountFromTableSxsi($tableName,$whereField,$wherValue,$sxesi,$freeWhile)
	{
		if( isset($tableName) )
		{
																			//DISTINCT 
			$sql = "SELECT DISTINCT $whereField
					FROM $tableName ";
			if( strlen($whereField) && strlen($wherValue)  )		
				$sql .= " WHERE $whereField $sxesi '$wherValue' ".$freeWhile;
			$res = mysql_query($sql);	
			if( $res )
			{
				//$row = mysql_fetch_array($res);
				return mysql_num_rows($res);
			}
			else
				return mysql_error();
		}
		else
			return -1;
			
	}
	
	
	
	
	/*
	* @getAllEmpty($table1,$fieldTbl1,$table2,$fieldTbl2)
	* 
	* Βρίσκει τις εγγραφές του Table1 οι οποίοι δεν είναι 
	* εγγεραμένοι στον Table2.
	*/
	public function getAllEmpty($table1,$fieldTbl1,$table2,$fieldTbl2)
	{
		$sql = "select  count(*) AS Count
				FROM $table1 GT
				left JOIN $table2 SC ON GT.".$fieldTbl1." = SC.".$fieldTbl2."
				where SC.".$fieldTbl2." IS NULL OR SC.".$fieldTbl2." = '0' ";
		$res = mysql_query($sql);
		if( $res )
		{
			$row = mysql_fetch_array($res);
			return $row['Count'];
		}	
		else
			return mysql_error();
		
	}
	
	
	/*
	* @getAllEmpty($table1,$fieldTbl1,$table2,$fieldTbl2)
	* 
	* Βρίσκει τις εγγραφές του Table1 οι οποίοι δεν είναι 
	* εγγεραμένοι στον Table2.
	*/
	public function getAllEmptySecondField($table1,$fieldTbl1,$table2,$fieldTbl2,$secondField)
	{
		$sql = "select  count(*) AS Count
				FROM $table1 GT
				left JOIN $table2 SC ON GT.".$fieldTbl1." = SC.".$fieldTbl2."
				where SC.".$secondField." IS NULL OR SC.".$secondField." = '0' ";
		$res = mysql_query($sql);
		if( $res )
		{
			$row = mysql_fetch_array($res);
			return $row['Count'];
		}	
		else
			return mysql_error();
		
	}
	
	/*
	* @getAllEmtpyFromGT($fieldName,$tableName)
	* 
	* Βρίσκει τις εγγραφές του Table1 οι οποίοι δεν είναι 
	* εγγεραμένοι στον Table2.
	*/
	public function getAllEmtpyFromGT($fieldName,$tableName)
	{
		$sql = "SELECT count(*) AS myCount
				FROM  $tableName
				WHERE  $fieldName = 0 OR $fieldName IS NULL";
		$res = mysql_query($sql);		
		if( $res )
		{
			$row = mysql_fetch_array($res);
			return $row['myCount'];
		}	
		else
			return mysql_error();
	}
	
	
	/*
	* @createOptionsWithEverythink($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$setDesc)
	*
	* Δημιουργία options για select input me $setDesc για πρόσθετη πληροφορία
	*/
	public function createOptionsWithEverythink($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$setDesc)
	{
		$sql = "SELECT $fieldsID,$fieldsText
				FROM $table ";
		if( strlen($where) > 0 )		
			$sql .= " WHERE ".$where . " " ;
		$sql .= " ORDER BY $orderBy $descAsc ";	
		
		$res = mysql_query($sql,$this->conn_id);
		
		if( $res )
		{
			while( $row = mysql_fetch_array($res) )
			{
				if( $row[$fieldsID] == $SelectedID  )
					$selected = "selected";
				else
					$selected = "";	
				$option .= "<option value=\"".$row[$fieldsID]."\" $selected>".$row[$fieldsText].$setDesc."</option>";	
			}
			
			return $option;
		}
		else
			return mysql_error();
		
	}
	
	
	/*
	* @createOptionsWithCount($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$setDesc)
	*
	* Δημιουργία options για select input me $setDesc για πρόσθετη πληροφορία
	*/
	public function createOptionsWithCount($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$setDesc)
	{
		$sql = "SELECT $fieldsID,$fieldsText
				FROM $table ";
		if( strlen($where) > 0 )		
			$sql .= " WHERE ".$where . " " ;
		$sql .= " ORDER BY $orderBy $descAsc ";	
		
		$res = mysql_query($sql,$this->conn_id);
		
		if( $res )
		{
			while( $row = mysql_fetch_array($res) )
			{
				if( $row[$fieldsID] == $SelectedID  )
					$selected = "selected";
				else
					$selected = "";	
				$count = $this->getCountFromTableSxsiWithoutDiS("tbl_link_shape_shape_search_category","tbl_link_shape_shape_search_category_id",$row[$fieldsID],"="," ");	
				$option .= "<option value=\"".$row[$fieldsID]."\" $selected>".$row[$fieldsText].$setDesc." [".$count." ]</option>";	
			}
			
			return $option;
		}
		else
			return mysql_error();
		
	}
	
	/*
	* @getCountFromTableSxsiWithoutDiS($tableName,$whereField,$wherValue,$sxesi,$freeWhile)
	*
	* Βρίσκει το άθροισμα των εγγραφών από ένα πίνακα
	*/
	public function getCountFromTableSxsiWithoutDiS($tableName,$whereField,$wherValue,$sxesi,$freeWhile)
	{
		if( isset($tableName) )
		{
																			//DISTINCT 
			$sql = "SELECT DISTINCT $whereField,tbl_link_shape_shape_search_shape_id
					FROM $tableName ";
			if( strlen($whereField) && strlen($wherValue)  )		
				$sql .= " WHERE $whereField $sxesi '$wherValue' ".$freeWhile;
			$res = mysql_query($sql);	
			if( $res )
			{
				//$row = mysql_fetch_array($res);
				return mysql_num_rows($res);
			}
			else
				return mysql_error();
		}
		else
			return -1;
			
	}
	
	public function getCountProcedure($procedureName,$variable)
	{
		$sqlPR = "call $procedureName";												//countGeneralTbl(@'a')";
		$result = mysql_query($sqlPR);
		$sql2 = "SELECT $variable";
		$result2 = mysql_query($sql2);
		$rowPR = mysql_fetch_array($result2); 
		echo $rowPR[$variable];
	}
	
	
	public function getBuffetAllSet($procedureName,$variable)
	{
		$sqlPR = "call $procedureName";												//countGeneralTbl(@'a')";
		$result = mysql_query($sqlPR);
		$sql2 = "SELECT $variable";
		$result2 = mysql_query($sql2);
		$rowPR = mysql_fetch_array($result2); 
		echo $rowPR[$variable];
	}
	
	public function getAllFromTable($tableName)
	{
		if( isset($tableName) )
		{
																			//DISTINCT 
			$sql = "SELECT count(*) AS myCount
					FROM $tableName ";
			$res = mysql_query($sql);	
			if( $res )
			{
				$row = mysql_fetch_array($res);
				return $row['myCount'];
			}
			else
				return mysql_error();
		}
		else
			return -1;
	}
	
	
	/*
	* @createOptionsCount($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$tableName,$shapeFieldName,$thisFieldName)
	*
	* Δημιουργία options για select input
	*/
	public function createOptionsCount($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$tableName,$shapeFieldName,$thisFieldName)
	{
		$sql = "SELECT $fieldsID,$fieldsText
				FROM $table ";
		if( strlen($where) > 0 )		
			$sql .= " WHERE ".$where . " " ;
		$sql .= " ORDER BY $orderBy $descAsc ";	
		
		$res = mysql_query($sql,$this->conn_id);
		
		if( $res )
		{
			while( $row = mysql_fetch_array($res) )
			{
				if( $row[$fieldsID] == $SelectedID  )
					$selected = "selected";
				else
					$selected = "";	
				
				$sqlCount = "SELECT distinct $shapeFieldName 
							 FROM $tableName
							 WHERE $thisFieldName = '".$row[$fieldsID]."' ";
				if( strlen($shapeFieldName) > 0 )			 
					$sqlCount .= " AND $shapeFieldName != 0";
					
				$resCount = mysql_query($sqlCount,$this->conn_id);
				$rowCount = @mysql_num_rows($resCount);			 
					
				$option .= "<option value=\"".$row[$fieldsID]."\" $selected>".$row[$fieldsText]." <font style=\"color:green;\">[".$rowCount."]"."</font></option>";	
			}
			
			return $option;
		}
		else
			return mysql_error();
		
	}
	
	
	/*
	* @createOptionsShowLotFieldsCount($fieldsID,$TBLfieldsTexts,$spliter,$SelectedID,$table,$where,$orderBy,$descAsc)
	*
	* Δημιουργία options για select input δείχνοντας πολλές περιγραφές διαχωρίζοντας με το $spliter
	*/
	public function createOptionsShowLotFieldsCount($fieldsID,$TBLfieldsTexts,$spliter,$SelectedID,$table,$where,$orderBy,$descAsc,$tableName,$shapeFieldName,$thisFieldName)
	{
		$sql = "SELECT *
				FROM $table ";
		if( strlen($where) > 0 )		
			$sql .= " WHERE ".$where . " " ;
		$sql .= " ORDER BY $orderBy $descAsc ";	
		
		$res = mysql_query($sql,$this->conn_id);
		
		if( $res )
		{
			while( $row = mysql_fetch_array($res) )
			{
				if( $row[$fieldsID] == $SelectedID  )
					$selected = "selected";
				else
					$selected = "";	
					
				$textFields = "";	
				for( $i = 0; $i < count($TBLfieldsTexts); $i++ )	
				{
					$textFields .= $row[$TBLfieldsTexts[$i]]." &nbsp;&nbsp;".$spliter."&nbsp;&nbsp;";		
				}
				
				$sqlCount = "SELECT distinct $shapeFieldName 
							 FROM $tableName
							 WHERE $thisFieldName = '".$row[$fieldsID]."' ";
				if( strlen($shapeFieldName) > 0 )			 
					$sqlCount .= " AND $shapeFieldName != 0";
					
				$resCount = mysql_query($sqlCount,$this->conn_id);
				$rowCount = @mysql_num_rows($resCount);			 
					
				$option .= "<option value=\"".$row[$fieldsID]."\" $selected>".$textFields." [".$rowCount."]</option>";	
			}
			
			return $option;
		}
		else
			return mysql_error();
		
	}
	
	
	/*
	* @getTechniquesTextsSorted($ids,$orderByField)
	*
	* Επιστέφει τα $returnField από τον πίνακα $table με τα ids ($ids) που δίνεται
	* και με ταξινόμηση $orderByField
	*/
	public function getTechniquesTextsSorted($ids,$table,$idField,$returnField,$orderByField)
	{
		if( strlen( $ids ) )
		{
			$sql = "SELECT $returnField
					FROM $table
					WHERE $idField IN ($ids)
					ORDER BY $orderByField";
			$row = $this->excQuery($sql);
			$koma = "";		
			$techniqueText = "";
			for( $i=0;$i<count($row);$i++ )
			{
				$techniqueText .= $koma.$row[$i][0];
				$koma = ",";
			}
			return $techniqueText;
		}
	}
	
	
	/*
	* @getTechniqueGroupID($likesValue,$table,$likeFieldName,$returnFiledName)
	*
	*/
	public function getTechniqueGroupID($likesValue,$table,$likeFieldName,$returnFiledName)
	{
		if( isset( $likesValue ) )
		{
			$sql = "SELECT $returnFiledName
					FROM $table
					WHERE $likeFieldName = '$likesValue' ";
			return $this->excQuery($sql);		
		}	
	}
	
	/*
	* @getTechniqueGroupIDLike($likesValue,$table,$likeFieldName,$returnFiledName)
	*
	*/
	public function getTechniqueGroupIDLike($likesValue,$table,$likeFieldName,$returnFiledName)
	{
		if( isset( $likesValue ) )
		{
			$sql = "SELECT $returnFiledName,
							( select count(*) from general_table_tp where gentable_technic_group_id = tbl_param_technic_shapes_group_id )AS counter
					FROM $table
					WHERE $likeFieldName LIKE '%$likesValue%' 
					AND $likeFieldName != '$likesValue'
					ORDER BY counter DESC";
			return $this->excQuery($sql);		
		}	
	}
	
	
	/*
	* @getAndPrintGroupTechniques($group_id,$name)
	*
	* Βρίσκει και επιστρέφει σε μορφή table σε html 
	* τα techniques από τον πίνακα techniques4 και
	* τσεκάρει τα techniques που περιλαμβάνει το group $group_id
	* 
	* $group_id : Group ID
	* $name		: Name of <inpute type="checkbox" name=$name$Count id=$name$Count >
	*
	*/
	public function getAndPrintGroupTechniques($group_id,$name)
	{
		if( isset( $group_id ) )
		{
			$response = "";
		
			$response .= "<table width=\"100%\" style=\"border:2px solid #0000CC; \">
					  		<tr style=\"font-size:10px; \">";
			$sql = "SELECT tbtech4_unique,tbtech4_code 
					FROM technique4
					WHERE sort_vant IS NOT NULL
					ORDER BY sort_vant";
			$res_tchnique = mysql_query($sql) or die(mysql_error());		
			
			$bgcolColor = "#FFEDCA";
			
			While( $row_technique = mysql_fetch_array($res_tchnique) )
			{
				if( $bgcolColor == "#FFEDCA" )
					$bgcolColor = "";
				else
					$bgcolColor = "#FFEDCA";	
			
				$response .= "<td bgcolor=\"".$bgcolColor."\">".$row_technique['tbtech4_code']."</td>";
			}
				
			$response .= "</tr>
			<tr style=\"font-size:10px; \">";
			$sql = "SELECT tbtech4_unique,tbtech4_code 
					FROM technique4
					WHERE sort_vant IS NOT NULL
					ORDER BY sort_vant";
			$res_tchnique = mysql_query($sql) or die(mysql_error());	
					
			$bgcolColor = "#FFEDCA";
			$countChBXTechnique = 0;
						
			While( $row_technique = mysql_fetch_array($res_tchnique) )
			{
				if( $bgcolColor == "#FFEDCA" )
					$bgcolColor = "";
				else
					$bgcolColor = "#FFEDCA";	
				
				$response .= "<td bgcolor=\"".$bgcolColor."\">";
					
				$checked = "";
				$sqlChecked = "SELECT tbl_param_technic_shapes_group_link_technic_group_id,tbl_param_technic_shapes_group_link_technic_technic_id
							   FROM tbl_param_technic_shapes_group_link_technic 
							   WHERE tbl_param_technic_shapes_group_link_technic_group_id = '".$group_id."' 
							   AND tbl_param_technic_shapes_group_link_technic_technic_id = '".$row_technique['tbtech4_unique']."' ";
				$resChecked = mysql_query($sqlChecked) or die( mysql_error() );		
				if( @mysql_num_rows($resChecked) > 0 )	   
					$checked = "checked";
				else
					$checked = "";	
					
				$response .= "<input type=\"checkbox\" name=\"$name".$countChBXTechnique."\" id=\"$name".$countChBXTechnique."\" value=\"".$row_technique['tbtech4_unique']."\" ".$checked." onClick=\"init('".$name."".$countChBXTechnique."')\">";
				$response .= "</td>";
				
						$countChBXTechnique++;
			} //End of while
				
				$response .= "<input type=\"hidden\" name=\"$name\" id=\"$name\" value=\"".$countChBXTechnique."\">";
				$response .= "</tr>";
	  		$response .= "</table>";
	  
			return $response;
		}	//end of if
	}		//end of method
	
	
	
	
	
	/*
	* @getAndPrintGroupTechniquesLike($group_id,$name)
	*
	* Βρίσκει και επιστρέφει σε μορφή table σε html 
	* τα techniques από τον πίνακα techniques4 και
	* τσεκάρει τα techniques που περιλαμβάνει το group $group_id
	* 
	* $group_id : Group ID
	* $name		: Name of <inpute type="checkbox" name=$name$Count id=$name$Count >
	*
	*/
	public function getAndPrintGroupTechniquesLike($group_id,$name)
	{
		if( isset( $group_id ) )
		{
			$response = "";
		
			$response .= "<table width=\"100%\" style=\"border:0px solid #0000CC; \">
					  		<tr style=\"font-size:10px; \">";
			$sql = "SELECT tbtech4_unique,tbtech4_code 
					FROM technique4
					WHERE sort_vant IS NOT NULL
					ORDER BY sort_vant";
			$res_tchnique = mysql_query($sql) or die(mysql_error());		
			
			$bgcolColor = "#FFEDCA";
			
			While( $row_technique = mysql_fetch_array($res_tchnique) )
			{
				if( $bgcolColor == "#FFEDCA" )
					$bgcolColor = "";
				else
					$bgcolColor = "#FFEDCA";	
			
				$response .= "<td bgcolor=\"".$bgcolColor."\">".$row_technique['tbtech4_code']."</td>";
			}
				
			$response .= "</tr>
			<tr style=\"font-size:10px; \">";
			$sql = "SELECT tbtech4_unique,tbtech4_code 
					FROM technique4
					WHERE sort_vant IS NOT NULL
					ORDER BY sort_vant";
			$res_tchnique = mysql_query($sql) or die(mysql_error());	
					
			$bgcolColor = "#FFEDCA";
			$countChBXTechnique = 0;
						
			While( $row_technique = mysql_fetch_array($res_tchnique) )
			{
				if( $bgcolColor == "#FFEDCA" )
					$bgcolColor = "";
				else
					$bgcolColor = "#FFEDCA";	
				
				$response .= "<td bgcolor=\"".$bgcolColor."\">";
					
				$checked = "";
				$sqlChecked = "SELECT tbl_param_technic_shapes_group_link_technic_group_id,tbl_param_technic_shapes_group_link_technic_technic_id
							   FROM tbl_param_technic_shapes_group_link_technic 
							   WHERE tbl_param_technic_shapes_group_link_technic_group_id = '".$group_id."' 
							   AND tbl_param_technic_shapes_group_link_technic_technic_id = '".$row_technique['tbtech4_unique']."' ";
				$resChecked = mysql_query($sqlChecked) or die( mysql_error() );		
				if( @mysql_num_rows($resChecked) > 0 )	   
					$checked = "checked";
				else
					$checked = "";	
					
				$response .= "<input type=\"checkbox\" name=\"$name".$countChBXTechnique."\" id=\"$name".$countChBXTechnique."\" value=\"".$row_technique['tbtech4_unique']."\" ".$checked." onClick=\"init('".$name."".$countChBXTechnique."')\">";
				$response .= "</td>";
				
						$countChBXTechnique++;
			} //End of while
				
				$response .= "<input type=\"hidden\" name=\"$name\" id=\"$name\" value=\"".$countChBXTechnique."\">";
				$response .= "</tr>";
	  		$response .= "</table>";
	  
			return $response;
		}	//end of if
	}		//end of method
	
	
	
	
	/*
	* @getLastID()
	*
	* Επιστρέφει το τελευταίο ID που καταχωρήθηκε.
	* Εκτελείται αμέσος μετά την εκτέλεση καταχώρησης 
	* ( INSERT )
	*/
	public function getLastID()
	{
		return mysql_insert_id();
	}
	
	
	public function getNumberOfShape($groupID,$table,$filedGroupIDName,$returnName)
	{
		if( is_numeric( $groupID ) )
		{
			$sql = "SELECT count(*) AS $returnName 
					FROM $table 
					WHERE $filedGroupIDName = $groupID";
			$res = $this->excQuery($sql);		
			return $res[0][0];
		}
	}
	
	/*
	* @excInsertUpdate($sql)
	*
	*/
	public function excInsertUpdate($sql)
	{
		if( strlen( $sql ) )
		{
			$res = mysql_query($sql,$this->conn_id);
			
			return $res;
		}
	}
	
	/*
	* @getResultsNumbers( $sql )
	*
	*/
	public function getResultsNumbers( $sql )
	{
		if( strlen( $sql ) )
		{
			$res = mysql_query($sql);
			if( $res )
				return mysql_num_rows($res);
			else
				return 0;	
		}
		else
			return -1;
	}
	
	/*
	* @getRowBgColor( $color1, color2 )
	*
	*/
	public function getRowBgColor( $color1, $color2 )
	{
		if( $this->bgColor == $color1 )
			$this->bgColor = $color2;
		else
			$this->bgColor = $color1;	
		return $this->bgColor;	
	}
	
	/*
	* @isTrueOrFalse($value,$prValue)
	*
	*/
	public function isTrueOrFalse($value,$prValue)
	{
		if( $value == $prValue )
		{
			return "<b><font color=red>".$value."</font></b>";
		}
		else
			return "<b><font color=green>".$value."</font></b>";
	}
	
	
	/*
	* @deleteFile($filename)
	*
	*/
	public function deleteFile($filename)
	{
		if( strlen( $filename ) )
		{
			unlink( $filename );
			return true;	
		}
		else
			return false;
	}
	
	
	/*
	* @createFolder($filename)
	*
	*/
	public function createFolder($folderName)
	{
		if( strlen( $folderName ) )
		{
			if( ! file_exists($folderName) )
			{
				mkdir($folderName, 0777);   
				return true;
			}
			else
				return false;	
			//unlink( $filename );	
		}
		else
			return false;
	}
	
	/*
	* @createOptionsTwoTables($ArrfieldsIDs,$ArrfieldsTexts,$ArrSelectedIDs,$ArrTables,$ArrWheres,$ArrOrderBys,$ArrDescAsc)
	*
	*/
	public function createOptionsTwoTables($ArrfieldsIDs,$ArrfieldsTexts,$ArrSelectedIDs,$ArrTables,$ArrWheres,$ArrOrderBys,$ArrDescAsc)
	{
		$option = "";
		$SUM_COUNT = 0;
		
		$ROW_IDS   = array();
		$ROW_TEXTS = array();
		$ROW_ALL_TEXT = array();
		
		for( $i=0; $i<count($ArrTables); $i++ )
		{
	
			$sql = "SELECT ".$ArrfieldsIDs[$i].",".$ArrfieldsTexts[$i]."
					FROM ".$ArrTables[$i]." ";
			if( strlen( $ArrWheres[$i] ) > 0 )		
				$sql .= " WHERE ".$ArrWheres[$i] . " " ;
			$sql .= " ORDER BY ".$ArrOrderBys[$i]." ".$ArrDescAsc[$i]." ";	
			
			$res = mysql_query($sql,$this->conn_id);
			
			$tagFieldName  = $ArrTags[$i];	
			$fieldsText    = $ArrfieldsTexts[$i];
			$fieldsID      = $ArrfieldsIDs[$i];
			
			if( $res )
			{
				while( $row = mysql_fetch_array($res) )
				{
					if( $row[$fieldsID] == $SelectedID  )
						$selected = "selected";
					else
						$selected = "";	
					
					$ROW_ALL_TEXT[$SUM_COUNT] = $row[$fieldsText].",".$row[$fieldsID];
					
					$SUM_COUNT++;
				}
			
				
			}
			else
				$option .= mysql_error();
		}	//end of for
		
		sort($ROW_ALL_TEXT);
		
		for( $i=0; $i<$SUM_COUNT; $i++ )
		{
			$table = explode(",",$ROW_ALL_TEXT[$i]);
			
			$option .= "<option value=\"".$table[1]."\" $selected>".$table[0]."</option>";	
		}
		
		return $option;
	}
	
	/*
	* @createOptionsTwoTablesWithTag($ArrfieldsIDs,$ArrfieldsTexts,$ArrSelectedIDs,$ArrTables,$ArrWheres,$ArrOrderBys,$ArrDescAsc,$ArrTags)
	*
	*/
	public function createOptionsTwoTablesWithTag($ArrfieldsIDs,$ArrfieldsTexts,$SelectedID,$ArrTables,$ArrWheres,$ArrOrderBys,$ArrDescAsc,$ArrTags)
	{
		$option = "";
		$SUM_COUNT = 0;
		
		$ROW_IDS   = array();
		$ROW_TEXTS = array();
		$ROW_TAGS  = array();
		$ROW_ALL_TEXT = array();
		
		for( $i=0; $i<count($ArrTables); $i++ )
		{
	
			$sql = "SELECT ".$ArrfieldsIDs[$i].",".$ArrfieldsTexts[$i].", ".$ArrTags[$i]."
					FROM ".$ArrTables[$i]." ";
			if( strlen( $ArrWheres[$i] ) > 0 )		
				$sql .= " WHERE ".$ArrWheres[$i] . " " ;
			$sql .= " ORDER BY ".$ArrOrderBys[$i]." ".$ArrDescAsc[$i]." ";	
			
			$res = mysql_query($sql,$this->conn_id);
			
			$tagFieldName  = $ArrTags[$i];	
			$fieldsText    = $ArrfieldsTexts[$i];
			$fieldsID      = $ArrfieldsIDs[$i];
			
			if( $res )
			{
				while( $row = mysql_fetch_array($res) )
				{
					if( $row[$fieldsID] == $SelectedID  )
						$selected = "selected";
					else
						$selected = "";	
					
					$ROW_ALL_TEXT[$SUM_COUNT] = $row[$fieldsText].",".$row[$fieldsID].",".$row[$tagFieldName];
					
					$SUM_COUNT++;
				}
			
				
			}
			else
				$option .= mysql_error();
		}	//end of for
		
		sort($ROW_ALL_TEXT);
		
		for( $i=0; $i<$SUM_COUNT; $i++ )
		{
			$table = explode(",",$ROW_ALL_TEXT[$i]);
			
			$option .= "<option value=\"".$table[1]."\" $selected>".$table[0]." | ".$table[2]."</option>";	
		}
		
		return $option;
		
	}
	
	/*
	* @createOptionsTwoTablesWithTagRowColor($ArrfieldsIDs,$ArrfieldsTexts,$SelectedID,$ArrTables,$ArrWheres,$ArrOrderBys,$ArrDescAsc,$ArrTags,$color1,$color2)
	*
	*/
	public function createOptionsTwoTablesWithTagRowColor($ArrfieldsIDs,$ArrfieldsTexts,$SelectedID,$ArrTables,$ArrWheres,$ArrOrderBys,$ArrDescAsc,$ArrTags,$color1,$color2)
	{
		$option = "";
		$SUM_COUNT = 0;
		
		$ROW_IDS   = array();
		$ROW_TEXTS = array();
		$ROW_TAGS  = array();
		$ROW_ALL_TEXT = array();
		
		for( $i=0; $i<count($ArrTables); $i++ )
		{
	
			$sql = "SELECT ".$ArrfieldsIDs[$i].",".$ArrfieldsTexts[$i].", ".$ArrTags[$i]."
					FROM ".$ArrTables[$i]." ";
			if( strlen( $ArrWheres[$i] ) > 0 )		
				$sql .= " WHERE ".$ArrWheres[$i] . " " ;
			$sql .= " ORDER BY ".$ArrOrderBys[$i]." ".$ArrDescAsc[$i]." ";	
			
			$res = mysql_query($sql,$this->conn_id);
			
			$tagFieldName  = $ArrTags[$i];	
			$fieldsText    = $ArrfieldsTexts[$i];
			$fieldsID      = $ArrfieldsIDs[$i];
			
			if( $res )
			{
				while( $row = mysql_fetch_array($res) )
				{
					if( $row[$fieldsID] == $SelectedID  )
						$selected = "selected";
					else
						$selected = "";	
					
					$ROW_ALL_TEXT[$SUM_COUNT] = $row[$fieldsText].",".$row[$fieldsID].",".$row[$tagFieldName];
					
					$SUM_COUNT++;
				}
			
				
			}
			else
				$option .= mysql_error();
		}	//end of for
		
		sort($ROW_ALL_TEXT);
		$bgcolor = "";
		
		for( $i=0; $i<$SUM_COUNT; $i++ )
		{
			$table = explode(",",$ROW_ALL_TEXT[$i]);
			
			if( $bgcolor == $color2 )
					$bgcolor = $color1;
			else
				$bgcolor = $color2;	
			
			$option .= "<option value=\"".$table[1]."\" $selected style=\"background-color:".$bgcolor."\">".$table[0]." | ".$table[2]."</option>";	
		}
		
		return $option;
		
	}
	
	/*
	* @perCent($value)
	*
	*/
	public function perCent($value)
	{
		if( is_numeric($value) )
		{
			$value = $value * 100;
			$value .= "";//"%";
			return $value;
		}
		else
			return $value;
	}
	
	/*
	* @unPerCent($value)
	*
	*/
	public function unPerCent($value)
	{
		$value = str_replace("%","",$value);
		if( is_numeric($value) )
		{
			$value = $value / 100;
			return $value;
		}
		else
			return 0;
	}
	
	
	/*
	* @getAndPrintGroupTechniques_NewVersion($group_id,$name)
	*
	* Βρίσκει και επιστρέφει σε μορφή table σε html 
	* τα techniques από τον πίνακα techniques4 και
	* τσεκάρει τα techniques που περιλαμβάνει το group $group_id
	* 
	* $group_id : Group ID
	* $name		: Name of <inpute type="checkbox" name=$name$Count id=$name$Count >
	* Proorizetai gia to neo Tpp
	*/
	public function getAndPrintGroupTechniques_NewVersion($group_id,$name)
	{
		if( isset( $group_id ) )
		{
			$response = "";
			$response .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
								<tr>
									<td width=\"14%\">";
										 
								  		$response .= "<table width=\"100%\" style=\"border:2px solid #0000CC; \">
					  									<tr style=\"font-size:10px; \">";
										$sql = "SELECT tbtech4_unique,tbtech4_code 
												FROM technique4
												WHERE sort_vant IS NOT NULL
												ORDER BY sort_vant";
										$res_tchnique = mysql_query($sql) or die(mysql_error());		
			
										$bgcolColor = "#FFEDCA";
			
										While( $row_technique = mysql_fetch_array($res_tchnique) )
										{
											if( $bgcolColor == "#FFEDCA" )
												$bgcolColor = "#FFFFFF";
											else
												$bgcolColor = "#FFEDCA";	
			
											$response .= "<td bgcolor=\"".$bgcolColor."\">".$row_technique['tbtech4_code']."</td>";
										}
				
										$response .= "</tr>";	
										$response .= "<tr style=\"font-size:10px; \">";
											$sql = "SELECT tbtech4_unique,tbtech4_code 
													FROM technique4
													WHERE sort_vant IS NOT NULL
													ORDER BY sort_vant";
											$res_tchnique = mysql_query($sql) or die(mysql_error());	
					
											$bgcolColor = "#FFEDCA";
											$countChBXTechnique = 0;
						
											While( $row_technique = mysql_fetch_array($res_tchnique) )
											{
												if( $bgcolColor == "#FFEDCA" )
													$bgcolColor = "#FFFFFF";
												else
													$bgcolColor = "#FFEDCA";	
				
												$response .= "<td bgcolor=\"".$bgcolColor."\">";
					
												$checked = "";
												$sqlChecked = "SELECT tbl_param_technic_shapes_group_link_technic_group_id,tbl_param_technic_shapes_group_link_technic_technic_id
															   FROM tbl_param_technic_shapes_group_link_technic 
															   WHERE tbl_param_technic_shapes_group_link_technic_group_id = '".$group_id."' 
															   AND tbl_param_technic_shapes_group_link_technic_technic_id = '".$row_technique['tbtech4_unique']."' ";
												$resChecked = mysql_query($sqlChecked) or die( mysql_error() );		
												if( @mysql_num_rows($resChecked) > 0 )	   
													$checked = "checked";
												else
													$checked = "";	
					
												$response .= "<input type=\"checkbox\" name=\"$name".$countChBXTechnique."\" id=\"$name".$countChBXTechnique."\" value=\"".$row_technique['tbtech4_unique']."\" ".$checked." onClick=\"init('".$name."".$countChBXTechnique."')\">";
												$response .= "</td>";
				
												$countChBXTechnique++;
											} //End of while
				
											$response .= "<input type=\"hidden\" name=\"$name\" id=\"$name\" value=\"".$countChBXTechnique."\">";
											$response .= "</tr>";
	  										$response .= "</table>";		
												
			$response .= "			</td>
									<td width=\"86%\" align=\"left\" valign=\"top\">
									  <table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                				        <tr>
					                          <td width=\"14%\" style=\"padding-left:5px;\" align=\"center\">
											  		No shapes <br>
													<b>
											  		".$this->getNumberOfShape($group_id,"general_table_tp","gentable_technic_group_id","myCounter")."
											  		</b>
													<br>
													<input type=\"button\" name=\"bttnEditGroup\" value=\"Edit this Group\" class=\"bttn_edit\" onClick=\"window.open('../../../../cp/shapes_version2/groups_of_shapes_techniques.php?group_id=".$group_id."&bttnSearch=Search','_blank')\">                            
											  ";
									$response .= $this->getSomeDesc( $group_id,"tbl_param_technic_shapes_group","tbl_param_technic_shapes_group_name","tbl_param_technic_shapes_group_id" );  
									//$response .= "<br>";
									
									$names = $this->getSomeDesc( $group_id,"tbl_param_technic_shapes_group","tbl_param_technic_shapes_group_text","tbl_param_technic_shapes_group_id" );  
									$tblName = array();
									$tblName = explode(",",$names);
									for( $nc=0;$nc<count($tblName);$nc++ )
									{
										$response .=  $tblName[$nc]."<br>";
									}
									//$response .= $names;
									//$response .= $this->getSomeDesc( $group_id,"tbl_param_technic_shapes_group","tbl_param_technic_shapes_group_text","tbl_param_technic_shapes_group_id" );  
			$response .= "			  </td>
                    					         <td width=\"69%\">
											  	Photos
											   ".$this->getShapePhotosFromTechGroupId($group_id)."
											  </td>
                    				    </tr>
				                      </table>
									</td>
								</tr>
							</table>";
			
			
	  			//".$this->getShapePhotosFromTechGroupId($group_id)."
			return $response;
		}	//end of if
	}		//end of method
	
	
	
	/*
	* @getAndPrintGroupTechniquesLike_newVersion($group_id,$name)
	*
	* Βρίσκει και επιστρέφει σε μορφή table σε html 
	* τα techniques από τον πίνακα techniques4 και
	* τσεκάρει τα techniques που περιλαμβάνει το group $group_id
	* 
	* $group_id : Group ID
	* $name		: Name of <inpute type="checkbox" name=$name$Count id=$name$Count >
	* Proorizetai gia to neo Tpp
	*/
	public function getAndPrintGroupTechniquesLike_newVersion($group_id,$name)
	{
		if( isset( $group_id ) )
		{
			$response = "";
			$response .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
								<tr>
									<td width=\"14%\">";
										 
								  		$response .= "<table width=\"100%\" style=\"border:0px solid #0000CC; \">
					  									<tr style=\"font-size:10px; \">";
										$sql = "SELECT tbtech4_unique,tbtech4_code 
												FROM technique4
												WHERE sort_vant IS NOT NULL
												ORDER BY sort_vant";
										$res_tchnique = mysql_query($sql) or die(mysql_error());		
			
										$bgcolColor = "#FFEDCA";
			
										While( $row_technique = mysql_fetch_array($res_tchnique) )
										{
											if( $bgcolColor == "#FFEDCA" )
												$bgcolColor = "#FFFFFF";
											else
												$bgcolColor = "#FFEDCA";	
			
											$response .= "<td bgcolor=\"".$bgcolColor."\">".$row_technique['tbtech4_code']."</td>";
										}
				
										$response .= "</tr>";	
										$response .= "<tr style=\"font-size:10px; \">";
											$sql = "SELECT tbtech4_unique,tbtech4_code 
													FROM technique4
													WHERE sort_vant IS NOT NULL
													ORDER BY sort_vant";
											$res_tchnique = mysql_query($sql) or die(mysql_error());	
					
											$bgcolColor = "#FFEDCA";
											$countChBXTechnique = 0;
						
											While( $row_technique = mysql_fetch_array($res_tchnique) )
											{
												if( $bgcolColor == "#FFEDCA" )
													$bgcolColor = "#FFFFFF";
												else
													$bgcolColor = "#FFEDCA";	
				
												$response .= "<td bgcolor=\"".$bgcolColor."\">";
					
												$checked = "";
												$sqlChecked = "SELECT tbl_param_technic_shapes_group_link_technic_group_id,tbl_param_technic_shapes_group_link_technic_technic_id
															   FROM tbl_param_technic_shapes_group_link_technic 
															   WHERE tbl_param_technic_shapes_group_link_technic_group_id = '".$group_id."' 
															   AND tbl_param_technic_shapes_group_link_technic_technic_id = '".$row_technique['tbtech4_unique']."' ";
												$resChecked = mysql_query($sqlChecked) or die( mysql_error() );		
												if( @mysql_num_rows($resChecked) > 0 )	   
													$checked = "checked";
												else
													$checked = "";	
					
												$response .= "<input type=\"checkbox\" name=\"$name".$countChBXTechnique."\" id=\"$name".$countChBXTechnique."\" value=\"".$row_technique['tbtech4_unique']."\" ".$checked." onClick=\"init('".$name."".$countChBXTechnique."')\">";
												$response .= "</td>";
				
												$countChBXTechnique++;
											} //End of while
				
											$response .= "<input type=\"hidden\" name=\"$name\" id=\"$name\" value=\"".$countChBXTechnique."\">";
											$response .= "</tr>";
	  										$response .= "</table>";		
												
			$response .= "			</td>
									<td width=\"86%\" align=\"left\" valign=\"top\">
									  <table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                				        <tr>
					                          <td width=\"14%\" style=\"padding-left:7px;\" align=\"center\">
											  		No shapes <br>
													<b>
											  		".$this->getNumberOfShape($group_id,"general_table_tp","gentable_technic_group_id","myCounter")."
													</b>
													<br>
													 <input type=\"button\" name=\"bttnEditGroup\" value=\"Edit this Group\" class=\"bttn_edit\" onClick=\"window.open('../../../../cp/shapes_version2/groups_of_shapes_techniques.php?group_id=".$group_id."&bttnSearch=Search','_blank')\">                            
											  ";
											$response .= $this->getSomeDesc( $group_id,"tbl_param_technic_shapes_group","tbl_param_technic_shapes_group_name","tbl_param_technic_shapes_group_id" );  
											//$response .= "<br>";
											$names = $this->getSomeDesc( $group_id,"tbl_param_technic_shapes_group","tbl_param_technic_shapes_group_text","tbl_param_technic_shapes_group_id" );  
											$tblName = array();
											$tblName = explode(",",$names);
											for( $nc=0;$nc<count($tblName);$nc++ )
											{
												$response .=  $tblName[$nc]."<br>";
											}
											
											
											//$response .= $this->getSomeDesc( $group_id,"tbl_param_technic_shapes_group","tbl_param_technic_shapes_group_text","tbl_param_technic_shapes_group_id" );  
			$response .= "					  </td>
                    					      <td width=\"69%\">
											  	Photos
												".$this->getShapePhotosFromTechGroupId($group_id)."
											  </td>
                    				    </tr>
				                      </table>
									</td>
								</tr>
							</table>";
			
			
	  		//".$this->getShapePhotosFromTechGroupId($group_id)."
			return $response;
		}	//end of if
	}		//end of method
	
	
	/*
	*
	*
	*/
	public function getShapePhotosFromTechGroupId($group_id)
	{
		$path = "../../../../ww/ion/img_skitsa/";
		if( is_numeric( $group_id ) )
		{
			$sql = "SELECT filename,filename_300,SK.gentable_id
					FROM general_table_tp g
					LEFT JOIN skitsa SK ON g.gentable_id = SK.gentable_id
					WHERE gentable_technic_group_id = ".$group_id."
					AND SK.filename IS NOT NULL
					LIMIT 30";
			$res = mysql_query($sql);
			
			if( $res )		
			{
				$result = "<div class=\"shapess_techniques_photos\">";	
				$i = 0;
				while( $row = mysql_fetch_array($res) )
				{
					$img = $path.$row['filename'];
					$img_300 = $path.$row['filename_300'];
					
					if( strlen($row['filename']) )
					{
						$rand = rand();
						$result .= " <img src=\"".$img."\" width=\"40\" onMouseOver=\"loadPhotos('../../../live_search/load_photos_joinShape.php','div_patternPhotos','tpp.skitsa',".$row['gentable_id'].",'filename_300','gentable_id','".$path."')\" onMouseOut=\"unLoadPhotos('div_patternPhotos')\" >";
						
					
					}	
					//if( $i == "7" )
					//	$result .= "<br>";
					$i++;
				}
					
				$result .= "</div>";
				
				return $result;
			}
			
		}
	}
	
	/*
	* @statusNotOk($value,$prValue)
	*
	*/
	public function statusNotOk($value)
	{
		if( $value == "True" )
		{
			if( $value == "not_ok" || $value == "True" )			//Status not ok == True -> Status = NOT OK
				$value = "Not OK";
			return "<b><font color=red>".$value."</font></b>";
		}
		else
		{
			if( $value == "ok" || $value == "False" )				//Status not ok == False -> Status = OK
				$value = "OK";
			return "<b><font color=green>".$value."</font></b>";
		}	
	}
	
	/*
	* @statusNotOk_SEC($value,$prValue)
	*
	* enum: ok, not_ok
	*/
	public function statusNotOk_SEC($value)
	{
		if( $value == "not_ok" )
		{
			if( $value == "not_ok" )
				$value = "Not OK";
			return "<b><font color=red>".$value."</font></b>";
		}
		else
		{
			if( $value == "ok" )				
				$value = "OK";
			return "<b><font color=green>".$value."</font></b>";
		}	
	}
	
	/*
	* @checkForCorrectValue($value,$setValue)
	*
	*/
	public function checkForCorrectValue($value,$setValue)
	{
		if( ! is_numeric( $value ) )
		{
			$value = $setValue;
		}
		return $value;
	}
	
	
	//Show Web
	/*
	* @getAndSubPositions($shape_id)
	*
	*/
	public function getAndSubPositions($shape_id,$movePosition)
	{
		//Check for this shape position
		$sql = "SELECT new_position
				FROM general_table_tp
				WHERE gentable_id = '".$shape_id."' ";
		$res = $this->excQuery( $sql );		
	
		$thisShapePosition = $res[0]['new_position'];
		echo " thisShapePosition: ".$thisShapePosition;
	
		if( is_numeric($thisShapePosition) && $thisShapePosition >= 0 )
		{
			//Bres kai kalipse to keno pou tha afisei
			$sql = "SELECT gentable_id,new_position
					FROM general_table_tp
					WHERE new_position > '".$thisShapePosition."'
					AND new_position <= '".$movePosition."'
					ORDER BY new_position";
			$res_pos = $this->excQuery( $sql );		
		
			for( $i=0; $i < count( $res_pos ); $i++ )		//Bres kai meivse kata ena ta position ton shapes poy einai katv apo to sigkekrimeno shape mas shape
			{
				//echo "<br>new_position:".$res_pos[$i]['new_position'];
				//echo "<br>gentable_id:".$res_pos[$i]['gentable_id'];
				$new_position = $res_pos[$i]['new_position'];
				$gentable_id  = $res_pos[$i]['gentable_id'];
			
				$new_position--;
				if( is_numeric( $new_position ) && $new_position >= 0 )
				{
					$sql = "UPDATE general_table_tp SET
								new_position = '".$new_position."'
							WHERE gentable_id = '".$gentable_id."'";
					//echo "<br>".$sql;		
					$res_sub = mysql_query( $sql ) or dir( mysql_error() );
				
				}
				
				else if( $new_position < 0 )
				{
					break;
				}
			
				
			}	//end of for
		}	
		
	}	//end of function
	
	/*
	* @getAndSubPositions_remove($shape_id)
	*
	*/
	public function getAndSubPositions_remove($shape_id)
	{
		//Check for this shape position
		$sql = "SELECT new_position
				FROM general_table_tp
				WHERE gentable_id = '".$shape_id."' ";
		$res = $this->excQuery( $sql );		
	
		$thisShapePosition = $res[0]['new_position'];
		echo " thisShapePosition: ".$thisShapePosition;
	
		if( is_numeric($thisShapePosition) && $thisShapePosition >= 0 )
		{
			//Bres kai kalipse to keno pou tha afisei
			$sql = "SELECT gentable_id,new_position
					FROM general_table_tp
					WHERE new_position > '".$thisShapePosition."'
					
					ORDER BY new_position";
			$res_pos = $this->excQuery( $sql );		
		
			for( $i=0; $i < count( $res_pos ); $i++ )		//Bres kai meivse kata ena ta position ton shapes poy einai katv apo to sigkekrimeno shape mas shape
			{
				//echo "<br>new_position:".$res_pos[$i]['new_position'];
				//echo "<br>gentable_id:".$res_pos[$i]['gentable_id'];
				$new_position = $res_pos[$i]['new_position'];
				$gentable_id  = $res_pos[$i]['gentable_id'];
			
				$new_position--;
				if( is_numeric( $new_position ) && $new_position >= 0 )
				{
					$sql = "UPDATE general_table_tp SET
								new_position = '".$new_position."'
							WHERE gentable_id = '".$gentable_id."'";
					//echo "<br>".$sql;		
					$res_sub = mysql_query( $sql ) or dir( mysql_error() );
				
				}
				
				else if( $new_position < 0 )
				{
					break;
				}
			
				
			}	//end of for
		}	
		
	}	//end of function
	
	/*
	* @removePosition($shape_id)
	*
	*/
	public function removePosition($shape_id)
	{
		if( is_numeric( $shape_id ) )
		{
			$sql = "UPDATE general_table_tp SET 
						new_position = '-1'
					WHERE gentable_id = '".$shape_id."'
					";
			$res = $this->excQueryInsUp($sql);
		}
	}
	
	/*
	* @getShapePosition($this_shape_id)
	*
	*/
	public function getShapePosition($shape_id)
	{
		if( is_numeric( $shape_id ) )
		{
			$sql = "SELECT new_position
					FROM general_table_tp
					WHERE gentable_id = '".$shape_id."' 
					";
			$row = $this->excQuery( $sql );		
			$position = $row[0]['new_position'];
			if( is_numeric($position) )
				return $position;
			else
				return false;	
		}
		else
			return false;
	}
	
	/*
	* @checkPositionForOtherShape($position)
	*
	*/
	public function checkPositionForOtherShape($position)
	{
		if( is_numeric($position) && $position >= 0 )
		{
			$sql = "SELECT gentable_id,new_position
					FROM general_table_tp 
					WHERE new_position = '$position' ";
			$row = $this->excQuery($sql);
			if( is_numeric( $row[0]['gentable_id'] ) )
				return true;
			else
				return false;	
		}
	}
	
	/*
	* @setShapeToPosition($this_shape_id, $movePosition)
	*
	*/
	public function setShapeToPosition($shape_id, $movePosition)
	{
		if( is_numeric( $shape_id ) && is_numeric($movePosition) && $movePosition >= 0 )
		{
			$sql = "UPDATE general_table_tp SET
						new_position = '".$movePosition."'
					WHERE gentable_id = '".$shape_id."' ";
			$res = $this->excQueryInsUp($sql);
			return $res;		
		}
	}
	
	/*
	* @getShapesWithBiggerPosition( $movePosition )
	*
	*/
	public function getShapesWithBiggerPosition( $movePosition )
	{
		if( is_numeric( $movePosition ) && $movePosition >= 0 )
		{
			$sql = "SELECT gentable_id, new_position
					FROM general_table_tp
					WHERE new_position >= '".$movePosition."' 
					ORDER BY new_position";
			$row = $this->excQuery( $sql );		
			return $row;
		}
	}
	
	/*
	* @addShapesPositions( $shapesPositions )
	*
	*/
	public function addShapesPositions( $shapesPositions )
	{
		if( count( $shapesPositions ) > 0 )
		{
			for( $i=0;$i<count($shapesPositions); $i++ )
			{
				$general_id = $shapesPositions[$i]['gentable_id'];
				$position   = $shapesPositions[$i]['new_position']; 
				$position++;
				
				$sql = "UPDATE general_table_tp SET 
							new_position = '".$position."'
						WHERE gentable_id = '".$general_id."' ";
				$res = $this->excQueryInsUp($sql);		
			}
		}
	}
	
	/*
	* @changeZeroNull( $value )
	*
	*/
	public function changeZeroNull( $value )
	{
		if( $value == 0 || $value == "0.0" )
		{
			$value = "";
			return $value;
		}
		else
			return $value;
	}
	
	/*
	* @changeZeroNull( $value )
	*
	*/
	public function changeNullZero($value)
	{
		if( !is_numeric( $value ) )
		{
			$value = 0;
		}
		return $value;
	}
	
	
	/*
	* @getAndPrintGroupTechniquesLike_PatternTechniques($group_id,$name)
	*
	* Βρίσκει και επιστρέφει σε μορφή table σε html 
	* τα techniques από τον πίνακα techniques4 και
	* τσεκάρει τα techniques που περιλαμβάνει το group $group_id
	* 
	* $group_id : Group ID
	* $name		: Name of <inpute type="checkbox" name=$name$Count id=$name$Count >
	* Proorizetai gia to neo Tpp
	*/
	public function getAndPrintGroupTechniquesLike_PatternTechniques($technique_id,$name)
	{
		if( isset( $group_id ) )
		{
			$response = "";
			$response .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
								<tr>
									<td width=\"14%\">";
										 
								  		$response .= "<table width=\"100%\" style=\"border:0px solid #0000CC; \">
					  									<tr style=\"font-size:10px; \">";
										$sql = "SELECT tbtech4_unique,tbtech4_code 
												FROM technique4
												WHERE tbtech4_unique = '".$technique_id."'
												ORDER BY sort_vant";
										$res_tchnique = mysql_query($sql) or die(mysql_error());		
			
										$bgcolColor = "#FFEDCA";
			
										While( $row_technique = mysql_fetch_array($res_tchnique) )
										{
											if( $bgcolColor == "#FFEDCA" )
												$bgcolColor = "#FFFFFF";
											else
												$bgcolColor = "#FFEDCA";	
			
											$response .= "<td bgcolor=\"".$bgcolColor."\">".$row_technique['tbtech4_code']."</td>";
										}
				
										$response .= "</tr>";	
										$response .= "<tr style=\"font-size:10px; \">";
											$sql = "SELECT tbtech4_unique,tbtech4_code 
													FROM technique4
													WHERE tbtech4_unique = '".$technique_id."'
													ORDER BY sort_vant";
											$res_tchnique = mysql_query($sql) or die(mysql_error());	
					
											$bgcolColor = "#FFEDCA";
											$countChBXTechnique = 0;
						
											While( $row_technique = mysql_fetch_array($res_tchnique) )
											{
												if( $bgcolColor == "#FFEDCA" )
													$bgcolColor = "#FFFFFF";
												else
													$bgcolColor = "#FFEDCA";	
				
												$response .= "<td bgcolor=\"".$bgcolColor."\">";
					
												$checked = "";
												$sqlChecked = "SELECT tbl_param_technic_shapes_group_link_technic_group_id,tbl_param_technic_shapes_group_link_technic_technic_id
															   FROM tbl_param_technic_shapes_group_link_technic 
															   WHERE tbl_param_technic_shapes_group_link_technic_group_id = '".$group_id."' 
															   AND tbl_param_technic_shapes_group_link_technic_technic_id = '".$row_technique['tbtech4_unique']."' ";
												$resChecked = mysql_query($sqlChecked) or die( mysql_error() );		
												if( @mysql_num_rows($resChecked) > 0 )	   
													$checked = "checked";
												else
													$checked = "";	
					
												$response .= "<input type=\"checkbox\" name=\"$name".$countChBXTechnique."\" id=\"$name".$countChBXTechnique."\" value=\"".$row_technique['tbtech4_unique']."\" ".$checked." onClick=\"init('".$name."".$countChBXTechnique."')\">";
												$response .= "</td>";
				
												$countChBXTechnique++;
											} //End of while
				
											$response .= "<input type=\"hidden\" name=\"$name\" id=\"$name\" value=\"".$countChBXTechnique."\">";
											$response .= "</tr>";
	  										$response .= "</table>";		
												
			$response .= "			</td>
									<td width=\"86%\" align=\"left\" valign=\"top\">
									  <table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                				        <tr>
					                          <td width=\"14%\" style=\"padding-left:7px;\">
											  		 <input type=\"button\" name=\"bttnEditGroup\" value=\"Edit this Group\" class=\"bttn_edit\" onClick=\"window.open('../../../../cp/shapes_version2/groups_of_shapes_techniques.php?group_id=".$group_id."&bttnSearch=Search','_blank')\">                            
											  </td>
                    					      <td width=\"17%\" align=\"center\">
											  		Number of Patterns <br>
											  		00
											  </td>
					                          <td width=\"69%\">
											  	Photos
												".$this->getPatternsFromTechques($technique_id)."
											  </td>
                    				    </tr>
				                      </table>
									</td>
								</tr>
							</table>";
			
			
	  
			return $response;
		}	//end of if
	}		//end of method
	
	
	/*
	* @getPatternsFromTechques($technique_id)
	*
	*/
	public function getPatternsFromTechques($technique_id)
	{
		$path = "../../../../ww/ion/img_finish/";
		if( is_numeric( $technique_id ) )
		{
			$sql = "SELECT *
					FROM Patterns
					WHERE tbtech4_unique = ".$technique_id."
					AND pattern_photo IS NOT NULL
					";
			$res = mysql_query($sql);
			if( $res )		
			{
				$result = "<div class=\"shapess_techniques_photos_patterns\">";	
				$i = 0;
				while( $row = mysql_fetch_array($res) )
				{
					$img = $path.$row['pattern_photo'];
					$img_300 = $path.$row['pattern_photo_300'];
					
					if( strlen($row['pattern_photo']) || strlen($row['pattern_photo_300'])  )
					{
						$result .= " <img src=\"".$img."\" width=\"50\" onMouseOver=\"show('div_styleShape_img300".$technique_id.$i."')\" onMouseOut=\"hidden('div_styleShape_img300".$technique_id.$i."')\">
						<div style=\"display:none; position:absolute; border:1px solid #000000; \" id=\"div_styleShape_img300".$technique_id.$i."\">
								<img src=\"".$img_300."\" width=\"200\" onMouseOut=\"hidden('div_styleShape_img300".$technique_id.$i."')\">
						</div>";
					}	
					//if( $i == "7" )
					//	$result .= "<br>";
					$i++;
				}
					
				$result .= "</div>";
				
				return $result;
			}
			//return $sql;
			
		}
	}
	
	
	/*
	* @getNumberOfPatternsInTechnique( $technique_id )
	*
	*/
	public function getNumberOfPatternsInTechnique( $technique_id )
	{
		if( is_numeric( $technique_id ) )
		{
			$sql = " SELECT COUNT(*) AS myCount 
					  FROM Patterns
					  WHERE tbtech4_unique = '".$technique_id."' ";
			$res = $this->excQuery( $sql );
			
			return $res[0]['myCount'];
		}
	} 
	
	
	/*
	* @isCheckedPatternsTechniques( $pattern_id,$technique_id )
	*
	*/
	public function isCheckedPatternsTechniques( $pattern_id,$technique_id )
	{
		if( is_numeric( $pattern_id ) )
		{
			$sql = "SELECT tbtech4_unique
					FROM Patterns 
					WHERE id = '".$pattern_id."' 
					AND tbtech4_unique = '".$technique_id."' ";
			$res = $this->excQuery( $sql );		
			if( count( $res ) > 0 )
				return "checked";
			else
				return "";	
		}
	}
	
	/*
	* @getNumberOfColorsInMatchingColor( $color_id )
	*
	*/
	public function getNumberOfColorsInMatchingColor( $team_id )
	{
		if( is_numeric( $team_id ) )
		{
			$sql = "SELECT count(*) AS myCount 
				 	FROM matching_colors
					WHERE team = '".$team_id."'  ";
			$res = $this->excQuery( $sql );		
			return $res[0]['myCount'];
		}
	}
	
	/*
	*
	*
	*/
	public function getPhotosFromRootColor( $team_id )
	{
		$path = "../../../../ww/ion/img_finish/";
		if( is_numeric( $team_id ) )
		{
			$sql = "SELECT matching_color,team,color_photo
					FROM matching_colors  MC
					LEFT JOIN prototype_colors PRC ON MC.matching_color = PRC.color_id
					WHERE team = '".$team_id."' ";
			$res = mysql_query($sql);
			if( $res )		
			{
				$result = "<div class=\"shapess_techniques_photos\">";	
				//$i = 0;
				while( $row = mysql_fetch_array($res) )
				{
					$img = $path.$row['color_photo'];
					//if( strlen($row['color_photo']) )
					//{
						$result .= " <img src=\"".$img."\" width=\"50\">";
					//}	
					//if( $i == "7" )
					//	$result .= "<br>";
					//$i++;
				}
					
				$result .= "</div>";
				
				return $result;
			}
		}
		
		
	}
	
	//****************Show Web Style****************************//
	/*
	* @checkPositionForOtherStyle($position)
	*
	*/
	public function checkPositionForOtherStyle($position)
	{
		if( is_numeric($position) && $position >= 0 )
		{
			$sql = "SELECT tb4_unique,new_position
					FROM kodikos_4 
					WHERE new_position = '$position' ";
			$row = $this->excQuery($sql);
			if( is_numeric( $row[0]['tb4_unique'] ) )
				return true;
			else
				return false;	
		}
	}
	
	/*
	* @getAndSubPositionsStyle($shape_id,$movePosition)
	*
	*/
	public function getAndSubPositionsStyle($style_id,$movePosition)
	{
		//Check for this shape position
		$sql = "SELECT new_position
				FROM kodikos_4
				WHERE tb4_unique = '".$style_id."' ";
		$res = $this->excQuery( $sql );		
	
		$thisStylePosition = $res[0]['new_position'];
		echo " thisStylePosition: ".$thisStylePosition;
	
		if( is_numeric($thisStylePosition) && $thisStylePosition >= 0 )
		{
			//Bres kai kalipse to keno pou tha afisei
			$sql = "SELECT tb4_unique,new_position
					FROM kodikos_4
					WHERE new_position > '".$thisStylePosition."'
					AND new_position <= '".$movePosition."'
					ORDER BY new_position";
			$res_pos = $this->excQuery( $sql );		
		
			for( $i=0; $i < count( $res_pos ); $i++ )		//Bres kai meivse kata ena ta position ton style poy einai katv apo to sigkekrimeno style mas 
			{
				//echo "<br>new_position:".$res_pos[$i]['new_position'];
				//echo "<br>gentable_id:".$res_pos[$i]['gentable_id'];
				$new_position = $res_pos[$i]['new_position'];
				$tb4_unique   = $res_pos[$i]['tb4_unique'];
			
				$new_position--;
				if( is_numeric( $new_position ) && $new_position >= 0 )
				{
					$sql = "UPDATE kodikos_4 SET
								new_position = '".$new_position."'
							WHERE tb4_unique = '".$tb4_unique."'";
					//echo "<br>".$sql;		
					$res_sub = mysql_query( $sql ) or dir( mysql_error() );
				
				}
				
				else if( $new_position < 0 )
				{
					break;
				}
			
				
			}	//end of for
		}	
		
	}	//end of function
	
	/*
	* @getAndSubPositionsStyle_remove($style_id)
	*
	*/
	public function getAndSubPositionsStyle_remove($style_id)
	{
		//Check for this shape position
		$sql = "SELECT new_position
				FROM kodikos_4
				WHERE tb4_unique = '".$style_id."' ";
		$res = $this->excQuery( $sql );		
	
		$thisStylePosition = $res[0]['new_position'];
		echo " thisStylePosition: ".$thisStylePosition;
	
		if( is_numeric($thisStylePosition) && $thisStylePosition >= 0 )
		{
			//Bres kai kalipse to keno pou tha afisei
			$sql = "SELECT tb4_unique,new_position
					FROM kodikos_4
					WHERE new_position > '".$thisStylePosition."'
					
					ORDER BY new_position";
			$res_pos = $this->excQuery( $sql );		
		
			for( $i=0; $i < count( $res_pos ); $i++ )		//Bres kai meivse kata ena ta position ton style poy einai katv apo to sigkekrimeno style mas 
			{
				//echo "<br>new_position:".$res_pos[$i]['new_position'];
				//echo "<br>gentable_id:".$res_pos[$i]['gentable_id'];
				$new_position = $res_pos[$i]['new_position'];
				$tb4_unique   = $res_pos[$i]['tb4_unique'];
			
				$new_position--;
				if( is_numeric( $new_position ) && $new_position >= 0 )
				{
					$sql = "UPDATE kodikos_4 SET
								new_position = '".$new_position."'
							WHERE tb4_unique = '".$tb4_unique."'";
					//echo "<br>".$sql;		
					$res_sub = mysql_query( $sql ) or dir( mysql_error() );
				
				}
				
				else if( $new_position < 0 )
				{
					break;
				}
			
				
			}	//end of for
		}	
		
	}	//end of function
	
	
	
	/*
	* @setStyleToPosition($this_shape_id, $movePosition)
	*
	*/
	public function setStyleToPosition($style_id, $movePosition)
	{
		if( is_numeric( $style_id ) && is_numeric($movePosition) && $movePosition >= 0 )
		{
			$sql = "UPDATE kodikos_4 SET
						new_position = '".$movePosition."'
					WHERE tb4_unique = '".$style_id."' ";
			$res = $this->excQueryInsUp($sql);
			return $res;		
		}
	}
	
	
	/*
	* @getStylePosition($this_shape_id)
	*
	*/
	public function getStylePosition($style_id)
	{
		if( is_numeric( $style_id ) )
		{
			$sql = "SELECT new_position
					FROM kodikos_4
					WHERE tb4_unique = '".$style_id."' 
					";
			$row = $this->excQuery( $sql );		
			$position = $row[0]['new_position'];
			if( is_numeric($position) )
				return $position;
			else
				return false;	
		}
		else
			return false;
	}
	
	
	/*
	* @getStylesWithBiggerPosition( $movePosition )
	*
	*/
	public function getStylesWithBiggerPosition( $movePosition )
	{
		if( is_numeric( $movePosition ) && $movePosition >= 0 )
		{
			$sql = "SELECT tb4_unique, new_position
					FROM kodikos_4
					WHERE new_position >= '".$movePosition."' 
					ORDER BY new_position";
			$row = $this->excQuery( $sql );		
			return $row;
		}
	}
	
	/*
	* @addStylePositions( $stylePositions )
	*
	*/
	public function addStylePositions( $stylePositions )
	{
		if( count( $stylePositions ) > 0 )
		{
			for( $i=0;$i<count($stylePositions); $i++ )
			{
				$tb4_unique = $stylePositions[$i]['tb4_unique'];
				$position   = $stylePositions[$i]['new_position']; 
				$position++;
				
				$sql = "UPDATE kodikos_4 SET 
							new_position = '".$position."'
						WHERE tb4_unique = '".$tb4_unique."' ";
				$res = $this->excQueryInsUp($sql);		
			}
		}
	}
	
	/*
	* @removePositionStyle( $style_id )
	*
	*/
	public function removePositionStyle( $style_id )
	{
		if( is_numeric( $style_id ) )
		{
			$sql = "UPDATE kodikos_4 SET 
						new_position = '-1'
					WHERE tb4_unique = '".$style_id."'
					";
			$res = $this->excQueryInsUp($sql);
		}
	}
	
	
	/*
	* @checkDate( $date )
	*
	*/
	public function checkDate( $date )
	{
		if( $date == "" || $date == " " )
			return "0000-00-00";
		else return $date;	
	}
	
	
	/*
	* @changeZeroDate( $date )
	*
	*/
	public function changeZeroDate( $date )
	{
		if( $date == "0000-00-00" )
			return "";
		else return $date;	
	}
	
	
	/*
	* @checkJoinColorToPattern( $pattern_id, $color_id )
	*
	*/
	public function checkJoinColorToPattern( $pattern_id, $color_id )
	{
		if( is_numeric( $pattern_id ) && is_numeric( $color_id ) )
		{
			$sql = "SELECT tbl_link_pattern_color_id 
					FROM tbl_link_pattern_color 
					WHERE tbl_link_pattern_color_pattern_id = '".$pattern_id."' 
					AND tbl_link_pattern_color_color_id = '".$color_id."' ";
			$res = $this->excQuery( $sql );		
			if( count($res) > 0 )
				return "checked";//$res[0]['tbl_link_pattern_color_id'];
			else
				return "";	
		}
	}
	
	
	/*
	* @getIDsFromLinkTable($tableName,$returnIDsFiledName,$whereIDField,$whereIDValue,$split)
	*
	*/
	public function getIDsFromLinkTable($tableName,$returnIDsFiledName,$whereIDField,$whereIDValue,$split)
	{
		if( is_numeric( $whereIDValue ) )
		{
			$sql = "SELECT $returnIDsFiledName
					FROM $tableName 
					WHERE $whereIDField = '".$whereIDValue."' ";
			$res = $this->excQuery($sql);
			
			$result = "";
			$koma = "";
			for( $i=0;$i<count($res);$i++ )
			{
				$result .= $koma.$res[$i][$returnIDsFiledName];
				$koma = $split;
			}
			
			return $result;
			
		}
		else
			return 0;	
				
	}
	
	/*
	* @getEmptyPatternsFromPatternHotelStyles()
	*
	*/
	public function getEmptyPatternsFromPatternHotelStyles()
	{
		$koma = "";
		$patternIDs = "";
		$sql = "SELECT P.id AS id 
				FROM Patterns P
				LEFT JOIN tbl_pattern_link_filters PF ON P.id = PF.tbl_pattern_link_filters_pattern_id
				WHERE tbl_pattern_link_filters_hstyle_id = '0' 
				
				";
		$res = $this->excQuery( $sql );		
		for( $i=0;$i<count($res);$i++ )
		{
			$patternIDs .= $koma.$res[$i]['id'];
			$koma = ",";
		}
		return $patternIDs;
	}
	
	
	/*
	* @printStyleSpec_SprayType( $tbl_ts_style_ts_style_id )
	*
	*/
	public function printStyleSpec_SprayType( $tbl_ts_style_ts_style_id, $tbl_ts_style_ts_spray_mode, $tbl_ts_style_ts_spray_pistol )
	{
		$result = "<table width=\"79%\" id=\"tblStyleSpray\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\" class=\"searchTable_prassino\">
            		<caption>
					  Spray
		            </caption>
        	    <tr>
				<td width=\"5%\">
					No
				</td>
              <td width=\"28%\">
			  	Root Color 
			  </td>
              <tD width=\"19%\">Side</td>
              <td width=\"13%\">Layers</td>
              <tD width=\"22%\">Glass</td>
			  <tD width=\"22%\">Spray Application</td>
			  <tD width=\"22%\">Spray Gun</td>
			  
            </tr>
			";
				
				if( !is_numeric( $tbl_ts_style_ts_style_id ) )
					$tbl_ts_style_ts_style_id = -1;
			
				$sql = "SELECT *
						FROM tbl_ts_style_link_spray LS
						LEFT JOIN tbl_ts_color_header CH ON LS.tbl_ts_style_link_spray_spray_id = CH.tbl_ts_color_header_item
						WHERE tbl_ts_style_link_spray_style_id = ".$tbl_ts_style_ts_style_id;
				$row_style_spray = $this->excQuery($sql);		
				
				for( $sprayCount = 0; $sprayCount<count( $row_style_spray ); $sprayCount++ )
				{
			
			
           			$result .=  "<tr>
						              <td>
									  	<a href=\"#\" onClick=\"openURLFromDropList('../color_add_edit/color_edit.php','color_id','style_spray_root_color".$sprayCount."','_blank')\">
											".($sprayCount+1)."
										</a>
									  </td>
									  <td>
									  	<input type=\"hidden\" name=\"style_spray_link_id".$sprayCount."\" id=\"style_spray_link_id".$sprayCount."\" value=\"".$row_style_spray[$sprayCount]['tbl_ts_style_link_spray_id']."\">
									   	<select name=\"style_spray_root_color".$sprayCount."\" id=\"style_spray_root_color".$sprayCount."\" style=\"width:85px; \" class=\"searchTable_inputs_freeWith\" onFocus=\"changeWidthWidth(this,'auto','85px')\" onBlur=\"changeWidthWidth(this,'auto','85px')\" onChange=\" getDescriptionInnerHTMLSomeDivSplit('../../../live_search/getSprayColorOtherParameters.php',this,'@spiter@','div_style_spray_side".$sprayCount.",div_style_spray_layer".$sprayCount.",div_style_spray_glass".$sprayCount.",div_style_sparay_spray_application".$sprayCount.",div_style_sparay_pistol".$sprayCount."'); \">
					                	  <option value=\"0\" class=\"selectValueBachground\" selected>select value</option>";
					  
					  						$color1 = "";
											$color2 = "#e0e0e0";
											$SelectedID = $row_style_spray[$sprayCount]['tbl_ts_style_link_spray_spray_id'];
											$result .=  $this->createOptionsWithTagRowColor("tbl_ts_color_id","tbl_ts_color_code",$SelectedID,"tbl_ts_color"," tbl_ts_color_inactive = 'False' AND tbl_ts_color_description LIKE 'ΣΠΡ%' ","tbl_ts_color_code","","tbl_ts_color_description",$color1,$color2);

					$result .= "	    </select>";
					$result .= "	 </td>
					             
			  		
              				  <td>
							  	<div id=\"div_style_spray_side".$sprayCount."\">";
					$result .= " <select name=\"style_spray_side".$sprayCount."\" id=\"style_spray_side".$sprayCount."\" style=\"width:65px; \" class=\"searchTable_inputs_freeWith\">
                	  <option value=\"0\" class=\"selectValueBachground\" selected>select value</option>";
					  
					  	$color1 = "";
						$color2 = "#e0e0e0";
						$SelectedID = $row_style_spray[$sprayCount]['tbl_ts_color_header_glass_side'];
						$result .= $this->createOptions("tbl_param_glass_side_id","tbl_param_glass_side_text",$SelectedID,"tbl_param_glass_side","","tbl_param_glass_side_text","");
					 
              				$result .= "</select>
						</div>
				
					  </td>";
              		$result .= "<td>
			  	<div id=\"div_style_spray_layer".$sprayCount."\">
			  	<select name=\"style_spray_layer".$sprayCount."\" id=\"style_spray_layer".$sprayCount."\" style=\"width:38px; \" class=\"searchTable_inputs_freeWith\">
                	  <option value=\"0\" class=\"selectValueBachground\" selected>select value</option>";
					  
					  	$color1 = "";
						$color2 = "#e0e0e0";
						$SelectedID = $row_style_spray[$sprayCount]['tbl_ts_color_header_layers'];
						$result .= $this->createOptions("tbl_param_layers_id","tbl_param_layers_text",$SelectedID,"tbl_param_layers","","tbl_param_layers_text","");
					
              	$result .= "	</select>
				</div>
			  </td>
              <td>
			  	<div id=\"div_style_spray_glass".$sprayCount."\">";
			  	$result .= "<select name=\"style_spray_glass".$sprayCount."\" id=\"style_spray_glass".$sprayCount."\" style=\"width:90px; \" class=\"searchTable_inputs_freeWith\">
                	  <option value=\"0\" class=\"selectValueBachground\" selected>select value</option>";
					  
					  	$color1 = "";
						$color2 = "#e0e0e0";
						$SelectedID = $row_style_spray[$sprayCount]['tbl_ts_color_header_glass_type'];
						$result .= $this->createOptions("tbl_param_glass_type_id","tbl_param_glass_type_text",$SelectedID,"tbl_param_glass_type","","tbl_param_glass_type_text","");
					 
              	$result .= "</select>
				</div>
			  </td>";
			
			$result .= "<td>";
				$result .= "<div id=\"div_style_sparay_spray_application".$sprayCount."\">";
				$result .= "<select name=\"style_sparay_application".$sprayCount."\" id=\"style_sparay_application".$sprayCount."\" class=\"searchTable_inputs_freeWith\" style=\"width:100px; \" onfocus=\"changeWidthWidth(this,'auto','100px')\" onblur=\"changeWidthWidth(this,'auto','100px')\">
                    	<option value=\"0\" class=\"selectValueBachground\" selected>select value</option>"; 
						
							$SeletedID = $row_style_spray[$sprayCount]['tbl_ts_color_header_spray_application_id'];
							$result .= $this->createOptions("tbl_param_spray_mode_id","tbl_param_spray_mode_text",$SeletedID,"tbl_param_spray_mode","","tbl_param_spray_mode_text","");
						
	                $result .= "</select>";
				$result .= "</div>";	
			$result .= "</td>";		
			
			$result .= "<td>";
			$result .= "<div id=\"div_style_sparay_pistol".$sprayCount."\">";
				$result .= "<select name=\"style_sparay_pistol".$sprayCount."\" id=\"style_sparay_pistol".$sprayCount."\" class=\"searchTable_inputs_freeWith\" style=\"width:140px; \" >
                    	<option value=\"0\" class=\"selectValueBachground\" selected>select value</option>";
						
							$SeletedID = $row_style_spray[$sprayCount]['tbl_ts_color_header_spray_gun_id'];
							$result .= $this->createOptions("tbl_param_spray_pistol_id","tbl_param_spray_pistol_text",$SeletedID,"tbl_param_spray_pistol","","tbl_param_spray_pistol_text","");
						
	                $result .= "</select>";
				$result .= "</div>";
			$result .= "</td>";
			
			
			$result .= "  
            </tr>";
			
				} //end of for  $sprayCount
			
			$result .= "<tr>
              
			  						<td>
									  	<a href=\"#\" onClick=\"openURLFromDropList('../color_add_edit/color_edit.php','color_id','style_spray_root_color".$sprayCount."','_blank')\">
											".($sprayCount+1)."
										</a>
									  </td>
			  <td>
			  	<input type=\"hidden\" name=\"style_spray_style_id\" value=\"".$tbl_ts_style_ts_style_id."\">
			  	<input type=\"hidden\" name=\"style_spray_table_counter\" id=\"style_spray_table_counter\" value=\"".$sprayCount."\">
			   	<select name=\"style_spray_root_color".$sprayCount."\" id=\"style_spray_root_color".$sprayCount."\" style=\"width:85px; \" class=\"searchTable_inputs_freeWith\" onFocus=\"changeWidthWidth(this,'auto','85px')\" onBlur=\"changeWidthWidth(this,'auto','85px')\" onChange=\" getDescriptionInnerHTMLSomeDivSplit('../../../live_search/getSprayColorOtherParameters.php',this,'@spiter@','div_style_spray_side".$sprayCount.",div_style_spray_layer".$sprayCount.",div_style_spray_glass".$sprayCount.",div_style_sparay_spray_application".$sprayCount.",div_style_sparay_pistol".$sprayCount."'); addNewRowsStyleSpray('tblStyleSpray','style_spray_table_counter','".$sprayCount."')\">
                	  <option value=\"0\" class=\"selectValueBachground\" selected>select value</option>";
					  
					  	$color1 = "";
						$color2 = "#e0e0e0";
						$SelectedID = $row_style_spray[$sprayCount]['tbl_ts_style_link_spray_spray_id'];
						$result .= $this->createOptionsWithTagRowColor("tbl_ts_color_id","tbl_ts_color_code",$SelectedID,"tbl_ts_color"," tbl_ts_color_inactive = 'False' AND tbl_ts_color_description LIKE 'ΣΠΡ%' ","tbl_ts_color_code","","tbl_ts_color_description",$color1,$color2);
					 
              	$result .= "</select>
				
			  </td>
              
              <td>
			  	<div id=\"div_style_spray_side".$sprayCount."\">
			  	<select name=\"style_spray_side".$sprayCount."\" id=\"style_spray_side".$sprayCount."\" style=\"width:65px; \" class=\"searchTable_inputs_freeWith\">
                	  <option value=\"0\" class=\"selectValueBachground\" selected>select value</option>";
					  
					  	$color1 = "";
						$color2 = "#e0e0e0";
						$SelectedID = $row_style_spray[$sprayCount]['tbl_ts_color_header_glass_side'];
						$result .= $this->createOptions("tbl_param_glass_side_id","tbl_param_glass_side_text",$SelectedID,"tbl_param_glass_side","","tbl_param_glass_side_text","");
					 
              	$result .= "</select>
				</div>
				
			  </td>
              <td>
			  	<div id=\"div_style_spray_layer".$sprayCount."\">
			  	<select name=\"style_spray_layer".$sprayCount."\" id=\"style_spray_layer".$sprayCount."\" style=\"width:38px; \" class=\"searchTable_inputs_freeWith\">
                	  <option value=\"0\" class=\"selectValueBachground\" selected>select value</option>";
					  
					  	$color1 = "";
						$color2 = "#e0e0e0";
						$SelectedID = $row_style_spray[$sprayCount]['tbl_ts_color_header_layers'];
						$result .= $this->createOptions("tbl_param_layers_id","tbl_param_layers_text",$SelectedID,"tbl_param_layers","","tbl_param_layers_text","");
					 
              	$result .= "</select>
				</div>
			  </td>
              <td>
			  	<div id=\"div_style_spray_glass".$sprayCount."\">
			  	<select name=\"style_spray_glass".$sprayCount."\" id=\"style_spray_glass".$sprayCount."\" style=\"width:90px; \" class=\"searchTable_inputs_freeWith\">
                	  <option value=\"0\" class=\"selectValueBachground\" selected>select value</option>";
					  
					  	$color1 = "";
						$color2 = "#e0e0e0";
						$SelectedID = $row_style_spray[$sprayCount]['tbl_ts_color_header_glass_type'];
						$result .= $this->createOptions("tbl_param_glass_type_id","tbl_param_glass_type_text",$SelectedID,"tbl_param_glass_type","","tbl_param_glass_type_text","");
					 
              	$result .= "</select>
				</div>
			  </td>";
			  
			  $result .= "<td>"; 
			$result .= "<div id=\"div_style_sparay_spray_application".$sprayCount."\">";
				$result .= "<select name=\"style_sparay_application".$sprayCount."\" id=\"style_sparay_application".$sprayCount."\" class=\"searchTable_inputs_freeWith\" style=\"width:100px; \" onfocus=\"changeWidthWidth(this,'auto','100px')\" onblur=\"changeWidthWidth(this,'auto','100px')\">
                    	<option value=\"0\" class=\"selectValueBachground\" selected>select value</option>"; 
						
							$SeletedID = $row_style_spray[$sprayCount]['tbl_ts_color_header_spray_application_id'];
							$result .= $this->createOptions("tbl_param_spray_mode_id","tbl_param_spray_mode_text",$SeletedID,"tbl_param_spray_mode","","tbl_param_spray_mode_text","");
						
	                $result .= "</select>";
				$result .= "</div>"; 	
			$result .= "</td>";		
			  
			  $result .= "<td>";
			$result .= "<div id=\"div_style_sparay_pistol".$sprayCount."\">";
				$result .= "<select name=\"style_sparay_pistol".$sprayCount."\" id=\"style_sparay_pistol".$sprayCount."\" class=\"searchTable_inputs_freeWith\" style=\"width:140px; \" >
                    	<option value=\"0\" class=\"selectValueBachground\" selected>select value</option>";
						
							$SeletedID = $row_style_spray[$sprayCount]['tbl_ts_color_header_spray_gun_id'];
							$result .= $this->createOptions("tbl_param_spray_pistol_id","tbl_param_spray_pistol_text",$SeletedID,"tbl_param_spray_pistol","","tbl_param_spray_pistol_text","");
						
	                $result .= "</select>";
				$result .= "</div>";
			$result .= "</td>";		
			
			
			  
            $result .= "</tr>
          </table>";
		  
		  $result .= "<p>&nbsp;</p>";
		  
		  
		  return $result;
	}
	
	
	/*
	* @printStyleSpec_SilkScreeningType( $tbl_ts_style_ts_style_id, $tbl_ts_style_ts_silk_mode, $tbl_ts_style_ts_silk_gauze, $tbl_ts_style_ts_silk_file )
	*
	*/
	public function printStyleSpec_SilkScreeningType( $tbl_ts_style_ts_style_id, $tbl_ts_style_ts_silk_mode, $tbl_ts_style_ts_silk_gauze, $tbl_ts_style_ts_silk_file )
	{
		$result = "<table width=\"35%\" style=\"width:35%;\" id=\"tblStyleSilk\"  border=\"1\" cellspacing=\"0\" cellpadding=\"0\" class=\"searchTable_prassino\">
		            <caption>
					  Silk Screening 
		            </caption>
            <tr>
			  <td width=\"5%\">No</td>
              <td width=\"18%\">Root Color </td>
              <tD width=\"11%\">Side</td>
              <td width=\"9%\">Layers</td>
              <tD width=\"12%\">Glass</td>
			  <tD width=\"12%\">Screen Type</td>
            </tr>";
            
				
				if( !is_numeric($tbl_ts_style_ts_style_id) )
					$tbl_ts_style_ts_style_id = -1;
					
				$sql = "SELECT *
						FROM tbl_ts_style_link_silkscreen LSILK
						LEFT JOIN tbl_ts_color_header CH ON LSILK.tbl_ts_style_link_silkscreen_silk_id = CH.tbl_ts_color_header_item
						WHERE tbl_ts_style_link_silkscreen_style_id = ".$tbl_ts_style_ts_style_id;
				//echo "$sql";		
				$row_style_spray = $this->excQuery($sql);		
				
				for( $sprayCount = 0; $sprayCount<count( $row_style_spray ); $sprayCount++ )
				{
					$result .=  "<tr>
					<td>
						 <a href=\"#\" onClick=\"openURLFromDropList('../color_add_edit/color_edit.php','color_id','style_silk_root_color".$sprayCount."','_blank')\">
							".($sprayCount+1)."
						</a>
					</td>
		              <td>
			  	<input type=\"hidden\" name=\"style_silk_link_id".$sprayCount."\" id=\"style_silk_link_id".$sprayCount."\" value=\"".$row_style_spray[$sprayCount]['tbl_ts_style_link_silkscreen_id']."\">
			   	<select name=\"style_silk_root_color".$sprayCount."\" id=\"style_silk_root_color".$sprayCount."\" style=\"width:150px; \" onFocus=\"changeWidthWidth(this,'auto','150px')\" onBlur=\"changeWidthWidth(this,'auto','150px')\" class=\"searchTable_inputs_freeWith\" onChange=\"getDescriptionInnerHTML('../../../live_search/getSprayColorDescription.php',this,'style_silk_root_color_desc".$sprayCount."'); getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/getSilkColorOtherParameters.php',this,'".$sprayCount."','@split@','div_style_silk_side".$sprayCount.",div_style_silk_layer".$sprayCount.",div_style_silk_glass".$sprayCount.",div_style_screen_gauze".$sprayCount."'); \">
                	  <option value=\"0\" class=\"selectValueBachground\" selected>select value</option>";
					  
					  	$color1 = "";
						$color2 = "#e0e0e0";
						$SelectedID = $row_style_spray[$sprayCount]['tbl_ts_style_link_silkscreen_silk_id'];
						$result .=  $this->createOptionsWithTagRowColor("tbl_ts_color_id","tbl_ts_color_code",$SelectedID,"tbl_ts_color"," tbl_ts_color_inactive = 'False' AND tbl_ts_color_description LIKE 'ΜΕΤΑΞ%' ","tbl_ts_color_code","","tbl_ts_color_description",$color1,$color2);
					 
              	$result .=  "</select>
			  </td>
              <td>
			  	<div id=\"div_style_silk_side".$sprayCount."\">
			  	<select name=\"style_silk_side".$sprayCount."\" id=\"style_silk_side".$sprayCount."\" style=\"width:50px; \" class=\"searchTable_inputs_freeWith\" disabled>
                	  <option value=\"0\" class=\"selectValueBachground\" selected>select value</option>";
					  
					  	$color1 = "";
						$color2 = "#e0e0e0";
						$SelectedID = $row_style_spray[$sprayCount]['tbl_ts_color_header_glass_side'];//tbl_ts_style_link_silkscreen_side
						$result .= $this->createOptions("tbl_param_glass_side_id","tbl_param_glass_side_text",$SelectedID,"tbl_param_glass_side","","tbl_param_glass_side_text","");
					 
              	$result .=  "</select>
				</div>
				
			  </td>
              <td>
			  	<div id=\"div_style_silk_layer".$sprayCount."\">
			  	<select name=\"style_silk_layer".$sprayCount."\" id=\"style_silk_layer".$sprayCount."\" style=\"width:35px; \" class=\"searchTable_inputs_freeWith\" disabled>
                	  <option value=\"0\" class=\"selectValueBachground\" selected>select value</option>";
					  
					  	$color1 = "";
						$color2 = "#e0e0e0";
						$SelectedID = $row_style_spray[$sprayCount]['tbl_ts_color_header_layers'];//tbl_ts_style_link_silkscreen_layers
						$result .=  $this->createOptions("tbl_param_layers_id","tbl_param_layers_text",$SelectedID,"tbl_param_layers","","tbl_param_layers_text","");
					 
              	$result .=  "</select>
				</div>
			  </td>
              <td>
			  	<div id=\"div_style_silk_glass".$sprayCount."\">
			  	<select name=\"style_silk_glass".$sprayCount."\" id=\"style_silk_glass".$sprayCount."\" style=\"width:115px; \" class=\"searchTable_inputs_freeWith\" disabled>
                	  <option value=\"0\" class=\"selectValueBachground\" selected>select value</option>";
					  
					  	$color1 = "";
						$color2 = "#e0e0e0";
						$SelectedID = $row_style_spray[$sprayCount]['tbl_ts_color_header_glass_type'];//tbl_ts_style_link_silkscreen_glass_type
						$result .= $this->createOptions("tbl_param_glass_type_id","tbl_param_glass_type_text",$SelectedID,"tbl_param_glass_type","","tbl_param_glass_type_text","");
					 
              	$result .=  "</select>
						</div>";
						
				$result .=  "<td>";		
				$result .=  "<div id=\"div_style_screen_gauze".$sprayCount."\">";
				$result .=  "<select name=\"style_screen_gauze".$sprayCount."\" id=\"style_screen_gauze".$sprayCount."\" class=\"searchTable_inputs_freeWith\" style=\"width:180px; \" disabled>
                    	<option value=\"0\" class=\"selectValueBachground\" selected>select value</option>";
						
							$SeletedID = $row_style_spray[$sprayCount]['tbl_ts_color_header_screen_type_id'];
							$result .= $this->createOptions("tbl_param_silk_gauze_id","tbl_param_silk_gauze_text",$SeletedID,"tbl_param_silk_gauze","","tbl_param_silk_gauze_text","");
						
	               $result .= " </select>";
				   $result .= "</div>";
						
				$result .=  "</td>
            		</tr>";
			
				} //end of for  $sprayCount
			
				$result .=  "<tr>
              			<td>
						 <a href=\"#\" onClick=\"openURLFromDropList('../color_add_edit/color_edit.php','color_id','style_silk_root_color".$sprayCount."','_blank')\">
							".($sprayCount+1)."
						</a>
					</td>
			  
			  <td>
			  	<input type=\"hidden\" name=\"style_silk_style_id\" value=\"".$tbl_ts_style_ts_style_id."\">
				<input type=\"hidden\" name=\"style_silk_table_counter\" id=\"style_silk_table_counter\" value=\"".$sprayCount."\">
			   	<select name=\"style_silk_root_color".$sprayCount."\" id=\"style_silk_root_color".$sprayCount."\" style=\"width:150px; \" onFocus=\"changeWidthWidth(this,'auto','150px')\" onBlur=\"changeWidthWidth(this,'auto','150px')\"  class=\"searchTable_inputs_freeWith\" onChange=\"getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/getSilkColorOtherParameters.php',this,'".$sprayCount."','@split@','div_style_silk_side".$sprayCount.",div_style_silk_layer".$sprayCount.",div_style_silk_glass".$sprayCount.",div_style_screen_gauze".$sprayCount."'); addNewRowsStyleSilk('tblStyleSilk','style_silk_table_counter','".$sprayCount."')\">
                	  <option value=\"0\" class=\"selectValueBachground\" selected>select value</option>";
					  
					  	$color1 = "";
						$color2 = "#e0e0e0";
						$SelectedID = $row_style_spray[$sprayCount]['tbl_ts_style_link_silkscreen_silk_id'];
						$result .= $this->createOptionsWithTagRowColor("tbl_ts_color_id","tbl_ts_color_code",$SelectedID,"tbl_ts_color"," tbl_ts_color_inactive = 'False' AND tbl_ts_color_description LIKE 'ΜΕΤΑΞ%' ","tbl_ts_color_code","","tbl_ts_color_description",$color1,$color2);
					 
              	$result .=  "</select>
				
				
			  </td>
              <td>
			  	<div id=\"div_style_silk_side".$sprayCount."\">
			  	<select name=\"style_silk_side".$sprayCount."\" id=\"style_silk_side".$sprayCount."\" style=\"width:50px; \" class=\"searchTable_inputs_freeWith\" disabled>
                	  <option value=\"0\" class=\"selectValueBachground\" selected>select value</option>";
					  
					  	$color1 = "";
						$color2 = "#e0e0e0";
						$SelectedID = $row_style_spray[$sprayCount]['tbl_ts_style_link_silkscreen_side'];
						$result .= $this->createOptions("tbl_param_glass_side_id","tbl_param_glass_side_text",$SelectedID,"tbl_param_glass_side","","tbl_param_glass_side_text","");
					 
              	$result .= "</select>
				</div>
				
			  </td>
              <td>
			  	<div id=\"div_style_silk_layer".$sprayCount."\">
			  	<select name=\"style_silk_layer".$sprayCount."\" id=\"style_silk_layer".$sprayCount."\" style=\"width:40px; \" class=\"searchTable_inputs_freeWith\" disabled>
                	  <option value=\"0\" class=\"selectValueBachground\" selected>select value</option>";
					  
					  	$color1 = "";
						$color2 = "#e0e0e0";
						$SelectedID = $row_style_spray[$sprayCount]['tbl_ts_style_link_silkscreen_layers'];
						$result .= $this->createOptions("tbl_param_layers_id","tbl_param_layers_text",$SelectedID,"tbl_param_layers","","tbl_param_layers_text","");
					 
              	$result .=  "</select>
				</div>
			  </td>
              <td>
			  	<div id=\"div_style_silk_glass".$sprayCount."\">
			  	<select name=\"style_silk_glass".$sprayCount."\" id=\"style_silk_glass".$sprayCount."\" style=\"width:115px; \" class=\"searchTable_inputs_freeWith\" disabled>
                	  <option value=\"0\" class=\"selectValueBachground\" selected>select value</option>";
					  
					  	$color1 = "";
						$color2 = "#e0e0e0";
						$SelectedID = $row_style_spray[$sprayCount]['tbl_ts_style_link_silkscreen_glass_type'];
						$result .= $this->createOptions("tbl_param_glass_type_id","tbl_param_glass_type_text",$SelectedID,"tbl_param_glass_type","","tbl_param_glass_type_text","");
					 
              	$result .=  "</select>
				</div>
			  </td>";
			  	
				$result .=  "<td>";		
				$result .=  "<div id=\"div_style_screen_gauze".$sprayCount."\">";
				$result .=  "<select name=\"style_screen_gauze".$sprayCount."\" id=\"style_screen_gauze".$sprayCount."\" class=\"searchTable_inputs_freeWith\" style=\"width:180px; \" disabled>
                    	<option value=\"0\" class=\"selectValueBachground\" selected>select value</option>";
						
							$SeletedID = $row_style_spray[$sprayCount]['tbl_ts_style_link_silkscreen_type'];
							$result .= $this->createOptions("tbl_param_silk_gauze_id","tbl_param_silk_gauze_text",$SeletedID,"tbl_param_silk_gauze","","tbl_param_silk_gauze_text","");
						
	               $result .= " </select>";
				   $result .= "</div>";
			  
             $result .= "</tr>
          </table>";
		  
		$result .= "<table width=\"71%\" cellpadding=\"0\" border=\"1\" cellspacing=\"0\" class=\"searchTable_prassino\">
              <tr>
                <th colspan=\"2\">&nbsp;</th>
              </tr>
              
              <tr>
                <td>Filing: </td>
                <td width=\"77%\">
					<input type=\"text\" name=\"style_filing\" id=\"style_filing\" class=\"searchTable_inputs_freeWith\" value=\"".$tbl_ts_style_ts_silk_file."\" onDblClick=\"window.open(this.value,'myWindowFiling')\">
					<input type=\"file\" name=\"style_filing_file\" id=\"style_filing_file\" class=\"bttn_browse\" value=\"test\" onChange=\"document.frRootStyleSpecs.style_filing.value = this.value\">
					
				</td>
              </tr>
            </table>";
		
		
		return $result;  
	}
	
	
	/*
	* @printStyleSpec_SilkScreeningType( $tbl_ts_style_ts_style_id )
	*
	*/
	public function printStyleSpec_WholeSurfaceType( $tbl_ts_style_ts_style_id, $tbl_ts_style_ts_whole_surface_com)
	{
		$result = "<table width=\"84%\" id=\"tblStylePowder\"  border=\"1\" cellspacing=\"0\" cellpadding=\"0\" class=\"searchTable_prassino\">
	                <caption>
					  Whole Surface
    	            </caption>
                <tr>
				  <td width=\"5%\">No</td>
                  <td width=\"25%\">Root Color </td>
                  <tD width=\"17%\">Side</td>
                  <td width=\"10%\">Layers</td>
                  <tD width=\"24%\">Glass</td>
                </tr>";
                
				
				if( !is_numeric($tbl_ts_style_ts_style_id) )
					$tbl_ts_style_ts_style_id = -1;
						
				$sql = "SELECT *
						FROM tbl_ts_style_link_powder LP
						LEFT JOIN tbl_ts_color_header CH ON LP.tbl_ts_style_link_powder_powder_id = CH.tbl_ts_color_header_item
						WHERE tbl_ts_style_link_powder_style_id = ".$tbl_ts_style_ts_style_id;
				$row_style_spray = $this->excQuery($sql);		
				
				for( $sprayCount = 0; $sprayCount<count( $row_style_spray ); $sprayCount++ )
				{
			
            		$result .= "<tr>
						<td>
							".($sprayCount+1)."
							
						</td>
              				<td>
					  	<input type=\"hidden\" name=\"style_powder_link_id".$sprayCount."\" id=\"style_powder_link_id".$sprayCount."\" value=\"".$row_style_spray[$sprayCount]['tbl_ts_style_link_powder_id']."\">
			   	<select name=\"style_powder_root_color".$sprayCount."\" id=\"style_powder_root_color".$sprayCount."\" style=\"width:120px; \" class=\"searchTable_inputs_freeWith\" onFocus=\"changeWidthWidth(this,'auto','120px')\" onBlur=\"changeWidthWidth(this,'auto','120px')\" onChange=\"getDescriptionInnerHTMLSomeDivSplit('../../../live_search/getPowderColorOtherParameters2.php',this,'div_style_powder_side".$sprayCount.",div_style_powder_layer".$sprayCount.",div_style_powder_glass".$sprayCount."'); \">
                	  <option value=\"0\" class=\"selectValueBachground\" selected>select value</option>";
					  
					  	$color1 = "";
						$color2 = "#e0e0e0";
						$SelectedID = $row_style_spray[$sprayCount]['tbl_ts_style_link_powder_powder_id'];
						$result .= $this->createOptionsWithTagRowColor("tbl_ts_original_color_id","tbl_ts_original_color_code",$SelectedID,"tbl_ts_original_color"," tbl_ts_original_color_inactive = 'False' ","tbl_ts_original_color_code","","tbl_ts_original_color_description",$color1,$color2);
					 
              	$result .= "</select>
			  </td>
               <td>
			  	<div id=\"div_style_powder_side".$sprayCount."\">
			  	<select name=\"style_powder_side".$sprayCount."\" id=\"style_powder_side".$sprayCount."\" style=\"width:75px; \" class=\"searchTable_inputs_freeWith\" >
                	  <option value=\"0\" class=\"selectValueBachground\" selected>select value</option>";
					  
					  	$color1 = "";
						$color2 = "#e0e0e0";
						$SelectedID = $row_style_spray[$sprayCount]['tbl_ts_style_link_powder_side'];
						$result .= $this->createOptions("tbl_param_glass_side_id","tbl_param_glass_side_text",$SelectedID,"tbl_param_glass_side","","tbl_param_glass_side_text","");
					 
              	$result .= "</select>
				</div>
				
			  </td>
              <td>
			  	<div id=\"div_style_powder_layer".$sprayCount."\">
			  	<select name=\"style_powder_layer".$sprayCount."\" id=\"style_powder_layer".$sprayCount."\" style=\"width:40px; \" class=\"searchTable_inputs_freeWith\" >
                	  <option value=\"0\" class=\"selectValueBachground\" selected>select value</option>";
					  
					  	$color1 = "";
						$color2 = "#e0e0e0";
						$SelectedID = $row_style_spray[$sprayCount]['tbl_ts_style_link_powder_layers'];
						$result .= $this->createOptions("tbl_param_layers_id","tbl_param_layers_text",$SelectedID,"tbl_param_layers","","tbl_param_layers_text","");
					 
              	$result .= "</select>
				</div>
			  </td>
              <td>
			  	<div id=\"div_style_powder_glass".$sprayCount."\">
			  	<select name=\"style_powder_glass".$sprayCount."\" id=\"style_powder_glass".$sprayCount."\" style=\"width:100px; \" class=\"searchTable_inputs_freeWith\" >
                	  <option value=\"0\" class=\"selectValueBachground\" selected>select value</option>";
					  
					  	$color1 = "";
						$color2 = "#e0e0e0";
						$SelectedID = $row_style_spray[$sprayCount]['tbl_ts_style_link_powder_glass_type'];
						$result .= $this->createOptions("tbl_param_glass_color_id","tbl_param_glass_color_text",$SelectedID,"tbl_param_glass_color","","tbl_param_glass_color_text","");
					 
              	$result .= "</select>
				</div>
			  </td>
            </tr>";
			
				} //end of for  $sprayCount
			
			$result .= "<tr>
              
			  			<td>
							".($sprayCount+1)."
						</td>
			  <td>
			  	<input type=\"hidden\" name=\"style_powder_style_id\" id=\"style_powder_style_id\" value=\"".$tbl_ts_style_ts_style_id."\">
				<input type=\"hidden\" name=\"style_powder_table_counter\" id=\"style_powder_table_counter\" value=\"".$sprayCount."\">
			   	<select name=\"style_powder_root_color".$sprayCount."\" id=\"style_powder_root_color".$sprayCount."\" style=\"width:120px; \" class=\"searchTable_inputs_freeWith\" onFocus=\"changeWidthWidth(this,'auto','120px')\" onBlur=\"changeWidthWidth(this,'auto','120px')\" onChange=\"getDescriptionInnerHTMLSomeDivWithCountSplit('../../../live_search/getPowderColorOtherParameters2.php',this,'".$sprayCount."','#mysplit#','div_style_powder_side".$sprayCount.",div_style_powder_layer".$sprayCount.",div_style_powder_glass".$sprayCount."'); addNewRowsStylePowder('tblStylePowder','style_powder_table_counter','".$sprayCount."')\">
                	  <option value=\"0\" class=\"selectValueBachground\" selected>select value</option>";
					  
					  	$color1 = "";
						$color2 = "#e0e0e0";
						$SelectedID = $row_style_spray[$sprayCount]['tbl_ts_style_link_powder_powder_id'];
						$result .= $this->createOptionsWithTagRowColor("tbl_ts_original_color_id","tbl_ts_original_color_code",$SelectedID,"tbl_ts_original_color"," tbl_ts_original_color_inactive = 'False' ","tbl_ts_original_color_code","","tbl_ts_original_color_description",$color1,$color2);
					 
              	$result .= "</select>
				
			  </td>
               <td>
			  	<div id=\"div_style_powder_side".$sprayCount."\">
			  	<select name=\"style_powder_side".$sprayCount."\" id=\"style_powder_side".$sprayCount."\" style=\"width:75px; \" class=\"searchTable_inputs_freeWith\" >
                	  <option value=\"0\" class=\"selectValueBachground\" selected>select value</option>";
					  
					  	$color1 = "";
						$color2 = "#e0e0e0";
						$SelectedID = $row_style_spray[$sprayCount]['tbl_ts_style_link_powder_side'];
						$result .= $this->createOptions("tbl_param_glass_side_id","tbl_param_glass_side_text",$SelectedID,"tbl_param_glass_side","","tbl_param_glass_side_text","");
					 
              	$result .= "</select>
				</div>
				
			  </td>
              <td>
			  	<div id=\"div_style_powder_layer".$sprayCount."\">
			  	<select name=\"style_powder_layer".$sprayCount."\" id=\"style_powder_layer".$sprayCount."\" style=\"width:40px; \" class=\"searchTable_inputs_freeWith\" >
                	  <option value=\"0\" class=\"selectValueBachground\" selected>select value</option>";
					  
					  	$color1 = "";
						$color2 = "#e0e0e0";
						$SelectedID = $row_style_spray[$sprayCount]['tbl_ts_style_link_powder_layers'];
						$result .= $this->createOptions("tbl_param_layers_id","tbl_param_layers_text",$SelectedID,"tbl_param_layers","","tbl_param_layers_text","");
					 
              	$result .= "</select>
				</div>
			  </td>
              <td>
			  	<div id=\"div_style_powder_glass".$sprayCount."\">
			  	<select name=\"style_powder_glass".$sprayCount."\" id=\"style_powder_glass".$sprayCount."\" style=\"width:100px; \" class=\"searchTable_inputs_freeWith\" >
                	  <option value=\"0\" class=\"selectValueBachground\" selected>select value</option>";
					  
					  	$color1 = "";
						$color2 = "#e0e0e0";
						$SelectedID = $row_style_spray[$sprayCount]['tbl_ts_style_link_powder_glass_type'];
						$result .= $this->createOptions("tbl_param_glass_color_id","tbl_param_glass_color_text",$SelectedID,"tbl_param_glass_color","","tbl_param_glass_color_text","");
					 
              	$result .= "</select>
				</div>
			  </td>
            </tr>
              </table>";
			  
			$result .= "<table width=\"84%\" cellpadding=\"0\" cellspacing=\"0\" border=\"1\" class=\"searchTable_prassino\">
                  <tr>
                    <td style=\"text-align:left; padding-left:5px; \">Comments</td>
                  </tr>
                  <tr>
                    <td>
                      <textarea class=\"searchTable_inputs_comment_action\" name=\"whole_surface_comments\" id=\"whole_surface_comments\" style=\" width:450px; \">".$tbl_ts_style_ts_whole_surface_com."</textarea>
                    </td>
                  </tr>
                  </table>
					<br>		";  
		
		
		
		return $result;  
	}
	
	
	
	/*
	* @colorProductionMethodIsChecked( $colorID, $productionMethodID )
	*
	* Eidiki sunartisi gia ta root colors specs
	*/
	public function colorProductionMethodIsChecked( $colorID, $productionMethodID )
	{
		if( is_numeric( $colorID ) )
		{
			$sql = "SELECT * 
					FROM tbl_ts_mixture_header CH
					JOIN tbl_ts_cpm_detail CPM ON CH.tbl_ts_mixture_header_id = CPM.tbl_ts_cpm_detail_mixture_header_id
					WHERE tbl_ts_mixture_header_root_color_id = ".$colorID."
					AND tbl_ts_cpm_detail_cpm_id = '".$productionMethodID."'
					";
			$res = $this->excQuery( $sql );		
			if( count($res) > 0 )	//Prepei na tsekaristei to checkbox
				return true;
			else 					//Den prepei na tsekaristei to checkbox
				return false;	
			
		}
		else 
			return false;
	}
	
	
	/*
	* @colorProductionMethodIsChecked( $colorID, $productionMethodID )
	*
	* Eidiki sunartisi gia ta root colors specs
	*/
	public function colorProductionMethodIsChecked_vOld( $colorID, $productionMethodID )
	{
		if( is_numeric( $colorID ) )
		{
			$sql = "SELECT * 
					FROM tbl_ts_color_header CH
					INNER JOIN tbl_ts_color CT ON CH.tbl_ts_color_header_item = CT.tbl_ts_color_id
					WHERE tbl_ts_color_header_prot_color_id = ".$colorID."
					AND tbl_ts_color_header_prod_method_id = '".$productionMethodID."'
					";
			$res = $this->excQuery( $sql );		
			if( count($res) > 0 )	//Prepei na tsekaristei to checkbox
				return true;
			else 					//Den prepei na tsekaristei to checkbox
				return false;	
			
		}
		else 
			return false;
	}
	
	
	
	/*
	* @getStylePriceTypePrices( $price_type_id )
	*
	* 
	*/
	public function getStylePriceTypePrices( $price_type_id )
	{
		if( is_numeric( $price_type_id ) )
		{
			$sql = "SELECT tbl_search_style_price_tag 
					FROM tbl_search_style_price
					WHERE tbl_search_style_price_id = '".$price_type_id."' ";
			$res = $this->excQuery( $sql );		
			$prices = array();
			$prices = explode("-",$res[0]['tbl_search_style_price_tag']);
			
			return $prices;
		}
	}
	
	
	
	
	//------------------------------------------------------------------------------------------------------------------------------
	/*
	* @tairiazeiToUseMeSection( $sectionID,$useID )
	*
	*/
	public function tairiazeiToUseMeSection( $sectionID,$useID )
	{
		if( is_numeric($sectionID) && is_numeric($useID) )
		{
			$sql = "SELECT shape_link_section_use_id
								FROM filter_shapes_link_section_use
								WHERE shape_link_section_use_section_id = '".$sectionID."' 
								AND shape_link_section_use_use_id = '".$useID."' ";
			$res_lSectionUse = $this->excQuery($sql);
			if( count($res_lSectionUse) > 0 ) 
				return true;
			else if( count($res_lSectionUse) == 0 ) 
				return false;	
		}
		else 
			return false;
	}
	
	/*
	* @kataxvriseToUseSeNeaGrammi( $new_use_id,$shape_id )
	*
	*/
	public function insertToUseSeNeaGrammi( $new_use_id,$shape_id )
	{
		if( is_numeric($new_use_id) && is_numeric($shape_id) )
		{
			$sql = "INSERT INTO filter_shapes_link
					(filter_shape_link_use_id,filter_shape_link_shape_id)
					VALUES
					( '".$new_use_id."','".$shape_id."' )";
			$res = $this->excQueryInsUp($sql);		
			return $res;		
		}
	}
	
	
	public function updateToUseSeAutinTinGrammi( $new_use_id, $link_id )
	{
		if( is_numeric($new_use_id) && is_numeric($link_id) )
		{
			$sql = "UPDATE filter_shapes_link SET
						filter_shape_link_use_id = '".$new_use_id."'
					WHERE filter_shape_link_id = '".$link_id."'	
					";
			$res = $this->excQueryInsUp($sql);		
			return $res;				
		}
	}	
	
	public function tairiazeiToTypeMeUse( $new_use_id,$type_id)
	{
		if( is_numeric($new_use_id) && is_numeric($type_id) )
		{
			$sql = "SELECT shape_link_type_use_id
									FROM filter_shapes_link_type_use
									WHERE shape_link_type_use_type_id = '".$type_id."' 
									AND shape_link_type_use_use_id = '".$new_use_id."' ";
			$res_lTypeUse = $this->excQuery($sql);
			if( count($res_lTypeUse) > 0 )	//Tairiazei to Type me to USE
				return true;
			else 
				return false;	
		}
		else
			return false;
	}
	
	
	
	public function tairiazeiToPlaceMeToUse( $new_use_id,$place_id )
	{
		if( is_numeric($new_use_id) && is_numeric($place_id) )
		{
			$sql = "SELECT shape_link_place_use_id
						FROM filter_shapes_link_place_use
						WHERE shape_link_place_use_place_id = '".$place_id."' 
						AND shape_link_place_use_use_id = '".$new_use_id."' ";
			$res_lPlaceUse = $this->excQuery( $sql );
			if( count($res_lPlaceUse) > 0 )
				return true;
			else
				return false;	
		}
		else
			return false;
	}
	
	
	
	/**********Overview Show Web *********************** */
	/*
	* @getOverviewPosition($this_shape_id)
	*
	*/
	public function getOverviewPosition($overview_id)
	{
		if( is_numeric( $overview_id ) )
		{
			$sql = "SELECT new_position
					FROM overview
					WHERE ID = '".$overview_id."' 
					";
			$row = $this->excQuery( $sql );		
			$position = $row[0]['new_position'];
			if( is_numeric($position) )
				return $position;
			else
				return false;	
		}
		else
			return false;
	}
	
	
	/*
	* @getAndSubOverviewPositions($shape_id)
	*
	*/
	public function getAndSubOverviewPositions($overview_id,$movePosition)
	{
		//Check for this shape position
		$sql = "SELECT new_position
				FROM overview
				WHERE ID = '".$overview_id."' ";
		$res = $this->excQuery( $sql );		
	
		$thisShapePosition = $res[0]['new_position'];
		echo " thisShapePosition: ".$thisShapePosition;
	
		if( is_numeric($thisShapePosition) && $thisShapePosition >= 0 )
		{
			//Bres kai kalipse to keno pou tha afisei
			$sql = "SELECT ID,new_position
					FROM overview
					WHERE new_position > '".$thisShapePosition."'
					AND new_position <= '".$movePosition."'
					ORDER BY new_position";
			$res_pos = $this->excQuery( $sql );		
		
			for( $i=0; $i < count( $res_pos ); $i++ )		//Bres kai meivse kata ena ta position ton shapes poy einai katv apo to sigkekrimeno shape mas shape
			{
				//echo "<br>new_position:".$res_pos[$i]['new_position'];
				//echo "<br>gentable_id:".$res_pos[$i]['gentable_id'];
				$new_position = $res_pos[$i]['new_position'];
				$gentable_id  = $res_pos[$i]['ID'];
			
				$new_position--;
				if( is_numeric( $new_position ) && $new_position >= 0 )
				{
					$sql = "UPDATE overview SET
								new_position = '".$new_position."'
							WHERE ID = '".$gentable_id."'";
					//echo "<br>".$sql;		
					$res_sub = mysql_query( $sql ) or dir( mysql_error() );
				
				}
				
				else if( $new_position < 0 )
				{
					break;
				}
			
				
			}	//end of for
		}	
		
	}	//end of function
	
	
	/*
	* @getOverviewWithBiggerPosition( $movePosition )
	*
	*/
	public function getOverviewWithBiggerPosition( $movePosition )
	{
		if( is_numeric( $movePosition ) && $movePosition >= 0 )
		{
			$sql = "SELECT ID, new_position
					FROM overview
					WHERE new_position >= '".$movePosition."' 
					ORDER BY new_position";
			$row = $this->excQuery( $sql );		
			return $row;
		}
	}
	
	
	/*
	* @setOverviewToPosition($this_shape_id, $movePosition)
	*
	*/
	public function setOverviewToPosition($overview_id, $movePosition)
	{
		if( is_numeric( $overview_id ) && is_numeric($movePosition) && $movePosition >= 0 )
		{
			$sql = "UPDATE overview SET
						new_position = '".$movePosition."'
					WHERE ID = '".$overview_id."' ";
			$res = $this->excQueryInsUp($sql);
			return $res;		
		}
	}
	
	
	/*
	* @addOverviewPositions( $shapesPositions )
	*
	*/
	public function addOverviewPositions( $overviewPositions )
	{
		if( count( $overviewPositions ) > 0 )
		{
			for( $i=0;$i<count($overviewPositions); $i++ )
			{
				$ovID = $overviewPositions[$i]['ID'];
				$position   = $overviewPositions[$i]['new_position']; 
				$position++;
				
				$sql = "UPDATE overview SET 
							new_position = '".$position."'
						WHERE ID = '".$ovID."' ";
				$res = $this->excQueryInsUp($sql);		
			}
		}
	}
	
	
	/*
	* @getAndSubOverviewPositions_remove($overview_id)
	*
	*/
	public function getAndSubOverviewPositions_remove($overview_id)
	{
		//Check for this shape position
		$sql = "SELECT new_position
				FROM overview
				WHERE ID = '".$overview_id."' ";
		$res = $this->excQuery( $sql );		
	
		$thisShapePosition = $res[0]['new_position'];
		echo " thisShapePosition: ".$thisShapePosition;
	
		if( is_numeric($thisShapePosition) && $thisShapePosition >= 0 )
		{
			//Bres kai kalipse to keno pou tha afisei
			$sql = "SELECT ID,new_position
					FROM overview
					WHERE new_position > '".$thisShapePosition."'
					
					ORDER BY new_position";
			$res_pos = $this->excQuery( $sql );		
		
			for( $i=0; $i < count( $res_pos ); $i++ )		//Bres kai meivse kata ena ta position ton shapes poy einai katv apo to sigkekrimeno shape mas shape
			{
				//echo "<br>new_position:".$res_pos[$i]['new_position'];
				//echo "<br>gentable_id:".$res_pos[$i]['gentable_id'];
				$new_position = $res_pos[$i]['new_position'];
				$gentable_id  = $res_pos[$i]['ID'];
			
				$new_position--;
				if( is_numeric( $new_position ) && $new_position >= 0 )
				{
					$sql = "UPDATE overview SET
								new_position = '".$new_position."'
							WHERE ID = '".$gentable_id."'";
					$results .= "<br>".$sql;		
					$res_sub = mysql_query( $sql ) or dir( mysql_error() );
				
				}
				
				else if( $new_position < 0 )
				{
					break;
				}
			
				
			}	//end of for
			//return $results;
		}	
		
	}	//end of function
	
	
	/*
	* @removeOverviewPosition($overview_id)
	*
	*/
	public function removeOverviewPosition($overview_id)
	{
		if( is_numeric( $overview_id ) )
		{
			$sql = "UPDATE overview SET 
						new_position = '-1'
					WHERE ID = '".$overview_id."'
					";
			$res = $this->excQueryInsUp($sql);
		}
	}
	
	
	
	
	/*
	* @checkValueReplaceKoma($value,$setValue)
	*
	*/
	public function checkValueReplaceKoma($value, $setValue)
	{
		if( strlen( $value ) )
		{
			$value = str_replace(",",".",$value);
			if( ! is_numeric( $value ) )
				return $setValue;
			else
				return $value;	
			
		}
		else
			return $setValue;
	
	}
	
	/*
	* @checkValueReplaceKoma($value,$setValue)
	*
	*/
	public function checkValueReplaceKomaDekadiko($value, $setValue)
	{
		if( strlen( $value ) )
		{
			$value = str_replace(",","",$value);
			if( ! is_numeric( $value ) )
				return $setValue;
			else
				return $value;	
			
		}
		else
			return $setValue;
	
	}
	
	
	
	/**********Set Ups Show Web *********************** */
	/*
	* @getSetUpsPosition($this_shape_id)
	*
	*/
	public function getSetUpsPosition($set_ups_id)
	{
		if( is_numeric( $set_ups_id ) )
		{
			$sql = "SELECT position
					FROM set_ups
					WHERE ID = '".$set_ups_id."' 
					";
			$row = $this->excQuery( $sql );		
			$position = $row[0]['position'];
			if( is_numeric($position) )
				return $position;
			else
				return false;	
		}
		else
			return false;
	}
	
	
	/*
	* @getAndSubSetUpsPositions($shape_id)
	*
	*/
	public function getAndSubSetUpsPositions($setup_id,$movePosition)
	{
		//Check for this shape position
		$sql = "SELECT position
				FROM set_ups
				WHERE ID = '".$setup_id."' ";
		$res = $this->excQuery( $sql );		
	
		$thisShapePosition = $res[0]['position'];
		echo " thisShapePosition: ".$thisShapePosition;
	
		if( is_numeric($thisShapePosition) && $thisShapePosition >= 0 )
		{
			//Bres kai kalipse to keno pou tha afisei
			$sql = "SELECT ID,position
					FROM set_ups
					WHERE position > '".$thisShapePosition."'
					AND position <= '".$movePosition."'
					ORDER BY position";
			$res_pos = $this->excQuery( $sql );		
		
			for( $i=0; $i < count( $res_pos ); $i++ )		//Bres kai meivse kata ena ta position ton shapes poy einai katv apo to sigkekrimeno shape mas shape
			{
				//echo "<br>new_position:".$res_pos[$i]['new_position'];
				//echo "<br>gentable_id:".$res_pos[$i]['gentable_id'];
				$new_position = $res_pos[$i]['position'];
				$gentable_id  = $res_pos[$i]['ID'];
			
				$new_position--;
				if( is_numeric( $new_position ) && $new_position >= 0 )
				{
					$sql = "UPDATE set_ups SET
								position = '".$new_position."'
							WHERE ID = '".$gentable_id."'";
					//echo "<br>".$sql;		
					$res_sub = mysql_query( $sql ) or dir( mysql_error() );
				
				}
				
				else if( $new_position < 0 )
				{
					break;
				}
			
				
			}	//end of for
		}	
		
	}	//end of function
	
	
	/*
	* @getSetUpsWithBiggerPosition( $movePosition )
	*
	*/
	public function getSetUpsWithBiggerPosition( $movePosition )
	{
		if( is_numeric( $movePosition ) && $movePosition >= 0 )
		{
			$sql = "SELECT ID, position
					FROM set_ups
					WHERE position >= '".$movePosition."' 
					ORDER BY position";
			$row = $this->excQuery( $sql );		
			return $row;
		}
	}
	
	
	/*
	* @setSetUpToPosition($this_shape_id, $movePosition)
	*
	*/
	public function setSetUpToPosition($setup_id, $movePosition)
	{
		if( is_numeric( $setup_id ) && is_numeric($movePosition) && $movePosition >= 0 )
		{
			$sql = "UPDATE set_ups SET
						position = '".$movePosition."'
					WHERE ID = '".$setup_id."' ";
			$res = $this->excQueryInsUp($sql);
			return $res;		
		}
	}
	
	
	/*
	* @addSetUpPositions( $shapesPositions )
	*
	*/
	public function addSetUpPositions( $setUpPositions )
	{
		if( count( $setUpPositions ) > 0 )
		{
			for( $i=0;$i<count($setUpPositions); $i++ )
			{
				$ovID = $setUpPositions[$i]['ID'];
				$position   = $setUpPositions[$i]['position']; 
				$position++;
				
				$sql = "UPDATE set_ups SET 
							position = '".$position."'
						WHERE ID = '".$ovID."' ";
				$res = $this->excQueryInsUp($sql);		
			}
		}
	}
	
	
	/*
	* @checkPositionForOtherSetUp($position)
	*
	*/
	public function checkPositionForOtherSetUp($position)
	{
		if( is_numeric($position) && $position >= 0 )
		{
			$sql = "SELECT ID,position
					FROM set_ups 
					WHERE position = '$position' ";
			$row = $this->excQuery($sql);
			if( is_numeric( $row[0]['ID'] ) )
				return true;
			else
				return false;	
		}
	}
	
	
	
	/*
	* @getAndSubOverviewPositions_remove($overview_id)
	*
	*/
	public function getAndSubSetUpsPositions_remove($overview_id)
	{
		//Check for this shape position
		$sql = "SELECT position
				FROM set_ups
				WHERE ID = '".$overview_id."' ";
		$res = $this->excQuery( $sql );		
	
		$thisShapePosition = $res[0]['position'];
		echo " thisShapePosition: ".$thisShapePosition;
	
		if( is_numeric($thisShapePosition) && $thisShapePosition >= 0 )
		{
			//Bres kai kalipse to keno pou tha afisei
			$sql = "SELECT ID,position
					FROM set_ups
					WHERE position > '".$thisShapePosition."'
					
					ORDER BY position";
			$res_pos = $this->excQuery( $sql );		
		
			for( $i=0; $i < count( $res_pos ); $i++ )		//Bres kai meivse kata ena ta position ton shapes poy einai katv apo to sigkekrimeno shape mas shape
			{
				//echo "<br>new_position:".$res_pos[$i]['new_position'];
				//echo "<br>gentable_id:".$res_pos[$i]['gentable_id'];
				$new_position = $res_pos[$i]['position'];
				$gentable_id  = $res_pos[$i]['ID'];
			
				$new_position--;
				if( is_numeric( $new_position ) && $new_position >= 0 )
				{
					$sql = "UPDATE set_ups SET
								position = '".$new_position."'
							WHERE ID = '".$gentable_id."'";
					$results .= "<br>".$sql;		
					$res_sub = mysql_query( $sql ) or dir( mysql_error() );
				
				}
				
				else if( $new_position < 0 )
				{
					break;
				}
			
				
			}	//end of for
			//return $results;
		}	
		
	}	//end of function
	
	
	/*
	* @removeSetUpPosition($overview_id)
	*
	*/
	public function removeSetUpPosition($setup_id)
	{
		if( is_numeric( $setup_id ) )
		{
			$sql = "UPDATE set_ups SET 
						position = '-1'
					WHERE ID = '".$setup_id."'
					";
			$res = $this->excQueryInsUp($sql);
		}
	}
	
	/*88888888888888888888*/
	
	
	/*
	* @getSomeSum($id,$table,$desciptionFiled,$idField)
	*
	* Βρίσκει την περιγραφή ($desciptionFiled) 
	* από μία εγγραφή ενός πίνακα ($table) με βάση
	* το ID (πεδίο : $idField) (τιμή : $id) 
	*/
	public function getSomeSum($id,$table,$sumFiled,$idField)
	{
		if( isset($id) )
		{
			$sql = "SELECT sum($sumFiled) AS sumFiled_sum
					FROM $table
					WHERE $idField = $id";
			$res = mysql_query($sql);		
			if( isset($res) )
			{
				$row = @mysql_fetch_array($res);
				return $row['sumFiled_sum'];
			}
			else
				return "";	
		}
		else
			return "";
				
	}
	
	
	/*
	* @getShapeFromDifficultyGrade($difficulty_id)
	*
	*/
	public function getShapeFromDifficultyGrade($difficulty_grade)
	{
		$path = "../../../../ww/ion/img_skitsa/";
		if( is_numeric( $difficulty_grade ) )
		{
			$sql = "SELECT SK.filename,SK.filename_300
					FROM general_table_tp G
					LEFT JOIN skitsa SK ON G.gentable_id = SK.gentable_id
					
					WHERE ( ROUND( ( program_dif + top_dif + kopi_trox_dif + kaloupi_dif + teliko_trox_dif ) / 5 ) ) = '".$difficulty_grade."'
					ORDER BY RAND()
					LIMIT 10
					";
			$res = mysql_query($sql);
			if( $res )		
			{
				$result = "<div class=\"shapess_techniques_photos\" style=\"width:570px\">";	
				$i = 0;
				while( $row = mysql_fetch_array($res) )
				{
					$img = $path.$row['filename'];
					$img_300 = $path.$row['filename_300'];
					if( strlen($row['filename']) )
					{
						$result .= " <img src=\"".$img."\" width=\"50\">";
						/*
						 onMouseOver=\"show('div_styleShape_img300".$difficulty_grade.$i."')\" onMouseOut=\"hidden('div_styleShape_img300".$difficulty_grade.$i."')\">";
						
						<div style=\"display:none; position:absolute; border:1px solid #000000; \" id=\"div_styleShape_img300".$difficulty_grade.$i."\">
								<img src=\"".$img_300."\" width=\"200\" onMouseOut=\"hidden('div_styleShape_img300".$difficulty_grade.$i."')\">
						</div>";
						*/
					}	
					//if( $i == "7" )
					//	$result .= "<br>";
					$i++;
				}
					
				$result .= "</div>";
				
				return $result;
			}
			//return $sql;
			
		}
	}
	
	
	
	/*
	* @getShapeFromAesthetics($aesthetics_id)
	*
	*/
	public function getShapeFromAesthetics($aesthetics_id)
	{
		$path = "../../../../ww/ion/img_skitsa/";
		if( is_numeric( $aesthetics_id ) )
		{
			$sql = "SELECT SK.filename,SK.filename_300
					FROM general_table_tp G
					LEFT JOIN skitsa SK ON G.gentable_id = SK.gentable_id
					
					WHERE G.aesthetics = '".$aesthetics_id."'
					";
			$res = mysql_query($sql);
			if( $res )		
			{
				$result = "<div class=\"shapess_techniques_photos_v2\">";	
				$i = 0;
				while( $row = mysql_fetch_array($res) )
				{
					$img = $path.$row['filename'];
					$img_300 = $path.$row['filename_300'];
					if( strlen($row['filename']) )
					{
						$result .= " <img src=\"".$img."\" width=\"50\" onMouseOver=\"show('div_styleShape_img300".$aesthetics_id.$i."')\" onMouseOut=\"hidden('div_styleShape_img300".$aesthetics_id.$i."')\">
						<div style=\"display:none; position:absolute; border:1px solid #000000; \" id=\"div_styleShape_img300".$aesthetics_id.$i."\">
								<img src=\"".$img_300."\" width=\"200\" onMouseOut=\"hidden('div_styleShape_img300".$aesthetics_id.$i."')\">
						</div>";
					}	
					//if( $i == "7" )
					//	$result .= "<br>";
					$i++;
				}
					
				$result .= "</div>";
				
				return $result;
			}
			//return $sql;
			
		}
	}
	
	
	/*
	* @getDiscountGroup($group_id)
	*
	*/
	public function getDiscountGroup($group_id)
	{
		$sql = "SELECT *
				FROM shape_discount_group_detail
				WHERE shape_discount_group_detail_group_id = '".$group_id."' ";
		$res = $this->excQuery($sql);
		$result = "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"addForm_seachTitlesTable_paddingBasicInfo\">";
			$result .= "<tr>";	
				$result .= "<th>";	
					$result .= "Min Pcs";
				$result .= "</th>";	
				$result .= "<th>";	
					$result .= "Max Pcs";
				$result .= "</th>";	
				$result .= "<th>";	
					$result .= "Discount";
				$result .= "</th>";	
				$result .= "<th style=\"cursor:hand;\" onClick=\"hidden('div_discount_prices')\">";	
					$result .= "<img src=\"../../../images/Cancel.png\" width=\"15\">";
				$result .= "</th>";	
			$result .= "</tr>";		

		for( $i=0;$i<count($res); $i++ )		
		{
			$result .= "<tr>";	
				$result .= "<td width=\"100\" align=\"center\">";	
					$result .= $res[$i]['shape_discount_group_detail_min_items'];	
				$result .= "</td>";	
				$result .= "<td width=\"100\" align=\"center\">";	
					$result .= $res[$i]['shape_discount_group_detail_max_items'];	
				$result .= "</td>";	
				$result .= "<td width=\"100\" align=\"center\">";	
					$result .= number_format( $res[$i]['shape_discount_group_detail_discount'],0,".",",");	
				$result .= "%</td>";	
		
				$result .= "<td>";	
				$result .= "</td>";	
		
			$result .= "</tr>";		
		}

		$result .= "</table>";



		return $result;
	}
	
	
	/*
	* @getMetalPriceList($metalID)
	*
	*/
	public function getMetalPriceList($metalID)
	{
		if( is_numeric( $metalID ) )
		{
			$sql = "SELECT tbl_ts_pricelist_metals_price
					FROM tbl_ts_pricelist_metals
					WHERE tbl_ts_pricelist_metals_metal_id = '".$metalID."' 
					ORDER BY tbl_ts_pricelist_metals_date DESC";
			$res = $this->excQuery($sql);		
			
			return $res[0]['tbl_ts_pricelist_metals_price'];
		}
		else
			return "-1"; 
	}
	
	/*
	* @gotoTagetWithWidth($url,$target)
	*
	* Πηγαίνει τον χρήστη
	* στο αντίστοιχο url
	*/
	public function gotoTagetWithWidth($url,$target,$width,$height)
	{
		print "<script> window.open('".$url."','".$target."','width=".$width.",height=".$height.",top=5,left=5,resizable=1,scrollbars=1,status=1,toolbar=1'); </script>";
	}
	
	
	/*
	* @putToCCodeNShapeTechnique($general_id,$newGroupID)
	*
	*/
	public function putToCCodeNShapeTechnique($general_id,$newGroupID)
	{
		if( is_numeric($general_id) && is_numeric($newGroupID) )
		{
			$return = false;
			//Get Group Techniques
			$sql = "SELECT tbl_param_technic_shapes_group_link_technic_technic_id AS technic_id
					FROM tbl_param_technic_shapes_group_link_technic
					WHERE tbl_param_technic_shapes_group_link_technic_group_id = '".$newGroupID."' ";
			$res = $this->excQuery($sql);
			for( $i=0;$i<count($res);$i++ )		
			{
				//Insert Technique to ccode_n
				$sql = "INSERT INTO ccode_n 
						(
							gentable_id,
							tbtech4_unique
						)
						VALUES
						(
							'".$general_id."',
							'".$res[$i]['technic_id']."'
						)";
				$res_ins = @mysql_query($sql);// or die(mysql_error());		
				
				//if( $res_ins )
				//	$return = true;
			}
			return $return;
		}
		else
			return false;
	}
	
	
	/*
	* @getShapeDifficultyGrade($shapeID)
	*
	*/
	public function getShapeDifficultyGrade($shapeID)
	{
		if( is_numeric( $shapeID ) )
		{
			$sql = "SELECT program_dif,top_dif,kopi_trox_dif,kaloupi_dif,teliko_trox_dif
					FROM tpp.general_table_tp
					WHERE gentable_id = '".$shapeID."'";
			$res = $this->excQuery( $sql );
			$sum = 0;
			$avrg = 0;
			
			$kopi_troxisma_v = $this->getSomeDesc($res[0]['kopi_trox_dif'],"tpp.tbl_param_shape_difficulty","tbl_param_shape_difficulty_grade","tbl_param_shape_difficulty_id");
			
			$program_v = $this->getSomeDesc($res[0]['program_dif'],"tpp.tbl_param_shape_difficulty","tbl_param_shape_difficulty_grade","tbl_param_shape_difficulty_id");
			
			$kaloupi_v = $this->getSomeDesc($res[0]['kaloupi_dif'],"tpp.tbl_param_shape_difficulty","tbl_param_shape_difficulty_grade","tbl_param_shape_difficulty_id");
			
			$top_v = $this->getSomeDesc($res[0]['top_dif'],"tpp.tbl_param_shape_difficulty","tbl_param_shape_difficulty_grade","tbl_param_shape_difficulty_id");
			
			$troxisma_v = $this->getSomeDesc($res[0]['teliko_trox_dif'],"tpp.tbl_param_shape_difficulty","tbl_param_shape_difficulty_grade","tbl_param_shape_difficulty_id");
			
			$sum = ($program_v* 1.5) +  ($top_v* 1.5) + ($kaloupi_v* 1.5) +  $kopi_troxisma_v +  $troxisma_v;
			//$av = (int)($sum / 5);
			//$avrg = round( (int)($sum / 5) );
			$avrg = round( (int)($sum / 5) );
			
			/*
			$sql = "SELECT tbl_param_shape_difficulty_id
					FROM tbl_param_shape_difficulty 
					WHERE tbl_param_shape_difficulty_grade = '".$avrg."' ";
			$res = $this->excQuery($sql);
			$avrgID = $res[0]['tbl_param_shape_difficulty_id'];
			*/
			
			return $avrg;
			
		}
	}
	
	
	
	/*
	* @getShapeMetalCost($shape_id)
	*
	*/
	public function getShapeMetalCost($shape_id)
	{
		if( is_numeric($shape_id) )
		{
			//Get Shape's Metals
			$sql = "SELECT tbl_ts_shape_link_metal_glue_metal_id,tbl_ts_shape_link_metal_glue_qty 
					FROM tbl_ts_shape_link_metal_glue  ML
					WHERE ML.tbl_ts_shape_link_metal_glue_shape_id = ".$shape_id;
			$res = $this->excQuery($sql);		
			$sumPrice = 0;
			for( $i=0;$i<count($res);$i++ )
			{
				$metal_id = $res[$i]['tbl_ts_shape_link_metal_glue_metal_id'];				
				$qty = $res[$i]['tbl_ts_shape_link_metal_glue_qty'];				
				$unitPrice = $this->getMetalTotalCost( $metal_id );
				$sumPrice += ( $qty * $unitPrice );
			}	
			return $sumPrice;
		}
	}
	
	
	/*
	* @getMetalTotalCost($metal_id)
	*
	*/
	public function getMetalTotalCost($metal_id)
	{
		if( is_numeric($metal_id) )
		{
			$sql = "SELECT tbl_ts_metal_costing_id,tbl_ts_metal_costing_metal_detail_id,
						   tbl_ts_metal_costing_metal_detail_qty,tbl_ts_metal_costing_metal_id
					FROM tbl_ts_metal_costing 
					WHERE tbl_ts_metal_costing_metal_id = '".$metal_id."' ";
			$res = $this->excQuery($sql);
			
			$unitPrice = 0;
			$qty = 0;
			$value = 0;
			$sumOfValues = 0;
			
			for( $i=0;$i<count($res);$i++ )
			{
				$unitPrice = $this->getMetalPriceList( $res[$i]['tbl_ts_metal_costing_metal_detail_id'] );
				$qty = $res[$i]['tbl_ts_metal_costing_metal_detail_qty'];
				$value = ( $unitPrice * $qty );
				$sumOfValues += $value;
			}	
			
			$sql = "SELECT  tbl_ts_metal_alla_cost,tbl_ts_metal_alla_qty,tbl_ts_metal_paint_qty,tbl_ts_metal_paint_cost
					FROM tbl_ts_metals
					WHERE tbl_ts_metal_id = '".$metal_id."' ";
			$row = $this->excQuery($sql);		
			
			$sumOfValues += ($row[0]['tbl_ts_metal_alla_cost'] * $row[0]['tbl_ts_metal_alla_qty']);
			$sumOfValues += ( $row[0]['tbl_ts_metal_paint_qty'] * $row[0]['tbl_ts_metal_paint_cost'] );
			
			return $sumOfValues;
				
		}
	}
	
	
	/*
	* @getShapeGlueCost($shape_id)
	*
	*/
	public function getShapeGlueCost($shape_id)
	{
		if( is_numeric($shape_id) )
		{
			//Get Shape's Metals
			$sql = "SELECT tbl_ts_shape_link_metal_glue_qty 
					FROM tbl_ts_shape_link_metal_glue  ML
					WHERE ML.tbl_ts_shape_link_metal_glue_shape_id = ".$shape_id."
					AND tbl_ts_shape_link_metal_glue_glue_id != '0' ";
			$res = $this->excQuery($sql);		
			$sumQTY = 0;
			for( $i=0;$i<count($res);$i++ )
			{
				$qty = $res[$i]['tbl_ts_shape_link_metal_glue_qty'];				
				$sumQTY += $qty;
			}	
			return $sumQTY;
		}
	}
	
	
	/*
	* @getShapePriceCategoryPr1($shape_id)
	*
	*/
	public function getShapePriceCategoryPr1( $object_cm2 )
	{
		if( is_numeric( $object_cm2 ) )
		{
			$sql = "SELECT ID,p1
					FROM tpp.prices_times_pososta_new
					WHERE '".$object_cm2."' BETWEEN cm_min  AND cm_max 
					";
			$res = $this->excQuery($sql);
			return $res[0]['p1'];
		}
	}
	
	
	/*
	* @getNumberOfPatternsInPriceCategory($price_cat_id)
	*
	*/
	public function getNumberOfPatternsInPriceCategory($price_cat_id)
	{
		if( is_numeric( $price_cat_id ) )
		{
			$sql = "SELECT count(*) AS MyCount
					FROM Patterns 
					WHERE price_category = '".$price_cat_id."' ";
			$res = $this->excQuery($sql);
			return $res[0]['MyCount'];		
		}	
	}
	
	
	
	public function getPatternsFromPriceCategory( $price_cat_id )
	{
		$path = "../../../../ww/ion/img_finish/";
		if( is_numeric( $price_cat_id ) )
		{
			$sql = "SELECT *
					FROM Patterns
					WHERE price_category = ".$price_cat_id."
					AND pattern_photo IS NOT NULL
					";
			$res = mysql_query($sql);
			if( $res )		
			{
				$result = "<div class=\"shapess_price_cat_photos_patterns\">";	
				$i = 0;
				while( $row = mysql_fetch_array($res) )
				{
					$img = $path.$row['pattern_photo'];
					$img_300 = $path.$row['pattern_photo_300'];
					
					if( strlen($row['pattern_photo']) || strlen($row['pattern_photo_300'])  )
					{
						$result .= " <img src=\"".$img."\" width=\"50\" onMouseOver=\"show('div_styleShape_img300".$price_cat_id.$i."')\" onMouseOut=\"hidden('div_styleShape_img300".$price_cat_id.$i."')\">
						<div style=\"display:none; position:absolute; border:1px solid #000000; \" id=\"div_styleShape_img300".$price_cat_id.$i."\">
								<img src=\"".$img_300."\" width=\"200\" onMouseOut=\"hidden('div_styleShape_img300".$price_cat_id.$i."')\">
						</div>";
					}	
					//if( $i == "7" )
					//	$result .= "<br>";
					$i++;
				}
					
				$result .= "</div>";
				
				return $result;
			}
			//return $sql;
			
		}
	}
	
	
	
	public function createOptionsColorQuality($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc)
	{
		$sql = "SELECT $fieldsID,$fieldsText,tbl_ts_mixture_header_color_quality_mix, tbl_param_color_quality_text
				FROM $table  C
				LEFT JOIN glass_apps_all.tbl_ts_mixture_header MH ON C.color_id = MH.tbl_ts_mixture_header_root_color_id
				LEFT JOIN glass_apps_all.tbl_param_color_quality Q ON MH.tbl_ts_mixture_header_color_quality_mix = Q.tbl_param_color_quality_id
				";
		if( strlen($where) > 0 )		
			$sql .= " WHERE ".$where . " " ;
		$sql .= " ORDER BY $orderBy $descAsc ";	
		
		$res = mysql_query($sql,$this->conn_id);
		
		if( $res )
		{
			while( $row = mysql_fetch_array($res) )
			{
				if( $row[$fieldsID] == $SelectedID  )
					$selected = "selected";
				else
					$selected = "";	
				$option .= "<option value=\"".$row[$fieldsID]."\" $selected>".$row[$fieldsText]." | ".$row['tbl_param_color_quality_text']."</option>";	
			}
			
			return $option;
		}
		else
			return mysql_error();
		
	}
	
	
	
	/*
	* @createOptionsColorQuality_v2($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc)
	*
	*/
	public function createOptionsColorQuality_v2($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc)
	{
		$sql = "SELECT $fieldsID,$fieldsText,tbl_ts_mixture_header_color_quality_mix, tbl_param_color_quality_text
				FROM $table  C
				LEFT JOIN glass_apps_all.tbl_ts_mixture_header MH ON C.color_id = MH.tbl_ts_mixture_header_root_color_id
				LEFT JOIN glass_apps_all.tbl_param_color_quality Q ON MH.tbl_ts_mixture_header_color_quality_mix = Q.tbl_param_color_quality_id
				";
		if( strlen($where) > 0 )		
			$sql .= " WHERE ".$where . " " ;
		$sql .= " ORDER BY $orderBy $descAsc ";	
		
		$res = mysql_query($sql,$this->conn_id);
		
		if( $res )
		{
			while( $row = mysql_fetch_array($res) )
			{
				if( $row[$fieldsID] == $SelectedID  )
					$selected = "selected";
				else
					$selected = "";	
				$option .= "<option value=\"".$row[$fieldsID]."\" $selected>".$row[$fieldsText]." | ".$row['tbl_param_color_quality_text']." | ".$row[$fieldsID]."</option>";	
			}
			
			return $option;
		}
		else
			return mysql_error();
		
	}
	
	
	/*
	* @getVafiesFromMetalShape( $shapeID )
	*
	*/
	public function getVafiesFromMetalShape( $shapeID )
	{
		//Check if shape is "Only Metal True"
		$onlyMetal = $this->getSomeDesc($shapeID,"tpp.general_table_tp","only_metal","gentable_id");
		//echo "onlyMetal:".$onlyMetal;
		if( $onlyMetal == "False" )
		{
	
			$sql = "SELECT tbl_ts_shape_link_metal_glue_metal_id
					FROM glass_apps_all.tbl_ts_shape_link_metal_glue
		
					WHERE tbl_ts_shape_link_metal_glue_shape_id = '".$shapeID."' ";
			$res = $this->excQuery($sql);

			$vafiIDs = "";
			$koma = "";
		
			$sql_res = $sql;
			for( $i=0;$i<count($res);$i++ )
			{
				//Get Vafi Categories of metals
				$sql = "SELECT tbl_ts_link_metal_vafi_category_category_id
						FROM glass_apps_all.tbl_ts_link_metal_vafi_category
			
						WHERE tbl_ts_link_metal_vafi_category_metal_id = '".$res[$i]['tbl_ts_shape_link_metal_glue_metal_id']."' ";
				$res_vc = $this->excQuery($sql);
				$sql_res = $sql;
				for( $j=0;$j<count($res_vc);$j++ )		
				{
					//Get Vafies
					$sql = "SELECT tbl_ts_link_vafi_category_vafi_vafi_id
							FROM glass_apps_all.tbl_ts_link_vafi_category_vafi
				
							WHERE tbl_ts_link_vafi_category_vafi_category_id = '".$res_vc[$j]['tbl_ts_link_metal_vafi_category_category_id']."' ";
					$res_vf = $this->excQuery($sql);
		
					for( $k=0;$k<count($res_vf);$k++ )		
					{
						$vafiIDs .= $koma."".$res_vf[$k]['tbl_ts_link_vafi_category_vafi_vafi_id'];
						$koma = ",";
					}
				}
	
			}
		}//end of is not only metal	
		else if( $onlyMetal == "True" )
		{
					//Get Vafies
					$sql = "SELECT tbl_ts_link_vafi_category_vafi_vafi_id
							FROM glass_apps_all.tbl_ts_link_vafi_category_vafi
				
							";
					$res_vf = $this->excQuery($sql);
									
					$vafiIDs = "";
					$koma = "";
					for( $k=0;$k<count($res_vf);$k++ )		
					{
						$vafiIDs .= $koma."".$res_vf[$k]['tbl_ts_link_vafi_category_vafi_vafi_id'];
						$koma = ",";
					}
		}
		
		return $vafiIDs;
		
	} //End of function
	
	
	/*
	* @getVafiesFromMetalShape_v2( $shapeID )
	*
	*/
	public function getVafiesFromMetalShape_v2( $shapeID )
	{
		//Check if shape is "Only Metal True"
		$onlyMetal = $this->getSomeDesc($shapeID,"tpp.general_table_tp","only_metal","gentable_id");
		$is_set = $this->isShapeSet( $shapeID ); //Return 1 (is set) or 0 (not set)		
		
		
		//echo "onlyMetal:".$onlyMetal;
		if( $onlyMetal == "False" )
		{
	
			$sql = "SELECT tbl_ts_shape_link_metal_glue_metal_id
					FROM glass_apps_all.tbl_ts_shape_link_metal_glue
		
					WHERE tbl_ts_shape_link_metal_glue_shape_id = '".$shapeID."' ";
			$res = $this->excQuery($sql);

			$vafiIDs = "";
			$koma = "";
		
			$sql_res = $sql;
			for( $i=0;$i<count($res);$i++ )
			{
				//Get Vafi Categories of metals
				$sql = "SELECT tbl_ts_link_metal_vafi_category_category_id
						FROM glass_apps_all.tbl_ts_link_metal_vafi_category
			
						WHERE tbl_ts_link_metal_vafi_category_metal_id = '".$res[$i]['tbl_ts_shape_link_metal_glue_metal_id']."' ";
				$res_vc = $this->excQuery($sql);
				$sql_res = $sql;
				for( $j=0;$j<count($res_vc);$j++ )		
				{
					//Get Vafies
					$sql = "SELECT tbl_ts_link_vafi_category_vafi_vafi_id
							FROM glass_apps_all.tbl_ts_link_vafi_category_vafi
				
							WHERE tbl_ts_link_vafi_category_vafi_category_id = '".$res_vc[$j]['tbl_ts_link_metal_vafi_category_category_id']."' ";
					$res_vf = $this->excQuery($sql);
		
					for( $k=0;$k<count($res_vf);$k++ )		
					{
						$vafiIDs .= $koma."".$res_vf[$k]['tbl_ts_link_vafi_category_vafi_vafi_id'];
						$koma = ",";
					}
				}
	
			}
		}//end of is not only metal	
		else if( $onlyMetal == "True" )
		{
					//Get Vafies
					$sql = "SELECT tbl_ts_link_vafi_category_vafi_vafi_id
							FROM glass_apps_all.tbl_ts_link_vafi_category_vafi
				
							";
					$res_vf = $this->excQuery($sql);
									
					$vafiIDs = "";
					$koma = "";
					for( $k=0;$k<count($res_vf);$k++ )		
					{
						$vafiIDs .= $koma."".$res_vf[$k]['tbl_ts_link_vafi_category_vafi_vafi_id'];
						$koma = ",";
					}
		}
		
		return $vafiIDs;
		
	} //End of function
	
	
	/*
	* @existCPMInCpmDetail( $cpm_id,$color_id )
	*
	*/
	public function existCPMInCpmDetail( $cpm_id,$color_id )
	{
		if( is_numeric( $cpm_id ) && is_numeric( $color_id ) )
		{
			$sql = "SELECT tbl_ts_cpm_detail_id
					FROM tbl_ts_cpm_detail
					WHERE tbl_ts_cpm_detail_root_color_id = '".$color_id."'
					AND tbl_ts_cpm_detail_cpm_id = '".$cpm_id."' ";
			$res = $this->excQuery($sql);		
			if( is_numeric( $res[0]['tbl_ts_cpm_detail_id'] ) )
				return true;
			else
				return false;	
		}
		else
		{
			return false;
		}
	}
	
	
	
	/*
	* @insertCpmToCpmDetail( $cpm_id, $color_id,$mixture_color_id )
	*
	*/
	public function insertCpmToCpmDetail( $cpm_id, $color_id,$mixture_color_id )
	{
		if( is_numeric($cpm_id) && is_numeric($color_id) && is_numeric($mixture_color_id) )
		{
			//Get Cpm Code
			$cpm_code = $this->getCpmCode( $cpm_id, $color_id );
			
		
			$sql = "INSERT INTO tbl_ts_cpm_detail
					(
						tbl_ts_cpm_detail_root_color_id,
						tbl_ts_cpm_detail_mixture_header_id,
						tbl_ts_cpm_detail_cpm_id,
						tbl_ts_cpm_detail_cpm_code
					)
					VALUES
					(
						'".$color_id."',
						'".$mixture_color_id."',
						'".$cpm_id."',
						'".$cpm_code."'
					)";
			$res = mysql_query($sql) or die( mysql_error() );
			return $res;
		}
		else
		{
			return 2;
		}	
	}
	
	
	/*
	* @getCpmCode( $cpm_id, $color_id )
	*
	*/
	public function getCpmCode( $cpm_id, $color_id )
	{
		if( is_numeric($cpm_id) && is_numeric($color_id) )
		{
			//Get cpm Code
			$sql = "SELECT tbl_param_color_production_method_color_specs_code
					FROM tbl_param_color_production_method
					WHERE tbl_param_color_production_method_id = '".$cpm_id."' ";
			$res = $this->excQuery($sql);
			
			//Get Color Code
			$sql = "SELECT color_code
					FROM tpp.prototype_colors
					WHERE color_id = '".$color_id."' ";
			$res_c = $this->excQuery($sql);		
			
			$cpm_code = $res[0]['tbl_param_color_production_method_color_specs_code']."_".$res_c[0]['color_code'];
			return $cpm_code; 
		}
		else
		{
			return "";
		}
	}
	
	
	/*
	* @getProdiagrafesOfCmpCq( $cmp_detail, $prod )
	*
	*/
	public function getProdiagrafesOfCmpCq( $cmp_detail, $prod )
	{
		if( $cmp_detail == 0 || ! is_numeric( $cmp_detail ) )
		{
			return $prod;
		}
		else
			return $cmp_detail;
	}
	
	
	/*
	* @getMiktikoEuro($cpm_detail_id)
	*
	*/
	public function getMiktikoEuro($cpm_detail_id)
	{
		if( is_numeric( $cpm_detail_id ) ) 
		{
			$euro = 0;
			
			$sql = "SELECT *
					FROM tbl_ts_cpm_detail
					WHERE  tbl_ts_cpm_detail_id = '".$cpm_detail_id."' ";
			$res = $this->excQuery($sql);
			
			
			$miktiko1 = $res[0]['tbl_ts_cpm_detail_miktiko1_id'];
			$miktiko2 = $res[0]['tbl_ts_cpm_detail_miktiko2_id'];
			//$miktiko3 = $res[0]['tbl_ts_cpm_detail_miktiko3_id']; //v2 25-05-2010 vasily
			
			$miktiko1_qty = $res[0]['tbl_ts_cpm_detail_miktiko1_qty'];
			$miktiko2_qty = $res[0]['tbl_ts_cpm_detail_miktiko2_qty'];
			//$miktiko3_qty = $res[0]['tbl_ts_cpm_detail_miktiko3_qty'];
			
			//Get prices
			//Miktiko 1
			/*
			$sql = "SELECT tbl_ts_pricelist_colors_price_real
					FROM tbl_ts_pricelist_colors
					WHERE tbl_ts_pricelist_colors_color_id = '".$miktiko1."' 
					ORDER BY tbl_ts_pricelist_colors_date DESC";
			$res_m1 = $this->excQuery($sql);
			*/
			$res_m1[0]['tbl_ts_pricelist_colors_price_real'] = $this->getRealPriceOfOriginalColor( $miktiko1 );
			$euro += ( ( $res_m1[0]['tbl_ts_pricelist_colors_price_real'] / 10 ) * $miktiko1_qty ); // ( $this->getSomeDesc( $cpm_detail_id,"tbl_ts_cpm_detail","tbl_ts_cpm_detail_miktiko1_qty","tbl_ts_cpm_detail_id" ) / 1) );	
			
			//Miktiko 2
			/*
			$sql = "SELECT tbl_ts_pricelist_colors_price_real
					FROM tbl_ts_pricelist_colors
					WHERE tbl_ts_pricelist_colors_color_id = '".$miktiko2."' 
					ORDER BY tbl_ts_pricelist_colors_date DESC";
			$res_m2 = $this->excQuery($sql);
			*/
			$res_m2[0]['tbl_ts_pricelist_colors_price_real'] = $this->getRealPriceOfOriginalColor( $miktiko2 );
			if( $miktiko2 > 0 )
				$euro += ( ( $res_m2[0]['tbl_ts_pricelist_colors_price_real'] / 10 ) * $miktiko2_qty );	//( $this->getSomeDesc( $cpm_detail_id,"tbl_ts_cpm_detail","tbl_ts_cpm_detail_miktiko2_qty","tbl_ts_cpm_detail_id" ) / 1) );
			
			//Miktiko 3
			/*
			$sql = "SELECT tbl_ts_pricelist_colors_price_real
					FROM tbl_ts_pricelist_colors
					WHERE tbl_ts_pricelist_colors_color_id = '".$miktiko3."' 
					ORDER BY tbl_ts_pricelist_colors_date DESC";
			$res_m3 = $this->excQuery($sql);
			*/
			/*
			$res_m3[0]['tbl_ts_pricelist_colors_price_real'] = $this->getRealPriceOfOriginalColor( $miktiko3 );
			if( $miktiko3 > 0 )
				$euro += ( ( $res_m3[0]['tbl_ts_pricelist_colors_price_real'] / 10 ) * $miktiko3_qty );	//( $this->getSomeDesc( $cpm_detail_id,"tbl_ts_cpm_detail","tbl_ts_cpm_detail_miktiko3_qty","tbl_ts_cpm_detail_id" ) / 1) );	
			*/
			
			
			return $euro;
		}
		else 
			return 0;
	}
	
	/*
	* @getFluxEuro($cpm_detail_id)
	*
	*/
	public function getFluxEuro($cpm_detail_id)
	{
		if( is_numeric( $cpm_detail_id ) ) 
		{
			$euro = 0;
			
			$sql = "SELECT tbl_ts_cpm_detail_miktiko3_id, tbl_ts_cpm_detail_miktiko3_qty
					FROM tbl_ts_cpm_detail
					WHERE  tbl_ts_cpm_detail_id = '".$cpm_detail_id."' ";
			$res = $this->excQuery($sql);
			
			
			$flux = $res[0]['tbl_ts_cpm_detail_miktiko3_id']; //v2 25-05-2010 vasily
			
			$flux_qty = $res[0]['tbl_ts_cpm_detail_miktiko3_qty'];
			
			//Get prices
			//Miktiko 3
			$flux_price_real = $this->getRealPriceOfOriginalColor( $flux );
			if( $flux > 0 )
				$euro += ( ( $flux_price_real / 10 ) * $flux_qty );		
			
			
			return $euro;
		}
		else 
			return 0;
	}
	
	
	/*
	* @getCPMAndFluxEuro($cpm_detail_id,$root_color_id,$mixture_header_qty)
	*
	*/
	public function getCPMAndFluxEuro($cpm_detail_id,$root_color_id,$mixture_header_qty)
	{
		if( is_numeric( $cpm_detail_id ) ) 
		{
			$sql = "SELECT tbl_ts_cpm_detail_miktiko3_qty
					FROM tbl_ts_cpm_detail
					WHERE  tbl_ts_cpm_detail_id = '".$cpm_detail_id."' ";
			//echo $sql;		
			$res = $this->excQuery($sql);
			
			$flux_percent = $res[0]['tbl_ts_cpm_detail_miktiko3_qty'];
			
			//$miktikoEuro = $this->getMiktikoEuro($cpm_detail_id);
			$TotalMiktikaEuro = $this->getTotalMiktikaEuro($cpm_detail_id,$root_color_id,$mixture_header_qty);
			$flux_euro        = $this->getFluxEuro($cpm_detail_id);
			//echo "flux_euro:".$flux_euro;
			$cpm_percent = 1 - $flux_percent;
			//echo " cpm_percent:".$cpm_percent;
			
			$totalEuro = ( $TotalMiktikaEuro * $cpm_percent ) + $flux_euro;
			
			return $totalEuro;
		}
		else 
			return 0;
	}
	
	/*
	* @getTotalMiktikaEuro_v2($cpm_detail_id,$root_color_id,$mixture_header_qty)
	*
	*/
	public function getTotalMiktikaEuro_v2($cpm_detail_id,$root_color_id,$mixture_header_qty)
	{
		if( is_numeric( $cpm_detail_id ) ) 
		{
			$sql = "SELECT tbl_ts_cpm_detail_miktiko3_qty
					FROM tbl_ts_cpm_detail
					WHERE  tbl_ts_cpm_detail_id = '".$cpm_detail_id."' ";
			$res = $this->excQuery($sql);
			
			$flux_percent = $res[0]['tbl_ts_cpm_detail_miktiko3_qty'];
			
			//$miktikoEuro = $this->getMiktikoEuro($cpm_detail_id);
			$TotalMiktikaEuro = $this->getTotalMiktikaEuro($cpm_detail_id,$root_color_id,$mixture_header_qty);
			$cpm_percent = 1 - $flux_percent;
			
			$totalEuro = ( $TotalMiktikaEuro * $cpm_percent );
			
			return $totalEuro;
		}
		else 
			return 0;
	}
	
	/*
	* @getRealPriceOfOriginalColor($color_id, $miltikoField)
	*
	*/
	public function getRealPriceOfOriginalColor( $color_id )
	{	
		if( is_numeric( $color_id ) ) 
		{
			$sql = "SELECT avg(tbl_ts_pricelist_colors_price_real) AS AVG_REAL_PRICE
					FROM glass_apps_all.tbl_ts_pricelist_colors PR
					
					WHERE tbl_ts_pricelist_colors_color_id = '".$color_id."' 
					ORDER BY tbl_ts_pricelist_colors_id
					";
			//echo "Clasy:".$sql;		
			$res = $this->excQuery($sql);
			
			if( is_numeric($res[0]['AVG_REAL_PRICE']) && $res[0]['AVG_REAL_PRICE'] > 0 )
				return $res[0]['AVG_REAL_PRICE'];
			
			$sql = "SELECT tbl_ts_pricelist_colors_price_1kg,
							tbl_ts_pricelist_colors_price_5kg,
							tbl_ts_pricelist_colors_price_10kg,
							tbl_ts_pricelist_colors_price_20kg
					FROM glass_apps_all.tbl_ts_pricelist_colors PR
					
					WHERE tbl_ts_pricelist_colors_color_id = '".$color_id."' 
					AND ( tbl_ts_pricelist_colors_price_5kg > 0
						 OR tbl_ts_pricelist_colors_price_1kg > 0
						 OR tbl_ts_pricelist_colors_price_10kg > 0
						 OR tbl_ts_pricelist_colors_price_20kg > 0
						) 
					ORDER BY tbl_ts_pricelist_colors_id
					LIMIT 1
					";
			$res = $this->excQuery($sql);
			$sum = 0;
			$counts = 0;
			if( $res[0]['tbl_ts_pricelist_colors_price_1kg'] > 0 )
			{
				$sum += $res[0]['tbl_ts_pricelist_colors_price_1kg'];
				$counts++;
			}
			if( $res[0]['tbl_ts_pricelist_colors_price_5kg'] > 0 )
			{
				$sum += $res[0]['tbl_ts_pricelist_colors_price_5kg'];
				$counts++;
			}
			if( $res[0]['tbl_ts_pricelist_colors_price_10kg'] > 0 )
			{
				$sum += $res[0]['tbl_ts_pricelist_colors_price_10kg'];
				$counts++;
			}
			if( $res[0]['tbl_ts_pricelist_colors_price_20kg'] > 0 )
			{
				$sum += $res[0]['tbl_ts_pricelist_colors_price_20kg'];
				$counts++;
			}
			
			if( $counts <= 0 ) $counts = 1;
						
			$AVG_PRICELIST = $sum / $counts;
			return $AVG_PRICELIST;
			
		}
		// Version 1
		/*
		if( is_numeric( $color_id ) ) 
		{
			$sql = "SELECT tbl_ts_pricelist_colors_price_real
					FROM tbl_ts_pricelist_colors PR
					
					WHERE tbl_ts_pricelist_colors_color_id = '".$color_id."' 
					ORDER BY tbl_ts_pricelist_colors_id
					";
			//echo "Clasy:".$sql;		
			$res = $this->excQuery($sql);
			
			return $res[0]['tbl_ts_pricelist_colors_price_real'];
		}
		*/
	}
	
	
	/*
	* @getTotalMiktikaEuro($cpm_detail_id,$root_color_id,$mixture_header_qty)
	*
	*/
	public function getTotalMiktikaEuro($cpm_detail_id,$root_color_id,$mixture_header_qty)//$mixture_header_id
	{
		if( is_numeric( $cpm_detail_id ) && is_numeric( $root_color_id ) ) 
		{
			$mixture_header_id = $this->getSomeDesc( $root_color_id,"tbl_ts_mixture_header","tbl_ts_mixture_header_id","tbl_ts_mixture_header_root_color_id" );
			$euro = 0;
			$euro = $this->getMiktikoEuro($cpm_detail_id);
			$total_mixCost = 0;
			
			//Get Mixture details
			$sql = "SELECT tbl_ts_mix_detail_item,tbl_ts_mix_detail_qty
					FROM tbl_ts_mix_detail
					WHERE tbl_ts_mix_detail_header_id = '".$mixture_header_id."' 
					AND tbl_ts_mix_detail_color_id = 0";
			//echo "Class:".$sql;		
			$res = $this->excQuery($sql);
			for( $i=0;$i<count($res); $i++ )		
			{
				$total_mixCost += ( $res[$i]['tbl_ts_mix_detail_qty'] *  ( $this->getRealPriceOfOriginalColor( $res[$i]['tbl_ts_mix_detail_item'] ) / 10) );
				//echo "<br>InForClass detail_item: ".$res[$i]['tbl_ts_mix_detail_item']."<br>";		
			}
			
			$euro +=  ( $total_mixCost * ( $mixture_header_qty / 1 ) );
			
			return $euro;
		}
		else
			return 0;
	}
	
	
	
	/*
	* @isReady($TextOK,$TextNotOK,$value,$prValue)
	*
	*/
	public function isReady($TextOK,$TextNotOK,$value,$prValue)
	{
		if( $value == $prValue )
		{
			return "<b><font color=red>".$TextNotOK."</font></b>";
		}
		else
			return "<b><font color=green>".$TextOK."</font></b>";
	}
	
	
	/*
	* @replaceJunkChars( $text )
	*
	*/
	public function replaceJunkChars( $text,$textArrays )
	{
		for( $i=0;$i<count($textArrays);$i++ )
		{
			$text .= str_replace($textArrays[$i],"",$text);
		}	
		return $text;
	}
	
	
	/*
	* @getExistsMetalPriceListsDate($month,$year)
	*
	*/
	public function getExistsMetalPriceListsDate($month,$year)
	{
		$sql = "SELECT tbl_ts_pricelist_metals_dates_id
				FROM tbl_ts_pricelist_metals_dates
				WHERE tbl_ts_pricelist_metals_dates_month = '".$month."' 
				AND tbl_ts_pricelist_metals_dates_year = '".$year."' ";
		$res = $this->excQuery($sql);
		
		if( is_numeric( $res[0]['tbl_ts_pricelist_metals_dates_id'] ) )
			return $res[0]['tbl_ts_pricelist_metals_dates_id'];
		else
			return "nothing";	
				
	}
	
	/*
	* @getExistsOtherMaterialPriceListsDate($month,$year)
	*
	*/
	public function getExistsOtherMaterialPriceListsDate($month,$year)
	{
		$sql = "SELECT tbl_ts_pricelist_other_materials_dates_id
				FROM tbl_ts_pricelist_other_materials_dates
				WHERE tbl_ts_pricelist_other_materials_dates_month = '".$month."' 
				AND tbl_ts_pricelist_other_materials_dates_year = '".$year."' ";
		$res = $this->excQuery($sql);
		
		if( is_numeric( $res[0]['tbl_ts_pricelist_other_materials_dates_id'] ) )
			return $res[0]['tbl_ts_pricelist_other_materials_dates_id'];
		else
			return "nothing";	
				
	}
	
	/*
	* @getExistsCartonsPriceListsDate($month,$year)
	*
	*/
	public function getExistsCartonsPriceListsDate($month,$year)
	{
		$sql = "SELECT tbl_ts_pricelist_cartons_date_id
				FROM tbl_ts_pricelist_cartons_date
				WHERE tbl_ts_pricelist_cartons_date_month = '".$month."' 
				AND tbl_ts_pricelist_cartons_date_year = '".$year."' ";
		$res = $this->excQuery($sql);
		
		if( is_numeric( $res[0]['tbl_ts_pricelist_cartons_date_id'] ) )
			return $res[0]['tbl_ts_pricelist_cartons_date_id'];
		else
			return "nothing";	
				
	}
	
	
	/*
	* @getShapeMetalCost_V2($shape_id)
	*
	*/
	public function getShapeMetalCost_V2($shape_id)
	{
		if( is_numeric($shape_id) )
		{
			//Get Shape's Metals
			$sql = "SELECT DISTINCT tbl_ts_shape_link_metal_glue_metal_id, tbl_ts_shape_link_metal_glue_metal_id,tbl_ts_shape_link_metal_glue_qty 
					FROM tbl_ts_shape_link_metal_glue MGL
				    LEFT JOIN tbl_ts_glue_teams GT ON MGL.tbl_ts_shape_link_metal_glue_glue_team_id = GT.tbl_ts_glue_teams_id
					WHERE tbl_ts_shape_link_metal_glue_shape_id = ".$shape_id;
			$res = $this->excQuery($sql);		
			$sumPrice = 0;
			for( $i=0;$i<count($res);$i++ )
			{
				$metal_id = $res[$i]['tbl_ts_shape_link_metal_glue_metal_id'];				
				$qty = $res[$i]['tbl_ts_shape_link_metal_glue_qty'];				
				$unitPrice = $this->getMetalTotalCost_V2( $metal_id );
				 $qtyT += $qty; 

				 $laborminutes = $this->getSomeDesc( $res[$i]['tbl_ts_shape_link_metal_glue_metal_id'],"tbl_ts_metals","tbl_ts_metal_laborminutes","tbl_ts_metal_id" );
				$leptoMisthio = $this->getLeptomistion();
				$laborm = $leptoMisthio*$laborminutes;
				
				$price = ( $unitPrice + $laborm );
				$value = $qty * $price;
				$sumPrice += $value;
			}	
			return $sumPrice;	//$sql;//
		}
	}
	
	
	/*
	* @getShapeMetalCost_V3($shape_id)
	*
	*/
	public function getShapeMetalCost_V3($shape_id)
	{
		if( is_numeric($shape_id) )
		{
			//Get Shape's Metals
			$sql = "SELECT DISTINCT tbl_ts_shape_link_metal_glue_metal_id, tbl_ts_shape_link_metal_glue_metal_id,tbl_ts_shape_link_metal_glue_qty 
					FROM glass_apps_all.tbl_ts_shape_link_metal_glue MGL
				    LEFT JOIN glass_apps_all.tbl_ts_glue_teams GT ON MGL.tbl_ts_shape_link_metal_glue_glue_team_id = GT.tbl_ts_glue_teams_id
					WHERE tbl_ts_shape_link_metal_glue_shape_id = ".$shape_id;
			//echo "<br>".$sql; 		
			$res = $this->excQuery($sql);		
			$sumPrice = 0;
			for( $i=0;$i<count($res);$i++ )
			{
				$metal_id = $res[$i]['tbl_ts_shape_link_metal_glue_metal_id'];				
				$qty = $res[$i]['tbl_ts_shape_link_metal_glue_qty'];				
				$unitPrice = $this->getMetalTotalCost_V3( $metal_id );
				 $qtyT += $qty; 

				 
				
				//$price = ( $unitPrice + $laborm );
				$price = $qty * $unitPrice;
				$sumPrice += $price;
			}	
			return $sumPrice;	//$sql;//
		}
	}
	
	
	/*
	* @getMetalTotalCost($metal_id)
	*
	*/
	public function getMetalTotalCost_V2($metal_id)
	{
		if( is_numeric($metal_id) )
		{
			$sql = "SELECT tbl_ts_metal_costing_id,tbl_ts_metal_costing_metal_detail_id,
						   tbl_ts_metal_costing_metal_detail_qty,tbl_ts_metal_costing_metal_id
					FROM tbl_ts_metal_costing 
					WHERE tbl_ts_metal_costing_metal_id = '".$metal_id."' ";
			$res = $this->excQuery($sql);
			
			$unitPrice = 0;
			$qty = 0;
			$value = 0;
			$sumOfValues = 0;
			
			for( $i=0;$i<count($res);$i++ )
			{
				$unitPrice = $this->getMetalPriceList( $res[$i]['tbl_ts_metal_costing_metal_detail_id'] );
				$qty = $res[$i]['tbl_ts_metal_costing_metal_detail_qty'];
				$value = ( $unitPrice * $qty );
				
				$sumOfValues += $value;
			}	
			
			$sql = "SELECT  tbl_ts_metal_alla_cost,tbl_ts_metal_alla_qty,tbl_ts_metal_paint_qty,tbl_ts_metal_paint_cost
					FROM tbl_ts_metals
					WHERE tbl_ts_metal_id = '".$metal_id."' ";
			$row = $this->excQuery($sql);		
			
			$sumOfValues += ( $row[0]['tbl_ts_metal_alla_cost'] * $row[0]['tbl_ts_metal_alla_qty'] );
			$sumOfValues += ( $row[0]['tbl_ts_metal_paint_qty'] * $row[0]['tbl_ts_metal_paint_cost'] );
			
			return $sumOfValues;
				
		}
	}
	
	
	/*
	* @getMetalTotalCost($metal_id)
	*
	*/
	public function getMetalTotalCost_V3($metal_id)
	{
		if( is_numeric($metal_id) )
		{
			$sql = "SELECT tbl_ts_metal_metal_cost
					FROM tbl_ts_metals 
					WHERE tbl_ts_metal_id = '".$metal_id."' ";
			//echo "<br>".$sql;		
			$res = $this->excQuery($sql);
			
			$sumOfValues = $res[0]['tbl_ts_metal_metal_cost'];
			
			return $sumOfValues;
				
		}
	}
	
	
	/*
	* @getMetalTotalCost_newV( $metalID )
	*
	*/
	public function  getMetalTotalCost_newV( $metalID )
	{
		if( is_numeric( $metalID ) )
		{
			$sql = "SELECT tbl_ts_metal_costing_id,tbl_ts_metal_costing_metal_detail_id,
				   			tbl_ts_metal_costing_metal_detail_qty,tbl_ts_metal_costing_metal_id
				   FROM tbl_ts_metal_costing 
				   WHERE tbl_ts_metal_costing_metal_id = '".$metalID."' 
					";
					$res_mcost = $this->excQuery( $sql );		
					 $totalCost = 0;
					for( $k=0;$k<count($res_mcost);$k++ )
					{
						$unitPrice = $this->getMetalPriceList( $res_mcost[$k]['tbl_ts_metal_costing_metal_detail_id'] );
						$qty = $res_mcost[$k]['tbl_ts_metal_costing_metal_detail_qty'];
						$value = ( $unitPrice * $qty );
						$totalCost += $value;
						
					}
			return $this->getMetalTotalCost($metalID);		//$totalCost;
		}
	}
	
	
	/*
	* @getSectionItemsIDs($section_id)
	*
	*/
	public function getSectionItemsIDs($section_id)
	{
		if( is_numeric( $section_id ) )
		{
			$sql = "SELECT prospectus_topics_items_id,prospectus_topics_items_item_id
					FROM prospectus_topics_items
					WHERE prospectus_topics_items_section_id = '".$section_id."'";
		}
	}
	
	
	/*
	* @getSelectedID($SelectedID,$fieldID)
	*
	*/
	public function get_prospectusItems( $link_id,$item_id,$section_id )
	{
		if( is_numeric($link_id) && is_numeric($item_id) && $link_id > 0 && $item_id > 0 )
		{
			$sql = "SELECT prospectus_topics_items_item_id
					FROM prospectus_topics_items
					WHERE prospectus_topics_items_id = '".$link_id."' 
					AND prospectus_topics_items_section_id = '".$section_id."' ";
			$res = $this->excQuery( $sql );		
			if( $res[0]['prospectus_topics_items_item_id'] == $item_id )
				return true;
			else
				return false;	
			
		}
		else
			return false;
	}
	
	
	/*
	* @getSelectedID($SelectedID,$fieldID)
	*
	*/
	public function get_tempOfferColorPatternItems( $link_id,$item_id,$order_id )
	{
		if( is_numeric($link_id) && is_numeric($item_id) && $link_id > 0 && $item_id > 0 )
		{
			$sql = "SELECT tbl_temp_colorpattern_item_id
					FROM tbl_temp_colorpattern
					WHERE tbl_temp_colorpattern_id = '".$link_id."' 
					AND tbl_temp_colorpattern_order_id = '".$order_id."' ";
			$res = $this->excQuery( $sql );		
			if( $res[0]['tbl_temp_colorpattern_item_id'] == $item_id )
				return true;
			else
				return false;	
			
		}
		else
			return false;
	}
	
	/*
	* @getSelectedID($SelectedID,$fieldID)
	*
	*/
	public function get_tempOfferShapeItems( $link_id,$item_id,$type,$order_id )
	{
		if( is_numeric($link_id) && is_numeric($item_id) && $link_id > 0 && $item_id > 0 )
		{
			$sql = "SELECT tbl_temp_offergs_shape_item_id
					FROM tbl_temp_offergs_shape
					WHERE tbl_temp_offergs_shape_id = '".$link_id."' 
					AND tbl_temp_offergs_shape_item_type = '".$type."'
					AND tbl_temp_offergs_shape_order_id = '".$order_id."' ";
			$res = $this->excQuery( $sql );		
			if( $res[0]['tbl_temp_offergs_shape_item_id'] == $item_id )
				return true;
			else
				return false;	
			
		}
		else
			return false;
	}
	
	
	/*
	* @getSelectedID($SelectedID,$fieldID)
	*
	*/
	public function get_prospectusItems_v2( $link_id,$item_id,$type,$section_id )
	{
		if( is_numeric($link_id) && is_numeric($item_id) && $link_id > 0 && $item_id > 0 )
		{
			$sql = "SELECT prospectus_topics_items_item_id
					FROM prospectus_topics_items
					WHERE prospectus_topics_items_id = '".$link_id."' 
					AND prospectus_topics_items_item_type = '".$type."'
					AND prospectus_topics_items_section_id = '".$section_id."' ";
			$res = $this->excQuery( $sql );		
			if( $res[0]['prospectus_topics_items_item_id'] == $item_id )
				return true;
			else
				return false;	
			
		}
		else
			return false;
	}
	
	
	/*
	* @getExistsColorInventoryDate($month,$year)
	*
	*/
	public function getExistsColorInventoryDate($month,$year)
	{
		$sql = "SELECT tbl_ts_inventory_colors_dates_id
				FROM tbl_ts_inventory_colors_dates
				WHERE tbl_ts_inventory_colors_dates_month = '".$month."' 
				AND tbl_ts_inventory_colors_dates_year = '".$year."' ";
		$res = $this->excQuery($sql);
		
		if( is_numeric( $res[0]['tbl_ts_inventory_colors_dates_id'] ) )
			return $res[0]['tbl_ts_inventory_colors_dates_id'];
		else
			return "nothing";	
				
	}
	
	
	/*
	* @getExistsMoldInventoryDate($month,$year)
	*
	*/
	public function getExistsMoldInventoryDate($month,$year)
	{
		$sql = "SELECT tbl_ts_inventory_molds_dates_id
				FROM tbl_ts_inventory_molds_dates
				WHERE tbl_ts_inventory_molds_dates_month = '".$month."' 
				AND tbl_ts_inventory_molds_dates_year = '".$year."' ";
		$res = $this->excQuery($sql);
		
		if( is_numeric( $res[0]['tbl_ts_inventory_molds_dates_id'] ) )
			return $res[0]['tbl_ts_inventory_molds_dates_id'];
		else
			return "nothing";	
				
	}
	
	/*
	* @getExistsGlassInventoryDate($month,$year)
	*
	*/
	public function getExistsGlassInventoryDate($month,$year)
	{
		$sql = "SELECT tbl_ts_inventory_glass_dates_id
				FROM tbl_ts_inventory_glass_dates
				WHERE tbl_ts_inventory_glass_dates_month = '".$month."' 
				AND tbl_ts_inventory_glass_dates_year = '".$year."' ";
		$res = $this->excQuery($sql);
		
		if( is_numeric( $res[0]['tbl_ts_inventory_glass_dates_id'] ) )
			return $res[0]['tbl_ts_inventory_glass_dates_id'];
		else
			return "nothing";	
				
	}
	
	
	/*
	* @getExistsMetalInventoryDate($month,$year)
	*
	*/
	public function getExistsMetalInventoryDate($month,$year)
	{
		$sql = "SELECT tbl_ts_inventory_metals_dates_id
				FROM tbl_ts_inventory_metals_dates
				WHERE tbl_ts_inventory_metals_dates_month = '".$month."' 
				AND tbl_ts_inventory_metals_dates_year = '".$year."' ";
		$res = $this->excQuery($sql);
		
		if( is_numeric( $res[0]['tbl_ts_inventory_metals_dates_id'] ) )
			return $res[0]['tbl_ts_inventory_metals_dates_id'];
		else
			return "nothing";	
				
	}
	
		
	/*
	* @getOtherMaterialInventoryLastQty($month,$year)
	*
	*/
	public function getOtherMaterialInventoryLastQty($other_material_id)
	{
		if( is_numeric( $other_material_id ) )
		{
			$sql = "SELECT tbl_ts_inventory_other_material_qty
					FROM tbl_ts_inventory_other_material
					WHERE tbl_ts_inventory_other_material_material_id = '".$other_material_id."' 
					ORDER BY tbl_ts_inventory_other_material_date DESC";
			$res = $this->excQuery($sql);
			return $res[0]['tbl_ts_inventory_other_material_qty'];		
		}
		else 
			return 0;
	}
	
	/*
	* @getOtherMaterialInventoryLastQty_v2($other_material_id,$company_id)
	*
	*/
	public function getOtherMaterialInventoryLastQty_v2($other_material_id,$company_id)
	{
		if( is_numeric( $other_material_id ) )
		{
			$sql = "SELECT tbl_ts_inventory_other_material_qty
					FROM tbl_ts_inventory_other_material
					WHERE tbl_ts_inventory_other_material_material_id = '".$other_material_id."' 
					AND tbl_ts_inventory_other_material_supplier = '".$company_id."'
					ORDER BY tbl_ts_inventory_other_material_date DESC";
			$res = $this->excQuery($sql);
			//die($sql);
			return $res[0]['tbl_ts_inventory_other_material_qty'];		
		}
		else 
			return 0;
	}
	
	/*
	* @getMetalInventoryLastQty($month,$year)
	*
	*/
	public function getMetalInventoryLastQty($metal_id)
	{
		if( is_numeric( $metal_id ) )
		{
			$sql = "SELECT tbl_ts_inventory_metals_qty
					FROM tbl_ts_inventory_metals
					WHERE tbl_ts_inventory_metals_metal_id = '".$metal_id."' 
					ORDER BY tbl_ts_inventory_metals_date DESC";
			$res = $this->excQuery($sql);
			return $res[0]['tbl_ts_inventory_metals_qty'];		
		}
		else 
			return 0;
	}
	
	/*
	* @getMetalLastInventoryField($metal_id,$field)
	*
	*/
	public function getMetalLastInventoryField($metal_id,$field)
	{
		if( is_numeric( $metal_id ) )
		{
			$sql = "SELECT $field
					FROM tbl_ts_inventory_metals
					WHERE tbl_ts_inventory_metals_metal_id = '".$metal_id."' 
					ORDER BY tbl_ts_inventory_metals_date DESC";
			$res = $this->excQuery($sql);
			return $res[0][$field];		
		}
		else 
			return 0;
	}
	
	
	/*
	* @getOtherMaterialLastInventoryField($other_material_id,$field)
	*
	*/
	public function getOtherMaterialLastInventoryField($other_material_id,$field)
	{
		if( is_numeric( $other_material_id ) )
		{
			$sql = "SELECT $field
					FROM tbl_ts_inventory_other_material
					WHERE tbl_ts_inventory_other_material_material_id = '".$other_material_id."' 
					ORDER BY tbl_ts_inventory_other_material_date DESC";
			$res = $this->excQuery($sql);
			return $res[0][$field];		
		}
		else 
			return 0;
	}
	
	
	
	/*
	* @getMoldInventoryLastQty($month,$year)
	*
	*/
	public function getMoldInventoryLastQty($mold_id)
	{
		if( is_numeric( $mold_id ) )
		{
			$sql = "SELECT tbl_ts_inventory_molds_qty
					FROM tbl_ts_inventory_molds
					WHERE tbl_ts_inventory_molds_mold_id = '".$mold_id."' 
					ORDER BY tbl_ts_inventory_molds_date DESC";
			$res = $this->excQuery($sql);
			return $res[0]['tbl_ts_inventory_molds_qty'];		
		}
		else 
			return 0;
	}
	
	/*
	* @getGlassInventoryLastQty($month,$year)
	*
	*/
	public function getGlassInventoryLastQty($glass_id)
	{
		if( is_numeric( $glass_id ) )
		{
			$sql = "SELECT tbl_ts_inventory_glass_qty
					FROM tbl_ts_inventory_glass
					WHERE tbl_ts_inventory_glass_glass_id = '".$glass_id."' 
					ORDER BY tbl_ts_inventory_glass_date DESC";
			$res = $this->excQuery($sql);
			return $res[0]['tbl_ts_inventory_glass_qty'];		
		}
		else 
			return 0;
	}
	
	/*
	* @getMoldLastInventoryField($mold_id,$field)
	*
	*/
	public function getMoldLastInventoryField($mold_id,$field)
	{
		if( is_numeric( $mold_id ) )
		{
			$sql = "SELECT $field
					FROM tbl_ts_inventory_molds
					WHERE tbl_ts_inventory_molds_mold_id = '".$mold_id."' 
					ORDER BY tbl_ts_inventory_molds_date DESC";
			$res = $this->excQuery($sql);
			return $res[0][$field];		
		}
		else 
			return 0;
	}
	
	/*
	* @getGlassLastInventoryField($glass_id,$field)
	*
	*/
	public function getGlassLastInventoryField($glass_id,$field)
	{
		if( is_numeric( $glass_id ) )
		{
			$sql = "SELECT $field
					FROM tbl_ts_inventory_glass
					WHERE tbl_ts_inventory_glass_glass_id = '".$glass_id."' 
					ORDER BY tbl_ts_inventory_glass_date DESC";
			$res = $this->excQuery($sql);
			return $res[0][$field];		
		}
		else 
			return 0;
	}
	
	
	/*
	* @getColorInventoryLastQty($month,$year)
	*
	*/
	public function getColorInventoryLastQty($color_id)
	{
		if( is_numeric( $color_id ) )
		{
			$sql = "SELECT tbl_ts_inventory_colors_qty
					FROM tbl_ts_inventory_colors
					WHERE tbl_ts_inventory_colors_color_id = '".$color_id."' 
					ORDER BY tbl_ts_inventory_colors_date DESC";
			$res = $this->excQuery($sql);
			return $res[0]['tbl_ts_inventory_colors_qty'];		
		}
		else 
			return 0;
	}
	
	/*
	* @getColorLastInventoryField($color_id,$field)
	*
	*/
	public function getColorLastInventoryField($color_id,$field)
	{
		if( is_numeric( $color_id ) )
		{
			$sql = "SELECT $field
					FROM tbl_ts_inventory_colors
					WHERE tbl_ts_inventory_colors_color_id = '".$color_id."' 
					ORDER BY tbl_ts_inventory_colors_date DESC";
			$res = $this->excQuery($sql);
			return $res[0][$field];		
		}
		else 
			return 0;
	}
	
	
	
	
	
	/*
	* @getExistsColorPricelistDate($month,$year)
	*
	*/
	public function getExistsColorPricelistDate($month,$year)
	{
		$sql = "SELECT tbl_ts_pricelist_colors_dates_id
				FROM tbl_ts_pricelist_colors_dates
				WHERE tbl_ts_pricelist_colors_dates_month = '".$month."' 
				AND tbl_ts_pricelist_colors_dates_year = '".$year."' ";
		$res = $this->excQuery($sql);
		
		if( is_numeric( $res[0]['tbl_ts_pricelist_colors_dates_id'] ) )
			return $res[0]['tbl_ts_pricelist_colors_dates_id'];
		else
			return "nothing";	
				
	}
	
	
	/*
	* @getColorPricelisLastField($color_id,$field)
	*
	*/
	public function getColorPricelisLastField($color_id,$field)
	{
		if( is_numeric( $color_id ) )
		{
			$sql = "SELECT $field
					FROM tbl_ts_pricelist_colors
					WHERE tbl_ts_pricelist_colors_color_id = '".$color_id."' 
					ORDER BY tbl_ts_pricelist_colors_date DESC,
					timestamp DESC";
			$res = $this->excQuery($sql);
			return $res[0][$field];		
		}
		else 
			return 0;
	}
	
	/*
	* @getColorPricelisLastField_v2($color_id,$field)
	*
	*/
	public function getColorPricelisLastField_v2($color_id,$field,$supplier)
	{
		if( is_numeric( $color_id ) )
		{
			$sql = "SELECT $field
					FROM tbl_ts_pricelist_colors
					WHERE tbl_ts_pricelist_colors_color_id = '".$color_id."'
					AND tbl_ts_pricelist_colors_color_factory = '".$supplier."' 
					ORDER BY tbl_ts_pricelist_colors_date DESC,
					timestamp DESC";
			$res = $this->excQuery($sql);
			return $res[0][$field];		
		}
		else 
			return 0;
	}
	
	/*
	* @getColorPricelisLastField_v3($color_id,$field,$supplier,$companyID)
	*
	*/
	public function getColorPricelisLastField_v3($color_id,$field,$supplier,$companyID)
	{
		if( is_numeric( $color_id ) )
		{
			$sql = "SELECT $field
					FROM tbl_ts_pricelist_colors
					WHERE tbl_ts_pricelist_colors_color_id = '".$color_id."'
					AND tbl_ts_pricelist_colors_color_factory = '".$supplier."'
					AND tbl_ts_pricelist_colors_supplier = '".$companyID."' 
					ORDER BY tbl_ts_pricelist_colors_date DESC,
					timestamp DESC, 
					tbl_ts_pricelist_colors_id DESC
					";
			$res = $this->excQuery($sql);
			return $res[0][$field];		
		}
		else 
			return 0;
	}
	
	
	
	/*
	* @getExistsMoldPricelistDate($month,$year)
	*
	*/
	public function getExistsMoldPricelistDate($month,$year)
	{
		$sql = "SELECT tbl_ts_pricelist_molds_dates_id
				FROM tbl_ts_pricelist_molds_dates
				WHERE tbl_ts_pricelist_molds_dates_month = '".$month."' 
				AND tbl_ts_pricelist_molds_dates_year = '".$year."' ";
		$res = $this->excQuery($sql);
		
		if( is_numeric( $res[0]['tbl_ts_pricelist_molds_dates_id'] ) )
			return $res[0]['tbl_ts_pricelist_molds_dates_id'];
		else
			return "nothing";	
				
	}
	
	/*
	* @getExistsGlassPricelistDate($month,$year)
	*
	*/
	public function getExistsGlassPricelistDate($month,$year)
	{
		$sql = "SELECT tbl_ts_pricelist_glass_dates_id
				FROM tbl_ts_pricelist_glass_dates
				WHERE tbl_ts_pricelist_glass_dates_month = '".$month."' 
				AND tbl_ts_pricelist_glass_dates_year = '".$year."' ";
		$res = $this->excQuery($sql);
		
		if( is_numeric( $res[0]['tbl_ts_pricelist_glass_dates_id'] ) )
			return $res[0]['tbl_ts_pricelist_glass_dates_id'];
		else
			return "nothing";	
				
	}
	
	
	
	/*
	* @getMoldPricelisLastField($mold_id,$field)
	*
	*/
	public function getMoldPricelisLastField($mold_id,$field)
	{
		if( is_numeric( $mold_id ) )
		{
			$sql = "SELECT $field
					FROM tbl_ts_pricelist_molds
					WHERE tbl_ts_pricelist_molds_mold_id = '".$mold_id."' 
					ORDER BY tbl_ts_pricelist_molds_date DESC,
					timestamp DESC";
			$res = $this->excQuery($sql);
			return $res[0][$field];		
		}
		else 
			return 0;
	}
	
	
	/*
	* @getMoldPricelisLastField_v2($mold_id,$field,$supplier)
	*
	*/
	public function getMoldPricelisLastField_v2($mold_id,$field,$supplier)
	{
		if( is_numeric( $mold_id ) )
		{
			$sql = "SELECT $field
					FROM tbl_ts_pricelist_molds
					WHERE tbl_ts_pricelist_molds_mold_id = '".$mold_id."' 
					AND tbl_ts_pricelist_molds_factory = '".$supplier."'
					ORDER BY tbl_ts_pricelist_molds_date DESC,
					timestamp DESC";
			$res = $this->excQuery($sql);
			return $res[0][$field];		
		}
		else 
			return 0;
	}
	
	
	/*
	* @getMoldPricelisLastField_v3($mold_id,$field,$supplier,$companyID)
	*
	*/
	public function getMoldPricelisLastField_v3($mold_id,$field,$supplier,$companyID)
	{
		if( is_numeric( $mold_id ) )
		{
			$sql = "SELECT $field
					FROM tbl_ts_pricelist_molds
					WHERE tbl_ts_pricelist_molds_mold_id = '".$mold_id."' 
					AND tbl_ts_pricelist_molds_factory = '".$supplier."'
					AND tbl_ts_pricelist_molds_supplier = '".$companyID."'
					ORDER BY tbl_ts_pricelist_molds_date DESC,
					timestamp DESC";
			$res = $this->excQuery($sql);
			return $res[0][$field];		
		}
		else 
			return 0;
	}
	
	/*
	* @getGlassPricelisLastField_v3($glass_id,$field,$supplier,$companyID)
	*
	*/
	public function getGlassPricelisLastField_v3($glass_id,$field,$supplier,$companyID)
	{
		if( is_numeric( $glass_id ) )
		{
			$sql = "SELECT $field
					FROM tbl_ts_pricelist_glass
					WHERE tbl_ts_pricelist_glass_glass_id = '".$glass_id."' 
					AND tbl_ts_pricelist_glass_factory = '".$supplier."'
					AND tbl_ts_pricelist_glass_supplier = '".$companyID."'
					ORDER BY tbl_ts_pricelist_glass_date DESC,
					timestamp DESC";
			$res = $this->excQuery($sql);
			return $res[0][$field];		
		}
		else 
			return 0;
	}
	
	
	
	/*
	* @getMetalPricelisLastField($metal_id,$field)
	*
	*/
	public function getMetalPricelisLastField($metal_id,$field)
	{
		if( is_numeric( $metal_id ) )
		{
			$sql = "SELECT $field
					FROM tbl_ts_pricelist_metals
					WHERE tbl_ts_pricelist_metals_metal_id = '".$metal_id."' 
					ORDER BY tbl_ts_pricelist_metals_date DESC,
					timestamp DESC";
			$res = $this->excQuery($sql);
			return $res[0][$field];		
		}
		else 
			return 0;
	}
	
	/*
	* @getMetalPricelisLastField_v2($metal_id,$field,$supplier)
	*
	*/
	public function getMetalPricelisLastField_v2($metal_id,$field,$supplier)
	{
		if( is_numeric( $metal_id ) )
		{
			$sql = "SELECT $field
					FROM tbl_ts_pricelist_metals
					WHERE tbl_ts_pricelist_metals_metal_id = '".$metal_id."' 
					AND tbl_ts_pricelist_metals_factory = '".$supplier."'
					ORDER BY tbl_ts_pricelist_metals_date DESC,
					timestamp DESC";
			$res = $this->excQuery($sql);
			return $res[0][$field];		
		}
		else 
			return 0;
	}
	
		
	/*
	* @getMetalPricelisLastField_v3($metal_id,$field,$supplier,$companyID)
	*
	*/
	public function getMetalPricelisLastField_v3($metal_id,$field,$supplier,$companyID)
	{
		if( is_numeric( $metal_id ) )
		{
			$sql = "SELECT $field
					FROM tbl_ts_pricelist_metals
					WHERE tbl_ts_pricelist_metals_metal_id = '".$metal_id."' 
					AND tbl_ts_pricelist_metals_factory = '".$supplier."'
					AND tbl_ts_pricelist_metals_supplier = '".$companyID."'
					ORDER BY tbl_ts_pricelist_metals_date DESC,
					timestamp DESC";
			$res = $this->excQuery($sql);
			return $res[0][$field];		
		}
		else 
			return 0;
	}
	
	/*
	* @getOtherMaterialPricelisLastField_v2($metal_id,$field,$supplier)
	*
	*/
	public function getOtherMaterialPricelisLastField_v2($other_material_id,$field,$supplier)
	{
		if( is_numeric( $other_material_id ) )
		{
			$sql = "SELECT $field
					FROM tbl_ts_pricelist_other_materials
					WHERE tbl_ts_pricelist_other_materials_material_id = '".$other_material_id."' 
					AND tbl_ts_pricelist_other_materials_factory = '".$supplier."'
					ORDER BY tbl_ts_pricelist_other_materials_date DESC,
					timestamp DESC";
			$res = $this->excQuery($sql);
			return $res[0][$field];		
		}
		else 
			return 0;
	}
	
	/*
	* @getOtherMaterialPricelisLastPrice( $other_material_id )
	*
	*/
	public function getOtherMaterialPricelisLastPrice( $other_material_id )
	{
		if( is_numeric( $other_material_id ) )
		{
			$sql = "SELECT tbl_ts_pricelist_other_materials_price
					FROM tbl_ts_pricelist_other_materials
					WHERE tbl_ts_pricelist_other_materials_material_id = '".$other_material_id."' 
					
					ORDER BY tbl_ts_pricelist_other_materials_date DESC,
					timestamp DESC";
			$res = $this->excQuery($sql);
			return $res[0]['tbl_ts_pricelist_other_materials_price'];		
		}
		else 
			return 0;
	}
	
	/*
	* @getOtherMaterialPricelisLastField_v3($metal_id,$field,$supplier,$companyID)
	*
	*/
	public function getOtherMaterialPricelisLastField_v3($other_material_id,$field,$supplier,$companyID)
	{
		if( is_numeric( $other_material_id ) )
		{
			$sql = "SELECT $field
					FROM tbl_ts_pricelist_other_materials
					WHERE tbl_ts_pricelist_other_materials_material_id = '".$other_material_id."' 
					AND tbl_ts_pricelist_other_materials_factory = '".$supplier."'
					AND tbl_ts_pricelist_other_materials_supplier = '".$companyID."'
					ORDER BY tbl_ts_pricelist_other_materials_date DESC,
					timestamp DESC";
			$res = $this->excQuery($sql);
			return $res[0][$field];		
		}
		else 
			return 0;
	}
	
	
	/*
	* @createOptionsDistinct($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$disticntField)
	*
	* Δημιουργία options για select input
	*/
	public function createOptionsDistinct($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$disticntField)
	{
		$sql = "SELECT DISTINCT $disticntField, $fieldsID,$fieldsText
				FROM $table ";
		if( strlen($where) > 0 )		
			$sql .= " WHERE ".$where . " " ;
		$sql .= " ORDER BY $orderBy $descAsc ";	
		
		$res = mysql_query($sql,$this->conn_id);
		
		if( $res )
		{
			while( $row = mysql_fetch_array($res) )
			{
				if( $row[$fieldsID] == $SelectedID  )
					$selected = "selected";
				else
					$selected = "";	
				$option .= "<option value=\"".$row[$fieldsID]."\" $selected>".$row[$fieldsText]."</option>";	
			}
			
			return $option;
		}
		else
			return mysql_error();
		
	}
	
	
	/*
	* @createOptionsDistinctSumCm2($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$disticntField)
	*
	* Δημιουργία options για select input
	*/
	public function createOptionsDistinctSumCm2($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$disticntField)
	{
		$sql = "SELECT DISTINCT $disticntField, $fieldsID,$fieldsText
				FROM $table ";
		if( strlen($where) > 0 )		
			$sql .= " WHERE ".$where . " " ;
		$sql .= " ORDER BY $orderBy $descAsc ";	
		
		$res = mysql_query($sql,$this->conn_id);
		
		if( $res )
		{
			while( $row = mysql_fetch_array($res) )
			{
				if( $row[$fieldsID] == $SelectedID  )
					$selected = "selected";
				else
					$selected = "";
				
				//Get Sum of Cm2
				$sql = " SELECT tbl_pp_week_program_qty1,tbl_pp_orders_cm2_p_schedule
						 FROM tbl_pp_tbp T
						 LEFT JOIN tbl_ts_4code FC ON T.tbl_pp_tbp_ts_id = FC.tbl_ts_4code_id
						 LEFT JOIN tbl_pp_week_program WP   ON T.tbl_pp_tbp_order_id = WP.tbl_pp_week_program_order_id
						 LEFT JOIN tbl_pp_orders O          ON T.tbl_pp_tbp_order_id = O.tbl_pp_orders_id
						 
						 WHERE WP.tbl_pp_week_program_qty1 > 0
						 AND tbl_ts_4code_prog_max = '".$row[$fieldsID]."'
						 
						 ";
				$row_tbp = $this->excQuery( $sql );
				$cm2 = 0;
				for($j=0;$j<count($row_tbp);$j++)
				{
					$qty1 = $row_tbp[$j]['tbl_pp_week_program_qty1']; 
					$cm2  += ($qty1 * $row_tbp[$j]['tbl_pp_orders_cm2_p_schedule']) ;	
				}
				
				
						
				$option .= "<option value=\"".$row[$fieldsID]."\" $selected>".$row[$fieldsText]." | ".number_format($cm2,0,".",",")." cm2</option>";	
			}
			
			return $option;
		}
		else
			return mysql_error();
		
	}
	
	/*
	* @createOptionsDistinctSumCm2($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$disticntField)
	*
	* Δημιουργία options για select input
	*/
	public function createOptionsDistinctSumCm2_MC($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$disticntField,$company_id)
	{
		$sql = "SELECT DISTINCT $disticntField, $fieldsID,$fieldsText
				FROM $table ";
		if( strlen($where) > 0 )		
			$sql .= " WHERE ".$where . " " ;
		$sql .= " ORDER BY $orderBy $descAsc ";	
		
		$res = mysql_query($sql,$this->conn_id);
		
		if( $res )
		{
			while( $row = mysql_fetch_array($res) )
			{
				if( $row[$fieldsID] == $SelectedID  )
					$selected = "selected";
				else
					$selected = "";
				
				//Get Sum of Cm2
				$sql = " SELECT tbl_bg_pp_day_program_qty1,FC.tbl_ts_4code_cm_kiln
						 FROM tbl_bg_pp_tbp T
						 LEFT JOIN tbl_ts_4code FC ON T.tbl_bg_pp_tbp_order_id = FC.tbl_ts_4code_id
						 LEFT JOIN tbl_bg_pp_day_program WP   ON T.tbl_bg_pp_tbp_order_id = WP.tbl_bg_pp_day_program_order_id
						 LEFT JOIN tbl_bg_pp_orders O         ON T.tbl_bg_pp_tbp_order_id = O.tbl_bg_pp_orders_id
						 
						 WHERE WP.tbl_bg_pp_day_program_qty1 > 0
						 AND tbl_ts_4code_prog_max = '".$row[$fieldsID]."'
						 AND tbl_bg_pp_orders_glasscompany_id = '".$company_id."'
						 ";
				$row_tbp = $this->excQuery( $sql );
				$cm2 = 0;
				for($j=0;$j<count($row_tbp);$j++)
				{
					$qty1 = $row_tbp[$j]['tbl_bg_pp_day_program_qty1']; 
					$cm2  += ($qty1 * $row_tbp[$j]['tbl_ts_4code_cm_kiln']) ;	
				}
				
				
						
				$option .= "<option value=\"".$row[$fieldsID]."\" $selected>".$row[$fieldsText]." | ".number_format($cm2,0,".",",")." cm2</option>";	
			}
			
			return $option;
		}
		else
			return mysql_error();
		
	}
	
	
	/*
	* @createOptionsDistinctSumCm2_BG($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$disticntField)
	*
	* Δημιουργία options για select input
	*/
	public function createOptionsDistinctSumCm2_BG($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$disticntField)
	{
		$sql = "SELECT DISTINCT $disticntField, $fieldsID,$fieldsText
				FROM $table ";
		if( strlen($where) > 0 )		
			$sql .= " WHERE ".$where . " " ;
		$sql .= " ORDER BY $orderBy $descAsc ";	
		
		$res = mysql_query($sql,$this->conn_id);
		
		if( $res )
		{
			while( $row = mysql_fetch_array($res) )
			{
				if( $row[$fieldsID] == $SelectedID  )
					$selected = "selected";
				else
					$selected = "";
				
				//Get Sum of Cm2
				$sql = " SELECT tbl_bg_pp_day_program_qty1, FC.tbl_ts_4code_shape_id
						 FROM tbl_bg_pp_tbp T
						 LEFT JOIN tbl_ts_4code FC ON T.tbl_bg_pp_tbp_ts_id = FC.tbl_ts_4code_id
						 LEFT JOIN tbl_bg_pp_day_program WP   ON T.tbl_bg_pp_tbp_order_id = WP.tbl_bg_pp_day_program_order_id
						 LEFT JOIN tbl_bg_pp_orders O          ON T.tbl_bg_pp_tbp_order_id = O.tbl_bg_pp_orders_id
						 
						 WHERE WP.tbl_bg_pp_day_program_qty1 > 0
						 AND tbl_ts_4code_prog_max = '".$row[$fieldsID]."'
						 
						 ";
				$row_tbp = $this->excQuery( $sql );
				$cm2 = 0;
				for($j=0;$j<count($row_tbp);$j++)
				{
					$cm2_p_schedule = $this->getSomeDesc($row_tbp[$j]['tbl_ts_4code_shape_id'],"tpp.general_table_tp","kiln_cm2","gentable_id");		
					$qty1 = $row_tbp[$j]['tbl_bg_pp_day_program_qty1']; 
					$cm2  += ($qty1 * $cm2_p_schedule);	
				}
				
				
						
				$option .= "<option value=\"".$row[$fieldsID]."\" $selected>".$row[$fieldsText]." | ".number_format($cm2,0,".",",")." cm2</option>";	
			}
			
			return $option;
		}
		else
			return mysql_error();
		
	}
	
	
	/*
	* @createOptionsDistinctSumCm2($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$disticntField)
	*
	* Δημιουργία options για select input
	*/
	public function createOptionsCMPSumCm2($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc)
	{
		$sql = "SELECT $fieldsID,$fieldsText
				FROM $table ";
		if( strlen($where) > 0 )		
			$sql .= " WHERE ".$where . " " ;
		$sql .= " ORDER BY $orderBy $descAsc";	
		
		$res = mysql_query($sql,$this->conn_id);
		
		if( $res )
		{
			while( $row = mysql_fetch_array($res) )
			{
				if( $row[$fieldsID] == $SelectedID  )
					$selected = "selected";
				else
					$selected = "";
				
				//Get Sum of Cm2
				$sql = " SELECT tbl_pp_week_program_qty1,tbl_pp_orders_cm2_p_schedule
						 FROM tbl_pp_tbp T
						 LEFT JOIN tbl_ts_4code FC ON T.tbl_pp_tbp_ts_id = FC.tbl_ts_4code_id
						 LEFT JOIN tbl_pp_week_program WP   ON T.tbl_pp_tbp_order_id = WP.tbl_pp_week_program_order_id
						 LEFT JOIN tbl_pp_orders O          ON T.tbl_pp_tbp_order_id = O.tbl_pp_orders_id
						 
						 LEFT JOIN tbl_ts_4code_cpm_detail CD ON FC.tbl_ts_4code_id = CD.tbl_ts_4code_cpm_detail_4code_id	
							 
						 WHERE WP.tbl_pp_week_program_qty1 > 0
						 AND CD.tbl_ts_4code_cpm_detail_cpm_id = '".$row[$fieldsID]."'
						 
						 ";
						 
				$row_tbp = $this->excQuery( $sql );
				$cm2 = 0;
				for($j=0;$j<count($row_tbp);$j++)
				{
					$qty1 = $row_tbp[$j]['tbl_pp_week_program_qty1']; 
					$cm2  += ($qty1 * $row_tbp[$j]['tbl_pp_orders_cm2_p_schedule']) ;	
				}
				
				
						
				$option .= "<option value=\"".$row[$fieldsID]."\" $selected>".$row[$fieldsText]." | ".number_format($cm2,0,".",",")." cm2</option>";	
			}
			
			return $option;
		}
		else
			return mysql_error();
		
	}
	
	
	/*
	* @createOptionsCMPSumCm2_MC($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$disticntField)
	*
	* Δημιουργία options για select input
	*/
	public function createOptionsCMPSumCm2_MC($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$company_id)
	{
		$sql = "SELECT $fieldsID,$fieldsText
				FROM $table ";
		if( strlen($where) > 0 )		
			$sql .= " WHERE ".$where . " " ;
		$sql .= " ORDER BY $orderBy $descAsc";	
		
		$res = mysql_query($sql,$this->conn_id);
		
		if( $res )
		{
			while( $row = mysql_fetch_array($res) )
			{
				if( $row[$fieldsID] == $SelectedID  )
					$selected = "selected";
				else
					$selected = "";
				
				//Get Sum of Cm2
				$sql = " SELECT tbl_bg_pp_day_program_qty1,tbl_ts_4code_cm_kiln
						 FROM tbl_bg_pp_tbp T
						 LEFT JOIN tbl_ts_4code FC ON T.tbl_bg_pp_tbp_ts_id = FC.tbl_ts_4code_id
						 LEFT JOIN tbl_bg_pp_day_program WP   ON T.tbl_bg_pp_tbp_order_id = WP.tbl_bg_pp_day_program_order_id
						 LEFT JOIN tbl_bg_pp_orders O         ON T.tbl_bg_pp_tbp_order_id = O.tbl_bg_pp_orders_id
						 
						 LEFT JOIN tbl_ts_4code_cpm_detail CD ON FC.tbl_ts_4code_id = CD.tbl_ts_4code_cpm_detail_4code_id	
							 
						 WHERE WP.tbl_bg_pp_day_program_qty1 > 0
						 AND CD.tbl_ts_4code_cpm_detail_cpm_id = '".$row[$fieldsID]."'
						 AND tbl_bg_pp_orders_glasscompany_id = '".$company_id."'
						 ";
						 
				$row_tbp = $this->excQuery( $sql );
				$cm2 = 0;
				for($j=0;$j<count($row_tbp);$j++)
				{
					$qty1 = $row_tbp[$j]['tbl_bg_pp_day_program_qty1']; 
					$cm2  += ($qty1 * $row_tbp[$j]['tbl_ts_4code_cm_kiln']) ;	
				}
				
				
						
				$option .= "<option value=\"".$row[$fieldsID]."\" $selected>".$row[$fieldsText]." | ".number_format($cm2,0,".",",")." cm2</option>";	
			}
			
			return $option;
		}
		else
			return mysql_error();
		
	}
	
	
	/*
	* @createOptionsDistinctSumCm2($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$disticntField)
	*
	* Δημιουργία options για select input
	*/
	public function createOptionsCMPSumCm2_BG($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc)
	{
		$sql = "SELECT $fieldsID,$fieldsText
				FROM $table ";
		if( strlen($where) > 0 )		
			$sql .= " WHERE ".$where . " " ;
		$sql .= " ORDER BY $orderBy $descAsc";	
		
		$res = mysql_query($sql);
		
		if( $res )
		{
			while( $row = mysql_fetch_array($res) )
			{
				if( $row[$fieldsID] == $SelectedID  )
					$selected = "selected";
				else
					$selected = "";
				
				//Get Sum of Cm2
				$sql = " SELECT tbl_pp_week_program_qty1, FC.tbl_ts_4code_shape_id
						 FROM glass_apps_all.tbl_bg_pp_tbp T
						 LEFT JOIN glass_apps_all.tbl_ts_4code FC ON T.tbl_bg_pp_tbp_ts_id = FC.tbl_ts_4code_id
						 LEFT JOIN glass_apps_all.tbl_bg_pp_day_program WP   ON T.tbl_bg_pp_tbp_order_id = WP.tbl_bg_pp_day_program_order_id
						 LEFT JOIN glass_apps_all.tbl_bg_pp_orders O          ON T.tbl_bg_pp_tbp_order_id = O.tbl_bg_pp_orders_id
						 
						 LEFT JOIN glass_apps_all.tbl_ts_4code_cpm_detail CD ON FC.tbl_ts_4code_id = CD.tbl_ts_4code_cpm_detail_4code_id	
							 
						 WHERE WP.tbl_bg_pp_day_program_qty1 > 0
						 AND CD.tbl_ts_4code_cpm_detail_cpm_id = '".$row[$fieldsID]."'
						 
						 ";
						 
				$row_tbp = $this->excQuery( $sql );
				$cm2 = 0;
				for($j=0;$j<count($row_tbp);$j++)
				{
					$cm2_p_schedule = $this->getSomeDesc($row_tbp[$j]['tbl_ts_4code_shape_id'],"tpp.general_table_tp","kiln_cm2","gentable_id");	
					$qty1 = $row_tbp[$j]['tbl_bg_pp_day_program_qty1']; 
					$cm2  += ($qty1 * $cm2_p_schedule) ;	
				}
				
				
						
				$option .= "<option value=\"".$row[$fieldsID]."\" $selected>".$row[$fieldsText]." | ".number_format($cm2,0,".",",")." cm2</option>";	
			}
			
			return $option;
		}
		else
			return mysql_error();
		
	}
	
	
	/*
	* @isShapeSet($id)
	*
	*/
	public function isShapeSet($id)
	{
		//Get If shape is Set
		$sql = "SELECT shape_set
				FROM tpp.general_table_tp
				WHERE gentable_id = '".$id."' ";
		$res = $this->excQuery($sql);

		if( $res[0]['shape_set'] == SET_ID )		
			$result = 1;
		else
			$result = 0;		
		
		return 	$result;
	}
	
	
	
	/*
	* @changeCodeForTigerGlass($code)
	*
	*/
	public function changeCodeForTigerGlass($code)
	{
		if( strlen( $code ) )	
		{
			//$splitter = " ";
			//$code = str_replace($splitter,"",$code);
			//$codeTbl = explode($splitter,$code);
			
			$codeTbl = $this->getstrChars($code);
			
			for( $i=0;$i<count($codeTbl);$i++ )
			{
				switch( $codeTbl[$i] )
				{
					case 'A':
						$codeTbl[$i] = "01";	
					break;
					case "B":
						$codeTbl[$i] = "02";	
					break;
					case 'C':
						$codeTbl[$i] = "03";	
					break;
					case 'D':
						$codeTbl[$i] = "04";	
					break;
					case 'E':
						$codeTbl[$i] = "05";	
					break;
					case 'F':
						$codeTbl[$i] = "06";	
					break;
					case 'G':
						$codeTbl[$i] = "07";	
					break;
					case 'H':
						$codeTbl[$i] = "08";	
					break; 
					case 'I':
						$codeTbl[$i] = "09";	
					break; 
					case 'J':
						$codeTbl[$i] = "10";	
					break; 
					case 'K':
						$codeTbl[$i] = "11";	
					break; 
					case 'L':
						$codeTbl[$i] = "12";	
					break; 
					case 'M':
						$codeTbl[$i] = "13";	
					break; 
					case 'N':
						$codeTbl[$i] = "14";	
					break; 
					case 'O':
						$codeTbl[$i] = "15";	
					break; 
					case 'P':
						$codeTbl[$i] = "16";	
					break; 
					case 'Q':
						$codeTbl[$i] = "17";	
					break; 
					case 'R':
						$codeTbl[$i] = "18";	
					break; 
					case 'S':
						$codeTbl[$i] = "19";	
					break; 
					case 'T':
						$codeTbl[$i] = "20";	
					break; 
					case 'U':
						$codeTbl[$i] = "21";	
					break; 
					case 'V':
						$codeTbl[$i] = "22";	
					break; 
					case 'W':
						$codeTbl[$i] = "23";
					break; 
					case 'X':
						$codeTbl[$i] = "24";
					break; 
					case 'Y':
						$codeTbl[$i] = "25";
					break; 
					case 'Z':
						$codeTbl[$i] = "26";	
					break; 
					
					default:
						//$codeTbl[$i] = "00";
					break;
				}//end of switch case
			}//end of for
			
			$finalCode = implode($splitter,$codeTbl);
			
			return $finalCode;
		}//end of if
		else
			return "error";
	}
	
	
	/*
	* @getstrChars($code)
	*
	*/
	public function getstrChars($code)
	{
		$strlength = strlen($code);
		$chars = array();
		for( $i=0;$i<$strlength;$i++ )
		{
			$chars[$i] = substr( $code,$i,1 );
		}
		return $chars;
	}
	
	
	/*
	* @dateZeroToNull($code)
	*
	*/
	public function dateZeroToNull($date)
	{
		if( $date == "0000-00-00" )
			return "";
		else
			return $date; 	
	}
	
	
	
	/*
	* @getBrand4Codes($brand)
	*
	*/
	public function getBrand4Codes($brand)
	{
		if( is_numeric( $brand ) )
		{
			$sql = "SELECT tbl_ts_4code_id
					FROM tbl_ts_4code FC 
					JOIN tbl_ts_4code_link_select LB ON FC.tbl_ts_4code_id = LB.tbl_ts_4code_link_select_4code_id 
					
					WHERE LB.tbl_ts_4code_link_select_select_id = '".$brand."' ";
			$res = $this->excQuery($sql);
			
			$ids = "";
			$koms = "";
			for( $i=0;$i<count($res);$i++ )
			{
				$ids .= $koma.$res[$i]['tbl_ts_4code_id'];
				$koma = ",";
			}
			
			return $ids;
					
		}
	}
	
	
	
	
	/*
	* @get4CodeID( $code )
	*
	*/
	public function get4CodeID( $code )
	{
		$sql = "SELECT tbl_ts_4code_id
				FROM glass_apps_all.tbl_ts_4code
				WHERE tbl_ts_4code_4code = '".$code."' ";
		$res = $this->excQuery($sql);		
		$id = $res[0]['tbl_ts_4code_id'];
		return $id;
	}
	
	
	/*
	* @getMetalCostParam()
	*
	*/
	public function getMetalCostParam()
	{
		$sql = "SELECT * 
				FROM glass_apps_all.tbl_param_metal_cost_param
				LIMIT 1";
		$res = $this->excQuery($sql);
		return $res[0]['tbl_param_metal_cost_param_cost'];		
	}
	
	
	/*
	* @getSectionIncludedItems( $topic_id )
	*
	*/
	public function getSectionIncludedItems( $topic_id,$type )
	{
		if( is_numeric( $topic_id ) && $type != "document" )
		{
			$typeIDs = $this->sectionTypeToInt($type);
			
			$typeID = explode(",",$typeIDs);
			
			
			$or = "";
			$and = " AND ";
			$where = " ( ";
			for( $i=0;$i<count($typeID);$i++ )
			{
				$where .= $or." prospectus_topics_items_item_type = '".$typeID[$i]."' ";
				$or = " OR ";
			}
			$where .= " ) ";
			
			if( strlen( $where ) <= 5 )
				$and = "";
			
			$sql = "SELECT count(*) AS myCount
					FROM prospectus_topics_items 
					WHERE prospectus_topics_items_section_id = '".$topic_id."' 
					$and $where ";
			$res = $this->excQuery($sql); 
			
			return $res[0]['myCount'];		
		}
		else if( is_numeric( $topic_id ) && $type == "document" )
		{
			$sql = "SELECT file_path,file_name
					FROM prospectus_topics_version2 
					WHERE topic_id = '".$topic_id."' ";
			$res = $this->excQuery($sql);
			
			if( strlen( $res[0]['file_name'] ) && file_exists( "../../../../ww/main/".$res[0]['file_name'] ) )
				return "1";
			else
				return "0";	
		}
	}
	
		
	
	public function sectionTypeToInt($type)
	{
		switch($type)
		{
			case "shapes":
				$typeID = 1;
				break;
			case "styles":
				$typeID = "2,3";
				break;
			case "photos":
				$typeID = "4,5";
				break;
			default:
				$typeID = "";		
				break;
		}
		return $typeID;
		
	}
	
	
	/*
	* @getCatalogIncludedSections( $topic_id )
	*
	*/
	public function getCatalogIncludedSections( $catalog_id )
	{
		if( is_numeric( $catalog_id ) )
		{
			$sql = "SELECT count(*) AS myCount
					FROM prospectus_link_ctopic 
					WHERE prospectus_link_ctopic_catalog_id = '".$catalog_id."' 
					";
			$res = $this->excQuery($sql); 
			
			return $res[0]['myCount'];		
		}
	}
	
	
	/*
	* @excQuery($sql)
	*
	* Δημιουργία options για select input
	*/
	public function createOptionsWithColorCMYK($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$cmykField)
	{
		$sql = "SELECT $fieldsID,$fieldsText,$cmykField
				FROM $table ";
		if( strlen($where) > 0 )		
			$sql .= " WHERE ".$where . " " ;
		$sql .= " ORDER BY $orderBy $descAsc ";	
		
		$res = mysql_query($sql,$this->conn_id);
		
		if( $res )
		{
			while( $row = mysql_fetch_array($res) )
			{
				if( $row[$fieldsID] == $SelectedID  )
					$selected = "selected";
				else
					$selected = "";
				
				$cmyk = $row[$cmykField];
						
				$option .= "<option value=\"".$row[$fieldsID]."\" $selected  style=\"background-color:".$cmyk."\" >".$row[$fieldsText]."</option>";	
			}
			
			return $option;
		}
		else
			return mysql_error();
		
	}
	
	
	/*
	* @getLeptomistion()
	*
	*/
	public function getLeptomistion()
	{
		$sql = "SELECT tbl_param_labourcost_per_min_salaries,
					   tbl_param_labourcost_per_min_hours
				FROM glass_apps_all.tbl_param_labourcost_per_min 
				ORDER BY tbl_param_labourcost_per_min_id DESC
				";
		$res = $this->excQuery($sql);
		
		$mint = ( $res[0]['tbl_param_labourcost_per_min_hours'] * 60 );
		if( $mint != 0 )
			$leptomisthio = ( $res[0]['tbl_param_labourcost_per_min_salaries']  / $mint );
		else
			$leptomisthio = 0;	
		
		return $leptomisthio;		
	}
	
	
	
	/*
	* @isShapeSet($shapeID)
	*
	*/
	/*
	public function isShapeSet($shapeID)
	{
		if( is_numeric( $shapeID ) )
		{
			$sql = "SELECT shape_set
					FROM tpp.general_table_tp
					WHERE gentable_id = '".$id."' ";
			$res = $this->excQuery($sql);

			if( $res[0]['shape_set'] == SET_ID )		
				$result = 1;
			else
				$result = 0;
			
			return $result;
		}
		else
			return 0;
	}
	*/
	
	
	/*
	* @isShapeReplacement($shapeID)
	*
	*/
	public function isShapeReplacement($shapeID)
	{
		if( is_numeric( $shapeID ) )
		{
			$sql = "SELECT shape_set
					FROM tpp.general_table_tp
					WHERE gentable_id = '".$id."' ";
			$res = $this->excQuery($sql);

			if( $res[0]['shape_set'] == REPLACEMENT_ID )		
				$result = 1;
			else
				$result = 0;
			
			return $result;
		}
		else
			return 0;
	}
	
	
	
	/*
	* @getPerceivedPososto($shapeID)
	*
	*/
	public function getPerceivedPososto($shapeID)
	{
		if( is_numeric( $shapeID ) )
		{
			$sql = "SELECT * 
					FROM tpp.general_table_tp 
					WHERE gentable_id = '".$shapeID."' ";
			$res = $this->excQuery($sql);		
			
			$root_shape_id = $res[0]['gentable_id'];
			$avrg_cm = round( ( $res[0]['object_cm2'] + $res[0]['kiln_cm2'] ) /2 );
			$perceived = $res[0]['perceived_cm2'];
			
			if(  $avrg_cm == 0 )
				 $avrg_cm = 1;
			
			$orioAveragePerceived = $avrg_cm - $perceived;
			$pososto = $orioAveragePerceived / $avrg_cm;
			
			return ($pososto * 100);
		}
		else
			return 0;
	}
	
	
	public function getShapeCm2($shapeID)
	{
		if( is_numeric( $shapeID ) )
		{
			$sql = "SELECT * 
					FROM tpp.general_table_tp 
					WHERE gentable_id = '".$shapeID."' ";
			$res = $this->excQuery($sql);		
			
			$root_shape_id = $res[0]['gentable_id'];
			$avrg_cm = round( ( $res[0]['object_cm2'] + $res[0]['kiln_cm2'] ) /2 );
			$perceived = $res[0]['perceived_cm2'];
			
			if(  $avrg_cm == 0 )
				 $avrg_cm = 1;
			
			$orioAveragePerceived = $avrg_cm - $perceived;
			$pososto = $orioAveragePerceived / $avrg_cm;
			
			if( $pososto > $this->getPerceivedOrio() && $pososto <=  $this->getPerceivedOrioTo() )//Orio Perceived
			{
				$perceived_new = $perceived * $this->getPerceivedAuxisi();	//Auksisi Perceived
				$avrg_cm = ( $perceived_new +  $res[0]['object_cm2'] +  $res[0]['kiln_cm2'] ) / 3;
			}
			else if( $pososto > $this->getPerceivedOrioSec() && $pososto <=  $this->getPerceivedOrioToSec() )
			{
				$perceived_new = $perceived * $this->getPerceivedAuxisiSec();	//Auksisi Perceived
				$avrg_cm = ( $perceived_new +  $res[0]['object_cm2'] +  $res[0]['kiln_cm2'] ) / 3;
			}
			else if( $pososto > $this->getPerceivedOrioThird() && $pososto <=  $this->getPerceivedOrioToThird() )
			{
				$perceived_new = $perceived * $this->getPerceivedAuxisiThird();	//Auksisi Perceived
				$avrg_cm = ( $perceived_new +  $res[0]['object_cm2'] +  $res[0]['kiln_cm2'] ) / 3;
			}
			else if( $pososto > $this->getPerceivedOrioFourth() && $pososto <=  $this->getPerceivedOrioToFourth() )
			{
				$perceived_new = $perceived * $this->getPerceivedAuxisiFourth();	//Auksisi Perceived
				$avrg_cm = ( $perceived_new +  $res[0]['object_cm2'] +  $res[0]['kiln_cm2'] ) / 3;
			}
			else if( $pososto > $this->getPerceivedOrioFiveth() && $pososto <=  $this->getPerceivedOrioToFiveth() )
			{
				$perceived_new = $perceived * $this->getPerceivedAuxisiFiveth();	//Auksisi Perceived
				$avrg_cm = ( $perceived_new +  $res[0]['object_cm2'] +  $res[0]['kiln_cm2'] ) / 3;
			}
			else if( $pososto > $this->getPerceivedOrioSixth() && $pososto <=  $this->getPerceivedOrioToSixth() )
			{
				$perceived_new = $perceived * $this->getPerceivedAuxisiSixth();	//Auksisi Perceived
				$avrg_cm = ( $perceived_new +  $res[0]['object_cm2'] +  $res[0]['kiln_cm2'] ) / 3;
			}
			else if( $pososto > $this->getPerceivedOrioSeventh() && $pososto <=  $this->getPerceivedOrioToSeventh() )
			{
				$perceived_new = $perceived * $this->getPerceivedAuxisiSeventh();	//Auksisi Perceived
				$avrg_cm = ( $perceived_new +  $res[0]['object_cm2'] +  $res[0]['kiln_cm2'] ) / 3;
			}
			else if( $pososto > $this->getPerceivedOrioEight() && $pososto <=  $this->getPerceivedOrioToEight() )
			{
				$perceived_new = $perceived * $this->getPerceivedAuxisiEight();	//Auksisi Perceived
				$avrg_cm = ( $perceived_new +  $res[0]['object_cm2'] +  $res[0]['kiln_cm2'] ) / 3;
			}
			
			
			
			
			$shape_difficulty_id = $this->getSomeDesc( $this->getShapeDifficultyGrade($root_shape_id), "tbl_param_shape_difficulty","tbl_param_shape_difficulty_id","tbl_param_shape_difficulty_grade" );
			
			$cm2 = $avrg_cm + ( $avrg_cm * $this->getSomeDesc( $shape_difficulty_id,"tbl_param_shape_difficulty","tbl_param_shape_difficulty_percent","tbl_param_shape_difficulty_id" )  + $avrg_cm * $this->getSomeDesc( $res[0]['aesthetics'],"tbl_param_shape_aesthetics","tbl_param_shape_aesthetics_percent","tbl_param_shape_aesthetics_id" ) );
			
			return $cm2;
		}
		else
			return 0;
	}
	
	
	
	public function getPerceivedOrio()
	{
		$sql = "SELECT tbl_param_shape_avrg_params_orio_perceived
				FROM tpp.tbl_param_shape_avrg_params ";
		$res = $this->excQuery($sql);
		return $res[0]['tbl_param_shape_avrg_params_orio_perceived'];
	}
	
	public function getPerceivedOrioTo()
	{
		$sql = "SELECT tbl_param_shape_avrg_params_orio_to
				FROM tpp.tbl_param_shape_avrg_params ";
		$res = $this->excQuery($sql);
		return $res[0]['tbl_param_shape_avrg_params_orio_to'];
	}
	
	public function getPerceivedOrioSec()
	{
		$sql = "SELECT tbl_param_shape_avrg_params_orio2_from
				FROM tpp.tbl_param_shape_avrg_params ";
		$res = $this->excQuery($sql);
		return $res[0]['tbl_param_shape_avrg_params_orio2_from'];
	}
	
	public function getPerceivedOrioToSec()
	{
		$sql = "SELECT tbl_param_shape_avrg_params_orio2_to
				FROM tpp.tbl_param_shape_avrg_params ";
		$res = $this->excQuery($sql);
		return $res[0]['tbl_param_shape_avrg_params_orio2_to'];
	}
	
	
	public function getPerceivedAuxisi()
	{
		$sql = "SELECT tbl_param_shape_avrg_params_auxisi_perceived
				FROM tpp.tbl_param_shape_avrg_params ";
		$res = $this->excQuery($sql);
		return $res[0]['tbl_param_shape_avrg_params_auxisi_perceived'];
	}
	
	public function getPerceivedAuxisiSec()
	{
		$sql = "SELECT tbl_param_shape_avrg_params_sec_auxisi_perc
				FROM tpp.tbl_param_shape_avrg_params ";
		$res = $this->excQuery($sql);
		return $res[0]['tbl_param_shape_avrg_params_sec_auxisi_perc'];
	}
	
	public function getPerceivedSecondAuxisi()
	{
		$sql = "SELECT tbl_param_shape_avrg_params_sec_auxisi_perc
				FROM tpp.tbl_param_shape_avrg_params ";
		$res = $this->excQuery($sql);
		return $res[0]['tbl_param_shape_avrg_params_sec_auxisi_perc'];
	}
	
	
	public function getPerceivedOrioThird()
	{
		$sql = "SELECT tbl_param_shape_avrg_params_orio3_from
				FROM tpp.tbl_param_shape_avrg_params ";
		$res = $this->excQuery($sql);
		return $res[0]['tbl_param_shape_avrg_params_orio3_from'];
	}
	
	public function getPerceivedOrioToThird()
	{
		$sql = "SELECT tbl_param_shape_avrg_params_orio3_to
				FROM tpp.tbl_param_shape_avrg_params ";
		$res = $this->excQuery($sql);
		return $res[0]['tbl_param_shape_avrg_params_orio3_to'];
	}
	
	public function getPerceivedAuxisiThird()
	{
		$sql = "SELECT tbl_param_shape_avrg_params_auxisi3
				FROM tpp.tbl_param_shape_avrg_params ";
		$res = $this->excQuery($sql);
		return $res[0]['tbl_param_shape_avrg_params_auxisi3'];
	}
	
	
	public function getPerceivedOrioFourth()
	{
		$sql = "SELECT tbl_param_shape_avrg_params_orio4_from
				FROM tpp.tbl_param_shape_avrg_params ";
		$res = $this->excQuery($sql);
		return $res[0]['tbl_param_shape_avrg_params_orio4_from'];
	}
	
	public function getPerceivedOrioToFourth()
	{
		$sql = "SELECT tbl_param_shape_avrg_params_orio4_to
				FROM tpp.tbl_param_shape_avrg_params ";
		$res = $this->excQuery($sql);
		return $res[0]['tbl_param_shape_avrg_params_orio4_to'];
	}
	
	public function getPerceivedAuxisiFourth()
	{
		$sql = "SELECT tbl_param_shape_avrg_params_auxisi4
				FROM tpp.tbl_param_shape_avrg_params ";
		$res = $this->excQuery($sql);
		return $res[0]['tbl_param_shape_avrg_params_auxisi4'];
	}
	
	public function getPerceivedOrioFiveth()
	{
		$sql = "SELECT tbl_param_shape_avrg_params_orio5_from
				FROM tpp.tbl_param_shape_avrg_params ";
		$res = $this->excQuery($sql);
		return $res[0]['tbl_param_shape_avrg_params_orio5_from'];
	}
	
	public function getPerceivedOrioToFiveth()
	{
		$sql = "SELECT tbl_param_shape_avrg_params_orio5_to
				FROM tpp.tbl_param_shape_avrg_params ";
		$res = $this->excQuery($sql);
		return $res[0]['tbl_param_shape_avrg_params_orio5_to'];
	}
	
	public function getPerceivedAuxisiFiveth()
	{
		$sql = "SELECT tbl_param_shape_avrg_params_auxisi5
				FROM tpp.tbl_param_shape_avrg_params ";
		$res = $this->excQuery($sql);
		return $res[0]['tbl_param_shape_avrg_params_auxisi5'];
	}
	
	
	//Sixth
	public function getPerceivedOrioSixth()
	{
		$sql = "SELECT tbl_param_shape_avrg_params_orio6_from
				FROM tpp.tbl_param_shape_avrg_params ";
		$res = $this->excQuery($sql);
		return $res[0]['tbl_param_shape_avrg_params_orio6_from'];
	}
	
	public function getPerceivedOrioToSixth()
	{
		$sql = "SELECT tbl_param_shape_avrg_params_orio6_to
				FROM tpp.tbl_param_shape_avrg_params ";
		$res = $this->excQuery($sql);
		return $res[0]['tbl_param_shape_avrg_params_orio6_to'];
	}
	
	public function getPerceivedAuxisiSixth()
	{
		$sql = "SELECT tbl_param_shape_avrg_params_auxisi6
				FROM tpp.tbl_param_shape_avrg_params ";
		$res = $this->excQuery($sql);
		return $res[0]['tbl_param_shape_avrg_params_auxisi6'];
	}
	
	//Seventh
	public function getPerceivedOrioSeventh()
	{
		$sql = "SELECT tbl_param_shape_avrg_params_orio7_from
				FROM tpp.tbl_param_shape_avrg_params ";
		$res = $this->excQuery($sql);
		return $res[0]['tbl_param_shape_avrg_params_orio7_from'];
	}
	
	public function getPerceivedOrioToSeventh()
	{
		$sql = "SELECT tbl_param_shape_avrg_params_orio7_to
				FROM tpp.tbl_param_shape_avrg_params ";
		$res = $this->excQuery($sql);
		return $res[0]['tbl_param_shape_avrg_params_orio7_to'];
	}
	
	public function getPerceivedAuxisiSeventh()
	{
		$sql = "SELECT tbl_param_shape_avrg_params_auxisi7
				FROM tpp.tbl_param_shape_avrg_params ";
		$res = $this->excQuery($sql);
		return $res[0]['tbl_param_shape_avrg_params_auxisi7'];
	}
	
	
	//Eight
	public function getPerceivedOrioEight()
	{
		$sql = "SELECT tbl_param_shape_avrg_params_orio8_from
				FROM tpp.tbl_param_shape_avrg_params ";
		$res = $this->excQuery($sql);
		return $res[0]['tbl_param_shape_avrg_params_orio8_from'];
	}
	
	public function getPerceivedOrioToEight()
	{
		$sql = "SELECT tbl_param_shape_avrg_params_orio8_to
				FROM tpp.tbl_param_shape_avrg_params ";
		$res = $this->excQuery($sql);
		return $res[0]['tbl_param_shape_avrg_params_orio8_to'];
	}
	
	public function getPerceivedAuxisiEight()
	{
		$sql = "SELECT tbl_param_shape_avrg_params_auxisi8
				FROM tpp.tbl_param_shape_avrg_params ";
		$res = $this->excQuery($sql);
		return $res[0]['tbl_param_shape_avrg_params_auxisi8'];
	}
	
	
	
	
	
	/*
	* @getTigerOfferTotal( $orderID )
	*
	*/
	public function getTigerOfferTotal( $orderID )
	{
		if( is_numeric( $orderID ) )
		{
			$sql = "SELECT *
					FROM wishbasket W 
					JOIN ordersgs O ON W.order_id = O.id
					LEFT JOIN price_shape_v3 P ON W.shape_id = P.shape_id
					
					WHERE O.id = '".$orderID."' ";
			$res = $this->excQuery($sql);
			
			$total = 0;
			for( $i=0;$i<count($res);$i++ )
			{
				$shape_id = $res[$i]['shape_id'];
				$header_discount = $res[$i]['header_discount'];
				
				
				$unitPrice = $res[$i]['priceM2'];
				if( $res[$i]['pattern_id'] == 185 && $res[$i]['first_color_id'] == 731 )
					$unitPrice = $res[$i]['priceM1'];
				$euro = $unitPrice;
				$fprice = $unitPrice - ( $unitPrice * ($res[$i]['header_discount']/100) );
				
				$total += ( $fprice * $res[$i]['quantity'] );
			}
			
			$total += $total * ( 1 - $res[0]['prepay']/ 100 ); 
			$total += $res[0]['transport_cost'];
			$total += $total * ( $res[0]['vat_percent'] /100 );
			
			return number_format($total,2,".",",");
					
		}
	}
	
	
	/*
	* @getMyGPOfferTotal( $orderID )
	*
	*/
	public function getMyGPOfferTotal( $orderID )
	{
		if( is_numeric( $orderID ) )
		{
			return 1;
		}
		else
			return 0;
	}
	
	
	/*
	* @getMGPPalletTotalPcs($header_id,$orderNo)
	*
	*/
	public function getMGPPalletTotalPcs($header_id,$orderNo)
	{
		if( is_numeric( $header_id ) )
		{
			$sql = "SELECT sum(tbl_req_carton_detail_qty) AS totalPCs
					FROM tbl_req_carton_header H
					JOIN tbl_req_carton_detail D ON H.tbl_req_carton_header_id = D.tbl_req_carton_detail_header_id
					
					WHERE tbl_req_carton_header_entries_header_id = '".$header_id."' 
					AND tbl_req_carton_detail_header_id != '0' 
					AND tbl_req_carton_detail_order_no = '".$orderNo."'
					AND tbl_req_carton_header_pallet_id IS NOT NULL ";
			$res = $this->excQuery($sql);
			
			return $res[0]['totalPCs'];		
		}
	}
	
	
	/*
	* @getMGPPalletTotalWeight($header_id,$orderNo)
	*
	*/
	public function getMGPPalletTotalWeight($header_id,$orderNo)
	{
		if( is_numeric( $header_id ) )
		{
			$sql = "SELECT tbl_req_carton_detail_item,tbl_req_carton_detail_qty
					FROM tbl_req_carton_header H
					JOIN tbl_req_carton_detail D ON H.tbl_req_carton_header_id = D.tbl_req_carton_detail_header_id
					
					WHERE tbl_req_carton_header_entries_header_id = '".$header_id."' 
					AND tbl_req_carton_detail_header_id != '0' 
					AND tbl_req_carton_detail_order_no = '".$orderNo."'
					AND tbl_req_carton_header_pallet_id IS NOT NULL ";
			$res = $this->excQuery($sql);
			
			$totalWeight = 0;
			$totalVolume = 0;
			for( $i=0;$i<count($res);$i++ )
			{
				$entries_detail_item = $this->getSomeDesc( $res[$i]['tbl_req_carton_detail_item'],"tbl_req_order_entries_detail","tbl_req_order_entries_detail_item","tbl_req_order_entries_detail_id");
						
						//Get Masterpack weight
						$sql = "SELECT tbl_ts_4code_weight,tbl_ts_4code_masterpack_pcs,tbl_ts_4code_volume
								FROM tbl_ts_4code
								WHERE tbl_ts_4code_4code = '".$entries_detail_item."' ";
						$res_mw = $this->excQuery($sql);
						$mastVolume = $res_mw[0]['tbl_ts_4code_volume'];
						$mastWeight = ( $res_mw[0]['tbl_ts_4code_weight'] * $res_mw[0]['tbl_ts_4code_masterpack_pcs'] );
						
						$totalWeight += $mastWeight;
						$totalVolume += $mastVolume;
			}
			$resTable = array();
			$resTable[0] = $totalWeight;
			$resTable[1] = $totalVolume;
			return $resTable;		
		}
	}
	
	
	/*
	* @changeKomaToNull($value,$setValue)
	*
	*/
	public function changeKomaToNull($value,$setValue)
	{
		if( strlen( $value ) )
		{
			$value = str_replace(",","",$value);
			if( ! is_numeric( $value ) )
				return $setValue;
			else
				return $value;	
			
		}
		else
			return $setValue;
	}
	
	
	/*
	* @hasThisUserPrivilageInThisForm($userID,$fomrGroupID)
	*
	*/
	public function hasThisUserPrivilageInThisForm($userID,$formGroupID)
	{
		if( is_numeric($userID) && is_numeric($formGroupID) )
		{
			$sql_g = "SELECT tbl_sys_link_user_group_id
				  	  FROM tbl_sys_link_user_group LG
				
					  WHERE tbl_sys_link_user_group_group_id = '".$formGroupID."'  
					  AND tbl_sys_link_user_group_user_id = '".$userID."'
					 ";
			$res_g = $this->excQuery($sql_g);
		
			if( is_numeric( $res_g[0]['tbl_sys_link_user_group_id'] ) )		
				return true;
			else
				return false;
		}		
	}
	
	/*
	* @getUsersFormsLinkID($userID,$fomrGroupID)
	*
	*/
	public function getUsersFormsLinkID($userID,$formGroupID)
	{
		if( is_numeric($userID) && is_numeric($formGroupID) )
		{
			$sql_g = "SELECT tbl_sys_link_user_group_id
				  	  FROM tbl_sys_link_user_group LG
				
					  WHERE tbl_sys_link_user_group_group_id = '".$formGroupID."'  
					  AND tbl_sys_link_user_group_user_id = '".$userID."'
					 ";
			$res_g = $this->excQuery($sql_g);
		
			if( is_numeric( $res_g[0]['tbl_sys_link_user_group_id'] ) )		
				return $res_g[0]['tbl_sys_link_user_group_id'];
			else
				return "";
		}		
	}
	
	
	/*
	* @hasThisGroupThisForm( $group_id, $formID)
	*
	*/
	public function hasThisGroupThisForm( $group_id, $formID)
	{
		if( is_numeric($group_id) && is_numeric($formID) )
		{
			$sql = "SELECT tbl_sys_panel_form_id
					FROM tbl_sys_panel_form
					WHERE tbl_sys_panel_form_id = '".$formID."'  
					AND tbl_sys_panel_form_priv_id = '".$group_id."' ";
			$res = $this->excQuery($sql);
			
			if( is_numeric( $res[0]['tbl_sys_panel_form_id'] ) && $res[0]['tbl_sys_panel_form_id'] > 0 )		
				return true;
			else
				return false;
		}
		else
			return false;
	}
	
	
	/*
	* @hasThisGroupThisForm_v2( $dpt_id, $authorityID)
	*
	*/
	public function hasThisGroupThisForm_v2( $dpt_id, $authorityID)
	{
		if( is_numeric($dpt_id) && is_numeric($authorityID) )
		{
			$sql = "SELECT tbl_sys_link_dpt_authority_id
					FROM tbl_sys_link_dpt_authority
					WHERE tbl_sys_link_dpt_authority_auth_id = '".$authorityID."'  
					AND tbl_sys_link_dpt_authority_dpt_id = '".$dpt_id."' ";
			$res = $this->excQuery($sql);
			
			if( is_numeric( $res[0]['tbl_sys_link_dpt_authority_id'] ) && $res[0]['tbl_sys_link_dpt_authority_id'] > 0 )		
				return true;
			else
				return false;
		}
		else
			return false;
	}
	
	
	/*
	* @getGroupFormsLinkID( $group_id, $formID)
	*
	*/
	public function getGroupFormsLinkID( $group_id, $formID)
	{
		if( is_numeric($group_id) && is_numeric($formID) )
		{
			$sql = "SELECT tbl_sys_panel_form_id
					FROM tbl_sys_panel_form
					WHERE tbl_sys_panel_form_id = '".$formID."'  
					AND tbl_sys_panel_form_priv_id = '".$group_id."' ";
			$res = $this->excQuery($sql);
			
			if( is_numeric( $res[0]['tbl_sys_panel_form_id'] ) && $res[0]['tbl_sys_panel_form_id'] > 0 )		
				return $res[0]['tbl_sys_panel_form_id'];
			else
				return "";
		}
		else
			return "";
	}
	
	
	/*
	* @getGroupFormsLinkID_v2( $dpt_id, $authorityID)
	*
	*/
	public function getGroupFormsLinkID_v2( $dpt_id, $authorityID)
	{
		if( is_numeric($dpt_id) && is_numeric($authorityID) )
		{
			$sql = "SELECT tbl_sys_link_dpt_authority_id
					FROM tbl_sys_link_dpt_authority 
					WHERE tbl_sys_link_dpt_authority_auth_id = '".$authorityID."'  
					AND tbl_sys_link_dpt_authority_dpt_id = '".$dpt_id."' ";
			$res = $this->excQuery($sql);
			
			if( is_numeric( $res[0]['tbl_sys_link_dpt_authority_id'] ) && $res[0]['tbl_sys_link_dpt_authority_id'] > 0 )		
				return $res[0]['tbl_sys_link_dpt_authority_id'];
			else
				return "";
		}
		else
			return "";
	}
	
	
	/*
	* @getTotalProgramCm2()
	*
	* Α ρε Χασάπη......
	*/
	public function getTotalProgramCm2()
	{
		$sql = "SELECT sum(tbl_temp_program_cm2_total_cm2) AS totalCm2
				FROM glass_apps_all.tbl_temp_program_cm2
				";
		//WHERE tbl_temp_program_cm2_confirm = '1'		
		$res_sum = $this->excQuery($sql);
		$result = number_format($res_sum[0]['totalCm2'],0,",","." );
		
		return $result;

	}
	
	
	/*
	* @getTotalProgramCm2()
	*
	* Α ρε Χασάπη......
	*/
	public function clearTempProgramCm2()
	{
		$sql = "DELETE FROM glass_apps_all.tbl_temp_program_cm2
				WHERE 1";
		$res = mysql_query($sql) or die( mysql_error() );		
	}
	
	
	public function getTeampProgramDate()
	{
		$sql = "SELECT tbl_pp_temp_date_date
				FROM tbl_pp_temp_date 
				LIMIT 1";
		$res = $this->excQuery($sql);
		
		return $res[0]['tbl_pp_temp_date_date'];
			
	}
	
	public function getTeampProgramDate_BG()
	{
		$sql = "SELECT tbl_bg_pp_temp_date_date
				FROM tbl_bg_pp_temp_date 
				LIMIT 1";
		$res = $this->excQuery($sql);
		
		return $res[0]['tbl_bg_pp_temp_date_date'];
			
	}
	
	
	/*
	* @getTotalProgramCm2_BG()
	*
	*/
	public function getTotalProgramCm2_BG()
	{
		$sql = "SELECT sum(tbl_bg_temp_program_cm2_total_cm2) AS totalBGCm2
				FROM glass_apps_all.tbl_bg_temp_program_cm2
				WHERE tbl_bg_temp_program_cm2_confirm = '1'
				";
		$res_sum = $this->excQuery($sql);
		$result = number_format($res_sum[0]['totalBGCm2'],0,".","," );
		
		return $result;

	}
	
	
	/*
	* @getSetCm2( $shape_id )
	*
	*/
	public function getSetCm2( $shape_id )
	{
		if( is_numeric($shape_id) )
		{
			//Get Replacements
			$sql = "SELECT *
					FROM tpp.shape_set SHS
					INNER JOIN tpp.shape_set_link LSHS ON SHS.shape_set_id = LSHS.shape_set_link_set_id
									
					WHERE SHS.shape_set_setshape_id = '".$shape_id."'";
			$res = $this->excQuery($sql);
			$setTotalCm2 = 0;
			$rpl_cm2 = 0;
			for( $i=0;$i<count($res);$i++ )		
			{
				$rpl_cm2 = $this->getShapeCm2($res[$i]['shape_set_link_shape_id']); //$res_shs[$i]['textcm2']
				$setTotalCm2 += ( $rpl_cm2*$res[$i]['shape_set_link_qty'] );
			}
			
			return $setTotalCm2;
		}
		else
			return 0;
		
	}
	
	
	/*
	* @getSetObjectCm2( $shape_id )
	*
	*/
	public function getSetObjectCm2( $shape_id )
	{
		if( is_numeric($shape_id) )
		{
			//Get Replacements
			$sql = "SELECT *
					FROM tpp.shape_set SHS
					INNER JOIN shape_set_link LSHS ON SHS.shape_set_id = LSHS.shape_set_link_set_id
					LEFT JOIN general_table_tp G ON LSHS.shape_set_link_shape_id = G.gentable_id
									
					WHERE SHS.shape_set_setshape_id = '".$shape_id."'";
			$res = $this->excQuery($sql);
			$setTotalObjectCm2 = 0;
			$rpl_Objcm2 = 0;
			
			for( $i=0;$i<count($res);$i++ )		
			{
				$rpl_Objcm2 =  $res[$i]['object_cm2'];//$this->getShapeCm2($res[$i]['shape_set_link_shape_id']); //$res_shs[$i]['textcm2']
				$setTotalObjectCm2 += ( $rpl_Objcm2*$res[$i]['shape_set_link_qty'] );
			}
			
			return $setTotalObjectCm2;
		}
		else
			return 0;
		
	}
	
	
	/*
	* @getSetJoinShapeStatus($shape_id)
	*
	*/
	public function getSetJoinShapeStatus($shape_id)
	{
		if( is_numeric( $shape_id ) )
		{
			$sql = "SELECT G.joins_status AS joins_status
					FROM tpp.shape_set S 
					LEFT JOIN shape_set_link L ON S.shape_set_id = L.shape_set_link_set_id 
					LEFT JOIN general_table_tp G ON L.shape_set_link_shape_id = G.gentable_id
					
					WHERE S.shape_set_setshape_id = '".$shape_id."' ";
			$res = $this->excQuery($sql);
			$results = "False";
			for($i=0;$i<count($res);$i++)			
			{
				if( $res[$i]['joins_status'] == "False" )
				{
					$results = "False";
					break;
				}
				elseif( $res[$i]['joins_status'] == "True" )
					$results = "True";
			}
			
			return $results;
		}
		else
			return "True";
	}
	
	
	/*
	* @getBrandShapes($brand)
	*
	*/
	public function getBrandShapes($brand)
	{
		$sql = "SELECT gentable_id
				FROM general_table_tp G 
				JOIN shape_link_select_shape L ON G.gentable_id = L.shape_link_select_shape_id 
				
				WHERE L.shape_link_select_select_id = '".$brand."' ";
		$res = $this->excQuery($sql);
		$ids = "";
		$koma = "";
		for($i=0;$i<count($res);$i++)
		{
			$ids .= $koma.$res[$i]['gentable_id'];
			$koma = ",";
		}
		
		return $ids;		
	}
	
	
	/*
	* @getBrandPatterns($brand)
	*
	*/
	public function getBrandPatterns($brand)
	{
		$sql = "SELECT P.id AS id
				FROM Patterns P 
				JOIN pattern_link_select L ON P.id = L.pattern_link_select_pattern_id 
				
				WHERE L.pattern_link_select_select_id = '".$brand."' ";
		$res = $this->excQuery($sql);
		$ids = "";
		$koma = "";
		for($i=0;$i<count($res);$i++)
		{
			$ids .= $koma.$res[$i]['id'];
			$koma = ",";
		}
		
		return $ids;		
	}
	
	
	/*
	* @getBrandColors($brand)
	*
	*/
	public function getBrandColors($brand)
	{
		$sql = "SELECT color_id
				FROM prototype_colors P 
				JOIN root_color_link_select L ON P.color_id = L.root_color_link_select_color_id 
				
				WHERE L.root_color_link_select_select_id = '".$brand."' ";
		$res = $this->excQuery($sql);
		$ids = "";
		$koma = "";
		for($i=0;$i<count($res);$i++)
		{
			$ids .= $koma.$res[$i]['color_id'];
			$koma = ",";
		}
		
		return $ids;		
	}
	
	
	/*
	* @getMetalStages( $metal_id )
	*
	*/
	public function getMetalStages( $metal_id )
	{
		if( is_numeric( $metal_id ) )
		{
			$sql = "SELECT COUNT(*) AS stagesNums
					FROM tbl_ts_link_metal_vafi_category
					WHERE tbl_ts_link_metal_vafi_category_metal_id = '".$metal_id."'  
					ORDER BY tbl_ts_link_metal_vafi_category_id
					";
			$res = $this->excQuery($sql);
			$stagesNum = $res[0]['stagesNums'];		
			
			return $stagesNum;
		}
	}
	
	
	/*
	* @getMetalStagesName( $metal_id,$stages_no )
	*
	*/
	public function getMetalStagesName( $metal_id,$stages_id )
	{
		if( is_numeric( $metal_id ) )
		{
			$sql = "SELECT C.tbl_param_metal_vafi_category_text
					FROM tbl_ts_link_metal_vafi_category LC
					JOIN tbl_param_metal_vafi_category C ON LC.tbl_ts_link_metal_vafi_category_category_id = C.tbl_param_metal_vafi_category_id
					
					WHERE tbl_ts_link_metal_vafi_category_metal_id = '".$metal_id."'  
					AND tbl_ts_link_metal_vafi_category_category_id = '".$stages_id."'
					ORDER BY tbl_ts_link_metal_vafi_category_id
					
					
					";
			$res = $this->excQuery($sql);
			$stagesName = $res[0]['tbl_param_metal_vafi_category_text'];		
			
			return $stagesName;
		}
	}
	
	
	/*
	* @getMetalStagesIDs( $metal_id,$stages_no )
	*
	*/
	public function getMetalStagesIDs( $metal_id,$stages_no )
	{
		if( is_numeric( $metal_id ) )
		{
			$sql = "SELECT LC.tbl_ts_link_metal_vafi_category_category_id
					FROM tbl_ts_link_metal_vafi_category LC
					
					
					WHERE tbl_ts_link_metal_vafi_category_metal_id = '".$metal_id."'  
					
					
					LIMIT ".($stages_no)." , 1
					";
			$res = $this->excQuery($sql);
			$stagesID = $res[0]['tbl_ts_link_metal_vafi_category_category_id'];		
			
			return $stagesID;
		}
	}
	
	
	
	/*
	* @getTotalCIF($eur,$kg,$gross_weight,$dim_weight )
	*
	*/
	public function getTotalCIF($eur,$kg,$gross_weight,$dim_weight )
	{
		if( $eur > 0 )
			return $eur;
		else if( $eur <= 0 && $kg > 0 )	
		{
			if( $gross_weight > $dim_weight )
				return ($kg * $gross_weight);
			else
				return ($kg * $dim_weight);	
		}
		else
			return 0;
	}
	
	
	/*
	* @getTotalDDP($eur,$perCent,$order_amount )
	*
	*/
	public function getTotalDDP($eur,$perCent,$order_amount )
	{
		if( $eur > 0 )
			return $eur;
		else if( $eur <= 0 && $perCent > 0 )	
		{
			return ( ($perCent/100) * $order_amount);	
		}
		else
			return 0;
	}
	
	/*
	* @create4Code($shapeCode,$patternCode,$color1Code,$color2Code,$metalCharStr,$plusText,$customer_id)
	*
	*/
	public function create4Code($shapeID,$patternID,$color1ID,$color2ID,$metalCharID,$plusID,$customer_id)
	{
		$shapeCode = $this->getSomeDesc($shapeID,"tpp.general_table_tp","3code","gentable_id");
		$patternCode = $this->getSomeDesc($patternID,"tpp.Patterns","code","id");
		$color1Code = $this->getSomeDesc($color1ID,"tpp.prototype_colors","color_code","color_id");
		$color2Code = $this->getSomeDesc($color2ID,"tpp.prototype_colors","color_code","color_id");
		
		$metalCharStr = $this->getSomeDesc( $metalCharID,"glass_apps_all.tbl_param_metal_vafi","tbl_param_metal_vafi_text","tbl_param_metal_vafi_id");
	
		$plusText = "";
		if( $plusID > 0 && is_numeric( $plusID ) )
		{
			$plusText = $this->getSomeDesc( $plusID,"glass_apps_all.tbl_param_plus","tbl_param_plus_text","tbl_param_plus_id" );
		}		
	
		$code4 = $shapeCode;
		if( strlen($patternCode) )
			$code4 .= "-".$patternCode;
		if( strlen($color1Code) && strlen($patternCode) )
			$code4 .= $color1Code;
		else if( strlen($color1Code) )		
			$code4 .= "-".$color1Code;
	
		if( strlen($color2Code) && ( strlen($color1Code) || strlen($patternCode) ) )
			$code4 .= $color2Code;		
		else if( strlen($color2Code) )	
			$code4 .= "-".$color2Code;	
	
		if( strlen($metalCharStr) && ( strlen($patternCode) || strlen($color1Code) || strlen($color2Code) ) )	
			$code4 .= "-".$metalCharStr;		
		else if( strlen($metalCharStr) )
			$code4 .= "-".$metalCharStr;			
	
		if( strlen($plusText) )	
			$code4 .= "-".$plusText;
		if( strlen($customer_id) )
			$code4 .= "/".$customer_id;
			
		return 	$code4;
	}
	
	
	/*
	* @excQuery($sql)
	*
	* Δημιουργία options για select input
	*/
	public function createOptionsMetalVafi($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc)
	{
		$sql = "SELECT $fieldsID,$fieldsText, tbl_param_metal_vafi_category_text
				FROM glass_apps_all.tbl_param_metal_vafi MV
				LEFT JOIN glass_apps_all.tbl_ts_link_vafi_category_vafi LCV ON MV.tbl_param_metal_vafi_id = LCV.tbl_ts_link_vafi_category_vafi_vafi_id
				LEFT JOIN glass_apps_all.tbl_param_metal_vafi_category MC ON LCV.tbl_ts_link_vafi_category_vafi_category_id = MC.tbl_param_metal_vafi_category_id
				
				";
		if( strlen($where) > 0 )		
			$sql .= " WHERE ".$where . " " ;
		$sql .= " ORDER BY $orderBy $descAsc";	
		
		$res = mysql_query($sql,$this->conn_id);
		
		if( $res )
		{
			while( $row = mysql_fetch_array($res) )
			{
				if( $row[$fieldsID] == $SelectedID  )
					$selected = "selected";
				else
					$selected = "";	
				$option .= "<option value=\"".$row[$fieldsID]."\" $selected>".$row[$fieldsText]." | ".$row['tbl_param_metal_vafi_category_text']."</option>";	
			}
			
			return $option;
		}
		else
			return mysql_error();
		
	}
	
	
	/*
	* @getMetalCurrentInventory($metalID,$companyID)
	*
	*/
	public function getMetalCurrentInventory($metalID,$companyID)
	{
		if( is_numeric( $metalID ) )
		{
			//Metal Inventory
			$sql = "SELECT tbl_ts_inventory_metals_qty 
					FROM tbl_ts_inventory_metals
					WHERE tbl_ts_inventory_metals_metal_id = '".$metalID."'
					AND tbl_ts_inventory_metals_supplier = '".$companyID."'
					
					ORDER BY tbl_ts_inventory_metals_date DESC
					LIMIT 1
					";
			$res = $this->excQuery($sql);		
			$currentInv = $res[0]['tbl_ts_inventory_metals_qty'];
			
			//Metal Consum
			$sql = "SELECT  SUM(tbl_ts_metal_cons_qty) AS consSum
				 	FROM tbl_ts_metal_cons
					WHERE tbl_ts_metal_cons_metal_id = '".$metalID."'
					AND tbl_ts_metal_cons_company_id = '".$companyID."'
				   ";
			$res = $this->excQuery($sql);
			$currentInv -= $res[0]['consSum'];	   
			
			return $currentInv;
			
		}
		else 
			return 0;
	}
	
	
	/*
	* @subDates( $date1,$date2 )
	*
	*/
	public function subDates( $date1,$date2 )
	{
		$dateT1 = array();
		$dateT1 = explode("-",$date1);
		$date1_day = $dateT1[2];	//substr($date1,8,2);
		$date1_month = $dateT1[1]; //substr($date1,5,2);
		
		if( $dateT1[0] < 2000 ) $dateT1[0] + 2000;
		
		$date1_year = $dateT1[0]; //substr($date1,0,4);
		//echo "date1_year:".$date1_year;
		
		$dateT = array();
		$dateT = explode("-",$date2);
		$date2_day = $dateT[2];//substr($date2,8,2);
		$date2_month = $dateT[1];//substr($date2,5,2);
		$date2_year = $dateT[0]; //substr($date2,0,4);
		//echo "date2_year:".$date2_year;
		
		$date3_year = $date1_year - $date2_year; //0
		$date3_month = $date1_month - $date2_month; //0
		if( $date3_month < 0  )
		{
			$date3_year--;
			$date3_month2 = 12 + $date3_month; //p.x. 12 + (-2) 
			$date3_month = $date3_month2;
		}
		
		$date3_day = $date1_day - $date2_day;
		
		if( $date3_day < 0 )
		{
			$date3_month--;
			$date3_day2 = (30 + $date3_day);
			$date3_day = $date3_day2;
			
			if( $date3_month < 0  )
			{
				$date3_year--;
				$date3_month2 = 12 + $date3_month; //p.x. 12 + (-2) 
				$date3_month = $date3_month2;
			}
		}
		
		//$date3_year = $date3_year - 2000;
		
		$daysFromShip = $date3_day + (30*$date3_month);
		if( $date3_year > 0 )
			$daysFromShip += ( ($date3_year * 12 ) * 30 );
		
		return $daysFromShip;
	}
	
	
	/*
	* @getMetalDesiredQty( $metal_id )
	*
	*/
	public function getMetalDesiredQty( $metal_id )
	{
		if( is_numeric( $metal_id ) )
		{
			//Get Metal Cost
			$metalCost = $this->getMetalPriceList($metal_id);
			//Get metal DesiredQty
			$sql = "SELECT tbl_param_metal_desired_qty
					FROM tbl_param_metal_desired 
					WHERE '".$metalCost."' BETWEEN tbl_param_metal_desired_price_min AND tbl_param_metal_desired_price_max ";		
			$resD = $this->excQuery($sql);
			
			return $resD[0]['tbl_param_metal_desired_qty'];		
		}
		else 
			return 0;
	}
	
	/*
	* @getOrderChoosenColores($order_id)
	*
	*/
	public function getOrderChoosenColores($order_id)
	{
		if( is_numeric( $order_id ) )
		{
			$sql = "SELECT tbl_temp_colorpattern_item_id
					FROM tpp.tbl_temp_colorpattern
					WHERE tbl_temp_colorpattern_order_id = '".$order_id."'
					AND tbl_temp_colorpattern_item_type = '3' ";
			$res = $this->excQuery($sql);
			$koma = "";
			$colorIDs = "";
			for( $i=0;$i<count($res);$i++ )		
			{
				$colorIDs .= $koma.$res[$i]['tbl_temp_colorpattern_item_id'];
				$koma = ",";
			}
		}
		return $colorIDs;
			
	}
	
	/*
	* @shapeMatchingPattern($patternID)
	*
	*/
	public function shapeMatchingPattern($patternID,$shapeID)
	{
		if( is_numeric($patternID) )
		{
			//Get Pattern Technique
			$sql = "SELECT tbtech4_unique,sr_glue_id
					FROM Patterns
					WHERE id = '".$patternID."'
					
					";
			$res = $this->excQuery($sql);
			$pTech = $res[0]['tbtech4_unique'];	
			if( !is_numeric($pTech) )	
			{
				return false;
			}

			$sql = "SELECT G.gentable_id AS gentable_id ,TSHP.tbl_ts_shape_ts_glue_nontransp
					FROM tbl_param_technic_shapes_group_link_technic LGT 
					
					INNER JOIN tbl_param_technic_shapes_group GT ON LGT.tbl_param_technic_shapes_group_link_technic_group_id = GT.tbl_param_technic_shapes_group_id 
					
					INNER JOIN general_table_tp G ON LGT.tbl_param_technic_shapes_group_link_technic_group_id = G.gentable_technic_group_id 
		
					LEFT JOIN glass_apps_all.tbl_ts_shape_ts TSHP ON G.gentable_id = TSHP.tbl_ts_shape_ts_shape_id
		
					WHERE tbl_param_technic_shapes_group_link_technic_technic_id = '".$pTech."' 
					AND gentable_id = '".$shapeID."'
					AND tbl_ts_shape_ts_glue_nontransp != '5'
					
					";
				
					
			$res_sh = $this->excQuery($sql);		
			
			if( is_numeric( $res_sh[0]['gentable_id'] ) && $res_sh[0]['gentable_id'] > 0 )
			{
				return true;
			}
			else
				return false;

		}
		else return false;
	}
	
	/*
	* @shapeMatchingPattern_v2($patternID)
	*
	* checks Set shapes too
	*/
	public function shapeMatchingPattern_v2($patternID,$shapeID)
	{
		$shape_set = $this->getSomeDesc($shapeID,"tpp.general_table_tp","shape_set","gentable_id");
		//echo "<br>".$shape_set." shape:".$shapeID;
		if( $shape_set!= SET_ID ) //It isn set
		{
			if( is_numeric($patternID) )
			{
				//Get Pattern Technique
				$sql = "SELECT tbtech4_unique,sr_glue_id
						FROM Patterns
						WHERE id = '".$patternID."'
					";
				$res = $this->excQuery($sql);
				$pTech = $res[0]['tbtech4_unique'];	
				if( !is_numeric($pTech) )	
				{
					return false;
				}

				$sql = "SELECT G.gentable_id AS gentable_id ,TSHP.tbl_ts_shape_ts_glue_nontransp
						FROM tbl_param_technic_shapes_group_link_technic LGT 
					
						INNER JOIN tbl_param_technic_shapes_group GT ON LGT.tbl_param_technic_shapes_group_link_technic_group_id = GT.tbl_param_technic_shapes_group_id 
					
						INNER JOIN general_table_tp G ON LGT.tbl_param_technic_shapes_group_link_technic_group_id = G.gentable_technic_group_id 
		
						LEFT JOIN glass_apps_all.tbl_ts_shape_ts TSHP ON G.gentable_id = TSHP.tbl_ts_shape_ts_shape_id
		
						WHERE tbl_param_technic_shapes_group_link_technic_technic_id = '".$pTech."' 
						AND gentable_id = '".$shapeID."'
						AND tbl_ts_shape_ts_glue_nontransp != '5'
						
						";
				
					
					$res_sh = $this->excQuery($sql);		
			
					if( is_numeric( $res_sh[0]['gentable_id'] ) && $res_sh[0]['gentable_id'] > 0 )
					{
						return true;
					}
					else
						return false;
	
			}
				else return false;
		}//end of it isnt set
		else if( $shape_set == SET_ID )//it is set
		{
			if( is_numeric($patternID) )
			{
				//Get Pattern Technique
				$sql = "SELECT tbtech4_unique,sr_glue_id
						FROM Patterns
						WHERE id = '".$patternID."'
					
					";
				$res = $this->excQuery($sql);
				$pTech = $res[0]['tbtech4_unique'];	
				if( !is_numeric($pTech) )	
				{
					return false;
				}

				$sql = "SELECT G.gentable_id AS gentable_id ,TSHP.tbl_ts_shape_ts_glue_nontransp
						
						FROM shape_set SST 
						INNER JOIN shape_set_link SSTL ON SST.shape_set_id = SSTL.shape_set_link_set_id
						
						INNER JOIN general_table_tp G ON SSTL.shape_set_link_shape_id = G.gentable_id
						
						INNER JOIN tbl_param_technic_shapes_group GT ON G.gentable_technic_group_id = GT.tbl_param_technic_shapes_group_id
						
						INNER JOIN tbl_param_technic_shapes_group_link_technic LGT ON GT.tbl_param_technic_shapes_group_id = LGT.tbl_param_technic_shapes_group_link_technic_group_id
						
						
						LEFT JOIN glass_apps_all.tbl_ts_shape_ts TSHP ON G.gentable_id = TSHP.tbl_ts_shape_ts_shape_id
		
						WHERE tbl_param_technic_shapes_group_link_technic_technic_id = '".$pTech."' 
						AND SST.shape_set_setshape_id = '".$shapeID."'
						AND ( TSHP.tbl_ts_shape_ts_glue_nontransp != '5' OR TSHP.tbl_ts_shape_ts_glue_nontransp IS NULL )	
						AND G.only_metal = 'False'
						";
					
					//echo $sql;
					
					$res_sh = $this->excQuery($sql);		
					$ginetai = false; //den ginetai to join me to set
					
					//Ean o sunolikos arithmos ton replacements einai isos me ton arithmo toy count($res_sh) tote ginetai to join me to set
					//Allios den ginetai
					
					$sql = "SELECT count(shape_set_id) AS cntRplcmnts
							FROM shape_set SST 
							INNER JOIN shape_set_link SSTL ON SST.shape_set_id = SSTL.shape_set_link_set_id
							INNER JOIN general_table_tp G ON SSTL.shape_set_link_shape_id = G.gentable_id
							WHERE SST.shape_set_setshape_id = '".$shapeID."'
							AND G.only_metal = 'False'
						 ";
					$res_cntr = $this->excQuery($sql);
					$countRplacmnts = $res_cntr[0]['cntRplcmnts'];
			
					if( $countRplacmnts == count($res_sh) )
					{
						return true;
					}
					else
						return false;
	
			}
			else return false;
		}//end of else if is set
	}
	
	
	/*
	* @getOfferIncludedPatternsColors( $order_id )
	*
	*/
	public function getOfferIncludedPatternsColors( $order_id )
	{
		if( is_numeric( $order_id ) )
		{
			$sql = "SELECT count(*) AS myCount
					FROM tbl_temp_colorpattern
					WHERE tbl_temp_colorpattern_order_id = '".$order_id."' 
					AND tbl_temp_colorpattern_item_id != 0 ";
			$res = $this->excQuery($sql);
			
			return $res[0]['myCount'];		
		}
	}
	
	
	/*
	* @getOfferIncludedShapes( $order_id )
	*
	*/
	public function getOfferIncludedShapes( $order_id )
	{
		if( is_numeric( $order_id ) )
		{
			$sql = "SELECT count(*) AS myCount
					FROM tbl_temp_offergs_shape
					WHERE tbl_temp_offergs_shape_order_id = '".$order_id."' 
					AND tbl_temp_offergs_shape_item_id != 0 ";
			$res = $this->excQuery($sql);
			
			return $res[0]['myCount'];		
		}
	}
	
	
	/*
	* @getShapeCombsCount( $shape_id,$order_id )
	*
	*/
	public function getShapeCombsCount( $shape_id,$order_id )
	{
		$sql = "SELECT count(*) AS myCount
				FROM wishbasket
				WHERE shape_id = '".$shape_id."'
				AND order_id = '".$order_id."'  ";	
		$res = $this->excQuery($sql);
		
		return $res[0]['myCount'];		
	}
	
	
	/*
	* @get4CodeMasterPackPcs($fcode_id,$brand_id)
	*
	*/
	public function get4CodeMasterPackPcs($fcode_id,$brand_id)
	{
		//Get Masterpack pcs
		$sql = "SELECT tbl_ts_4code_link_packaging_mast_pcs
				FROM glass_apps_all.tbl_ts_4code_link_packaging
				WHERE tbl_ts_4code_link_packaging_4code_id = '".$fcode_id."' 
				AND tbl_ts_4code_link_packaging_select_id = '".$brand_id."' ";
		$res_mstr = $this->excQuery($sql);		
		$fourCode_ts_masterpack_pcs = 0;
		for( $m=0;$m<count($res_mstr);$m++ )
		{
			$fourCode_ts_masterpack_pcs += $res_mstr[$m]['tbl_ts_4code_link_packaging_mast_pcs'];
		}	
		
		return $fourCode_ts_masterpack_pcs;
	}	
	
	
	/*
	* @getShapeV2Price( $shape_id,$pattern_id,$primcolor_id,$seccololr_id )
	*
	*/
	public function getShapeV2Price( $shape_id,$pattern_id,$primcolor_id,$seccololr_id )
	{
		//Get Pattern Price Cat
		$pat_pr_cat = $this->getSomeDesc($pattern_id,"tpp.Patterns","price_category","id");
		$fColor_pr_cat = $this->getSomeDesc($primcolor_id,"tpp.prototype_colors","color_price_cat","color_id");
		$secColor_pr_cat = $this->getSomeDesc($seccololr_id,"tpp.prototype_colors","color_price_cat","color_id");
		
		$total_pr_cat = $pat_pr_cat + $fColor_pr_cat;// + $secColor_pr_cat;
		if( $total_pr_cat == 0 || ! is_numeric($total_pr_cat) )
			$total_pr_cat = 1;
		else if( $total_pr_cat > 13 )	
			$total_pr_cat = 13;
		
		$filed = 'price'.$total_pr_cat;
		
		//Get Shape Price
		$code3 = $this->getSomeDesc($shape_id,"tpp.general_table_tp","3code","gentable_id");
		$sql = "SELECT $filed
				FROM price_shape
				WHERE 3code = '".$code3."' ";
		$res = $this->excQuery($sql);
		
		return $res[0][$filed];		
			
	}
	
	
	/*
	* @getShapeV3Price( $shape_id,$pattern_id,$primcolor_id,$seccololr_id )
	*
	*/
	public function getShapeV3Price( $shape_id,$pattern_id,$primcolor_id,$seccololr_id )
	{
		//Get Pattern Price Cat
		$pat_pr_cat = $this->getSomeDesc($pattern_id,"tpp.Patterns","price_category","id");
		$fColor_pr_cat = $this->getSomeDesc($primcolor_id,"tpp.prototype_colors","color_price_cat","color_id");
		$secColor_pr_cat = $this->getSomeDesc($seccololr_id,"tpp.prototype_colors","color_price_cat","color_id");
		
		$total_pr_cat = $pat_pr_cat + $fColor_pr_cat;// + $secColor_pr_cat;
		if( $total_pr_cat == 0 || ! is_numeric($total_pr_cat) )
			$total_pr_cat = 1;
		else if( $total_pr_cat > 13 )	
			$total_pr_cat = 13;
		
		$filed = 'price'.$total_pr_cat;
		
		//Get Shape Price
		$sql = "SELECT $filed
				FROM price_shape_v3
				WHERE shape_id = '".$shape_id."' ";
		$res = $this->excQuery($sql);
		
		return $res[0][$filed];		
			
	}
	
	
	/*
	*@show_program($ts_4code_id)
	*
	*/
	public function show_program($ts_4code_id)
	{
		$sql = "SELECT PM.tbl_ts_program_max_code,PR.tbl_ts_program_rise_code,
					   PA.tbl_ts_program_annealing_code
				FROM glass_apps_all.tbl_ts_4code FC 
				LEFT JOIN tbl_ts_program_max PM ON FC.tbl_ts_4code_prog_max = PM.tbl_ts_program_max_id
				LEFT JOIN tbl_ts_program_rise PR ON FC.tbl_ts_4code_prog_rise = PR.tbl_ts_program_rise_id
				LEFT JOIN tbl_ts_program_annealing PA ON FC.tbl_ts_4code_prog_aneal = PA.tbl_ts_program_annealing_id
				WHERE tbl_ts_4code_id = '".$ts_4code_id."' 
				";
		$res = $this->excQuery($sql);
		
		return ($res[0]['tbl_ts_program_max_code']."/".$res[0]['tbl_ts_program_rise_code']."/".$res[0]['tbl_ts_program_annealing_code']);		
	}
	
	
	/*
	*@backupMetalCurrInv($metal_id,$company_id,$newQty)
	*
	*/
	public function backupMetalCurrInv($metal_id,$company_id,$newQty)
	{
		$sql = "SELECT SUM(tbl_ts_metals_curr_inventory_qty) AS sumQty
				FROM glass_apps_all.tbl_ts_metals_curr_inventory
				WHERE tbl_ts_metals_curr_inventory_metal_id = '".$metal_id."' 
				AND tbl_ts_metals_curr_inventory_company_id = '".$company_id."'  ";
		$res = $this->excQuery($sql);		
		$sumQty = $res[0]['sumQty'];
		
		//Add Backup
		$sql = "INSERT INTO glass_apps_all.tbl_ts_metals_curr_inventory_last_prices
				(
					tbl_ts_metals_curr_inventory_last_prices_metal_id,
					tbl_ts_metals_curr_inventory_last_prices_old_qty,
					tbl_ts_metals_curr_inventory_last_prices_new_qty,
					tbl_ts_metals_curr_inventory_last_prices_company_id,
					timestamp
				)
				VALUES
				(
					'".$metal_id."',
					'".$this->checkForCorrectValue($sumQty,0)."',
					'".$this->checkForCorrectValue($newQty,0)."',
					'".$company_id."',
					'".date('y-m-d')."'
				)
				";
		$res = @mysql_query($sql);		
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
					$year = $year-1;
					$month = 12 + $month;
				}
				break;
			case 'd':
				$day -= $remvValue;
				if( $month != 2 )
				{
					if( $day < 1 )
					{	
						$month = $month - 1;
						if( $month < 1 )
						{
							$year = $year-1;
							$month = 12 + $month;
						}
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
	* @getMonthDays($month,$year)
	*
	* Briskei poses meres exei o minas 
	*/
	public function getMonthDays($month,$year)
	{
		$monthDays = 31;
		switch($month)
		{
			case '1':
				$monthDays = 31;
				break;
			case '2':
				$monthDays = 28;
				if( ( $year % 4 ) == 0 )
				{
					if( ( $year % 100 ) != 0 ){
						$monthDays = 29;	//δίσεκτο
					}
					elseif( ( $year % 400 ) == 0 ){
						$monthDays = 29;	//δίσεκτο
					}
						
				}
				elseif( ( $year % 400 ) == 0 )
				{
					$monthDays = 29;	//δίσεκτο
				}
					
				break;
			case '3':
				$monthDays = 31;
				break;
			case '4':
				$monthDays = 30;
				break;
			case '5':
				$monthDays = 31;
				break;
			case '6':
				$monthDays = 30;
				break;
			case '7':
				$monthDays = 31;
				break;
			case '8':
				$monthDays = 31;
				break;
			case '9':
				$monthDays = 30;
				break;
			case '10':
				$monthDays = 31;
				break;
			case '11':
				$monthDays = 30;
				break;
			case '12':
				$monthDays = 31;
				break;
			default:
				$monthDays = 31;
				break;
				
		}
		
		return $monthDays;
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
				
				$monthDays = $this->getMonthDays($month,$year);
				
				//echo "<br>monthDays:".$monthDays." month:".$month;
				
				if( ( $day / $monthDays ) > 1 )
				{
					$month += (int)( $day / $monthDays );	
					
					$BefMonthDays = $monthDays;
					
					
					
					$monthDays = $this->getMonthDays($month,$year);
				
					//echo "<br>monthDays:".$monthDays." month:".$month;
					
					
					
					$day = ( $day % $monthDays );
					
					if( $day == 0 )
						$day++;
					
					if( ( $month / 12 ) > 1 )
					{
						$year +=  (int)( $month / 12 );	
						$month = (int)($month % 12);
					}
					
					//if( $month == 2 && $BefMonthDays >= 30 ) 
					//	$month += 1;
					
				}
				/*
				if( $month != 2 )
				{
					if( $day > 30 )
					{	
						$month++;
						$day = $day - 30;
						if( $day > 30 )
						{
							$month++;
							$day = $day - 30;
						}
					}
					
				}
				elseif( $month == 2 )
				{
					if( $day > 28 )
					{	
						$month++;
						$day = $day - 28;
						if( $day > 30 )
						{
							$month++;
							$day = $day - 30;
						}
					}	
				}
				*/
				
				break;
			default:
				$day += $addValue;
				break;			
		}
		
		$new_date = $year."-".$month."-".$day."";
		
		return $new_date;
	}
	
	
	/*
	* @getWatermarkPhotoNewName($new_photo_id)
	*
	*/
	public function getWatermarkPhotoNewName($new_photo_id)
	{
		if( is_numeric($new_photo_id) )
		{
			//Get Category of keywords
			$sql = "SELECT overview_seo_keycategory_id
					FROM tpp.overview_seo
					WHERE overview_seo_overview_id = '".$new_photo_id."' ";
			$res = $this->excQuery($sql);
			
			//Get Keywords
			$sql = "SELECT tbl_param_keywords_text
					FROM tbl_link_seo_categories_keywords LOK
					JOIN tbl_param_keywords K ON LOK.tbl_link_seo_categories_keywords_keywrd_id = K.tbl_param_keywords_id
					
					WHERE tbl_link_seo_categories_keywords_catgry_id = '".$res[0]['overview_seo_keycategory_id']."' ";
			$res_k = $this->excQuery($sql);
			
			$name = "";
			$paula = "";
			for( $i=0;$i<count($res_k);$i++ )		
			{
				$name .= $paula.$res_k[$i]['tbl_param_keywords_text'];
				$paula = "-";
			}
			
			$name = str_replace(" ","-",$name);
			$name = str_replace(",","",$name);
			return $name;
		}
	}
	
	
	/*
	* @getWatermarkPhotoNewName_v2($new_photo_id)
	* 
	* Filename = Keyword + Tag + Brand Keyword
	*
	*/
	public function getWatermarkPhotoNewName_v2($new_photo_id)
	{
		if( is_numeric($new_photo_id) )
		{
			//Get Category of keywords
			$sql = "SELECT overview_seo_keycategory_id,overview_seo_tag
					FROM tpp.overview_seo
					WHERE overview_seo_overview_id = '".$new_photo_id."' ";
			$res = $this->excQuery($sql);
			
			//$keyword = $this->chooseAKeyword_v2($res[0]['overview_seo_keycategory_id']);
			$keyword = $this->chooseAKeyword_Grade1($res[0]['overview_seo_keycategory_id']);
			$tag = $res[0]['overview_seo_tag'];
			
			$brand = $this->getSomeDesc($new_photo_id,"tpp.overview_seo","overview_seo_brand_id","overview_seo_overview_id");
			$barnd_keyword = $this->chooseBrandKeyword($brand);
			
			$name = $keyword."-".$tag;
			if( strlen($barnd_keyword) )
				$name .= "-".$barnd_keyword;
			
			$name = str_replace(" ","-",$name);
			$name = str_replace(",","",$name);
			
			//Insert Keyword to database For Debugging
			$sql = "UPDATE overview SET
						keyword = '".$keyword."'
					WHERE ID = '".$new_photo_id."' ";
			$res = mysql_query($sql) or die( mysql_error() );		
			
			return $name;
		}
	}
	
	
	/*
	* @getWatermarkPhotoAltText($new_photo_id)
	* 
	* Alt Text = Keyword + Keyword2 + Keyword3 + Tag + Brand Keyword
	*
	*/
	public function getWatermarkPhotoAltText($new_photo_id)
	{
		if( is_numeric($new_photo_id) )
		{
			//Get Category of keywords
			$sql = "SELECT overview_seo_keycategory_id,overview_seo_tag
					FROM tpp.overview_seo
					WHERE overview_seo_overview_id = '".$new_photo_id."' ";
			$res = $this->excQuery($sql);
			
			$keyword2 = $this->chooseAKeyword_Grade2_3($res[0]['overview_seo_keycategory_id']);
			$keyword3 = $this->chooseAKeyword_Grade4($res[0]['overview_seo_keycategory_id']);
			$keyword1 = $this->chooseAKeyword_Grade1($res[0]['overview_seo_keycategory_id']);
			
			$tag = $res[0]['overview_seo_tag'];
			
			$brand = $this->getSomeDesc($new_photo_id,"tpp.overview_seo","overview_seo_brand_id","overview_seo_overview_id");
			$barnd_keyword = $this->chooseBrandKeyword_altText($brand);
			
			$name = $keyword1." ".$keyword2." ".$keyword3." ".$tag;
			if( strlen($barnd_keyword) )
				$name .= " ".$barnd_keyword;
			
			//$name = str_replace(" ","-",$name);
			$name = str_replace(",","",$name);
			
			//Insert Keyword to database For Debugging
			$sql = "UPDATE overview SET
						keyword_alt = '".$keyword1.", ".$keyword2.", ".$keyword3."',
						brand_keyword = '".$barnd_keyword."'
					WHERE ID = '".$new_photo_id."' ";
			$res = mysql_query($sql) or die( mysql_error() );
			
			
			return $name;
		}
	}
	
	/*
	* @chooseAKeyword($keycategory_id)
	*
	* Analoga me to Grade
	*/
	public function chooseAKeyword($keycategory_id)
	{
		//Get Keywords
		$sql = "SELECT tbl_param_keywords_text
				FROM tbl_link_seo_categories_keywords LOK
				JOIN tbl_param_keywords K ON LOK.tbl_link_seo_categories_keywords_keywrd_id = K.tbl_param_keywords_id
				WHERE tbl_link_seo_categories_keywords_catgry_id = '".$keycategory_id."' 
				ORDER BY tbl_param_keywords_grade
				LIMIT 1
				";
		$res = $this->excQuery($sql);
		return $res[0]['tbl_param_keywords_text'];	
	}
	
	
	/*
	* @chooseAKeyword_v2($keycategory_id)
	*
	* Analoga me to Grade
	*/
	public function chooseAKeyword_v2($keycategory_id)
	{
		//Get Keywords Count for this category
		$sql = "SELECT count(tbl_param_keywords_id) AS kcount
				FROM tbl_link_seo_categories_keywords LOK
				JOIN tbl_param_keywords K ON LOK.tbl_link_seo_categories_keywords_keywrd_id = K.tbl_param_keywords_id
				WHERE tbl_link_seo_categories_keywords_catgry_id = '".$keycategory_id."' 
				ORDER BY tbl_param_keywords_grade ";
		$res_c  = $this->excQuery($sql);		
		$kcount = $res_c[0]['kcount'];
		
		//Get Keywords
		$sql = "SELECT tbl_param_keywords_text,tbl_param_keywords_grade,
						tbl_param_keywords_id,
					   tbl_keyword_statistics_kwd_id,
					   tbl_keyword_statistics_count,
					   tbl_keyword_statistics_ctgry_id
				FROM tbl_link_seo_categories_keywords LOK
				JOIN tbl_param_keywords K ON LOK.tbl_link_seo_categories_keywords_keywrd_id = K.tbl_param_keywords_id
				
				LEFT JOIN tbl_keyword_statistics S ON S.tbl_keyword_statistics_kwd_id = LOK.tbl_link_seo_categories_keywords_keywrd_id AND S.tbl_keyword_statistics_ctgry_id = LOK.tbl_link_seo_categories_keywords_catgry_id
				
				WHERE tbl_link_seo_categories_keywords_catgry_id = '".$keycategory_id."' 
				
				GROUP BY (LOK.tbl_link_seo_categories_keywords_keywrd_id)
				ORDER BY tbl_param_keywords_grade
				
				";
		$res = $this->excQuery($sql);
		
		//Magic Keyword Finder
		$clsKeywords = new TKeywords($keycategory_id);
		
		$GRADES = array();
		$KEYWORDS = array();
		$ADDED_KEYWORDS = array();
		$GRADES = $clsKeywords->getCategoryKeywordsGrades();
		$KEYWORDS = $clsKeywords->getCategoryKeywordsIDs();
		
		$ADDED_KEYWORDS = $clsKeywords->getAddedKeywords();
		
		$KeywArray = array();
		$KeywArray = $clsKeywords->getMagicKeyword();
		
		//Insert data to Keyword Stat.
		$res_ins = $this->insertToKeywordsStatistics($KeywArray['id'],$keycategory_id);
		
		
		return $KeywArray['text'];//$res[0]['tbl_param_keywords_text'];	
	}
	
	
	/*
	* @chooseAKeyword_Grade1($keycategory_id)
	*
	* Gia ton dimiourgia tou Alt text gia keywords me Grade 1
	*/
	public function chooseAKeyword_Grade1($keycategory_id)
	{
		//Magic Keyword Finder
		$clsKeywords = new TKeywords($keycategory_id);
		
		$GRADES = array();
		$KEYWORDS = array();
		$ADDED_KEYWORDS = array();
		$GRADES = $clsKeywords->getCategoryKeywordsGrades();
		$tblGrades = array();
		$tblGrades[0] = '1';
		$KEYWORDS = $clsKeywords->getCategoryKeywordsIDs($tblGrades);
		
		$ADDED_KEYWORDS = $clsKeywords->getAddedKeywords();
		
		$KeywArray = array();
		$KeywArray = $clsKeywords->getMagicKeyword_grade1();
		
		//Insert data to Keyword Stat.
		$res_ins = $this->insertToKeywordsStatisticsALtText($KeywArray['id'],$keycategory_id);
		
		
		return $KeywArray['text'];//$res[0]['tbl_param_keywords_text'];	
	}
	
	
	/*
	* @chooseAKeyword_Grade2_3($keycategory_id)
	*
	* Gia ton dimiourgia tou Alt text gia keywords me Grade 2 kai 3
	*/
	public function chooseAKeyword_Grade2_3($keycategory_id)
	{
		//Magic Keyword Finder
		$clsKeywords = new TKeywords($keycategory_id);
		
		$GRADES = array();
		$KEYWORDS = array();
		$ADDED_KEYWORDS = array();
		$GRADES = $clsKeywords->getCategoryKeywordsGrades();
		$tblGrades = array();
		$tblGrades[0] = '2';
		$tblGrades[1] = '3';
		$KEYWORDS = $clsKeywords->getCategoryKeywordsIDs($tblGrades);
		//print_r($GRADES);
		//echo "<br><br>";
		//print_r($KEYWORDS);
		//echo "<br><br>";
		$ADDED_KEYWORDS = $clsKeywords->getAddedKeywords();
		//print_r($ADDED_KEYWORDS);
		//echo "<br><br>";
		
		$KeywArray = array();
		$KeywArray = $clsKeywords->getMagicKeyword_grade2_3();
		//print_r($KeywArray);
		
		//$keyword_id = $res[0]['tbl_param_keywords_id'];
		//$keyword_text = $res[0]['tbl_param_keywords_text'];
		
		//Insert data to Keyword Stat.
		$res_ins = $this->insertToKeywordsStatisticsALtText($KeywArray['id'],$keycategory_id);
		
		
		return $KeywArray['text'];//$res[0]['tbl_param_keywords_text'];	
	}
	
	
	/*
	* @chooseAKeyword_Grade4($keycategory_id)
	*
	* Gia ton dimiourgia tou Alt text gia keywords me Grade 2 kai 3
	*/
	public function chooseAKeyword_Grade4($keycategory_id)
	{
		//Magic Keyword Finder
		$clsKeywords = new TKeywords($keycategory_id);
		
		$GRADES = array();
		$KEYWORDS = array();
		$ADDED_KEYWORDS = array();
		$GRADES = $clsKeywords->getCategoryKeywordsGrades();
		$tblGrades = array();
		$tblGrades[0] = '4';
		
		$KEYWORDS = $clsKeywords->getCategoryKeywordsIDs($tblGrades);
		//print_r($GRADES);
		//echo "<br><br>";
		//print_r($KEYWORDS);
		//echo "<br><br>";
		$ADDED_KEYWORDS = $clsKeywords->getAddedKeywords();
		//print_r($ADDED_KEYWORDS);
		//echo "<br><br>";
		
		$KeywArray = array();
		$KeywArray = $clsKeywords->getMagicKeyword_grade4();
		//print_r($KeywArray);
		
		//$keyword_id = $res[0]['tbl_param_keywords_id'];
		//$keyword_text = $res[0]['tbl_param_keywords_text'];
		
		//Insert data to Keyword Stat.
		$res_ins = $this->insertToKeywordsStatisticsALtText($KeywArray['id'],$keycategory_id);
		
		
		return $KeywArray['text'];//$res[0]['tbl_param_keywords_text'];	
	}
	
	
	/*
	* @chooseBrandKeyword($brand)
	*
	* Analoga me to Grade
	*/
	public function chooseBrandKeyword($brand)
	{
		//Get Keywords
		$sql = "SELECT tbl_param_brand_keywords_text, tbl_param_brand_keywords_id
				FROM tbl_param_brand_keywords LOK
				LEFT JOIN tbl_brand_keywrd_statistic S ON LOK.tbl_param_brand_keywords_id = S.tbl_brand_keywrd_statistic_bkeywrd_id
				WHERE tbl_param_brand_keywords_brand_id = '".$brand."' 
				ORDER BY tbl_brand_keywrd_statistic_kcount ASC, S.timestamp ASC, tbl_param_brand_keywords_grade ASC
				LIMIT 1
				";
		//echo "<br><br>Brand keywords: ".$sql;		
		$res = $this->excQuery($sql);
		
		//Insert to a table
		$sql = "SELECT tbl_brand_keywrd_statistic_id, tbl_brand_keywrd_statistic_kcount 
				FROM tbl_brand_keywrd_statistic 
				WHERE tbl_brand_keywrd_statistic_bkeywrd_id = '".$res[0]['tbl_param_brand_keywords_id']."' 
				AND tbl_brand_keywrd_statistic_brand_id = '".$brand."'
				";
		$res_t = $this->excQuery($sql);
		if( is_numeric($res_t[0]['tbl_brand_keywrd_statistic_id']) )//Update
		{
			$sql = "UPDATE tbl_brand_keywrd_statistic SET 
						tbl_brand_keywrd_statistic_kcount = '".++$res_t[0]['tbl_brand_keywrd_statistic_kcount']."'
					WHERE tbl_brand_keywrd_statistic_id = '".$res_t[0]['tbl_brand_keywrd_statistic_id']."' ";
			$res_ins = mysql_query($sql) or die( mysql_error() );		
		}
		else if( !is_numeric($res_t[0]['tbl_brand_keywrd_statistic_id']) )//Insert
		{
			$sql = "INSERT INTO tbl_brand_keywrd_statistic
					(
						tbl_brand_keywrd_statistic_kcount,
						tbl_brand_keywrd_statistic_bkeywrd_id,
						tbl_brand_keywrd_statistic_brand_id
					)
					VALUES
					(
						'1',
						'".$res[0]['tbl_param_brand_keywords_id']."',
						'".$brand."'
					)
					";
			$res_ins = mysql_query($sql) or die( mysql_error() );		
		}
		
		return $res[0]['tbl_param_brand_keywords_text'];	
	}
	
	
	
	/*
	* @chooseBrandKeyword_altText($brand)
	*
	* Analoga me to Grade
	*/
	public function chooseBrandKeyword_altText($brand)
	{
		//Get Keywords
		$sql = "SELECT tbl_param_brand_keywords_text, tbl_param_brand_keywords_id
				FROM tbl_param_brand_keywords LOK
				LEFT JOIN tbl_altext_brand_keywrd_statistic S ON LOK.tbl_param_brand_keywords_id = S.tbl_altext_brand_keywrd_statistic_bkeywrd_id
				WHERE tbl_param_brand_keywords_brand_id = '".$brand."' 
				ORDER BY tbl_altext_brand_keywrd_statistic_kcount ASC, S.timestamp ASC, tbl_param_brand_keywords_grade ASC
				LIMIT 1
				";
		//echo "<br><br>Brand keywords: ".$sql;		
		$res = $this->excQuery($sql);
		
		//Insert to a table
		$sql = "SELECT tbl_altext_brand_keywrd_statistic_id, tbl_altext_brand_keywrd_statistic_kcount 
				FROM tbl_altext_brand_keywrd_statistic 
				WHERE tbl_altext_brand_keywrd_statistic_bkeywrd_id = '".$res[0]['tbl_param_brand_keywords_id']."' 
				AND tbl_altext_brand_keywrd_statistic_brand_id = '".$brand."'
				";
		$res_t = $this->excQuery($sql);
		if( is_numeric($res_t[0]['tbl_altext_brand_keywrd_statistic_id']) )//Update
		{
			$sql = "UPDATE tbl_altext_brand_keywrd_statistic SET 
						tbl_altext_brand_keywrd_statistic_kcount = '".++$res_t[0]['tbl_altext_brand_keywrd_statistic_kcount']."'
					WHERE tbl_altext_brand_keywrd_statistic_id = '".$res_t[0]['tbl_altext_brand_keywrd_statistic_id']."' ";
			$res_ins = mysql_query($sql) or die( mysql_error() );		
		}
		else if( !is_numeric($res_t[0]['tbl_altext_brand_keywrd_statistic_id']) )//Insert
		{
			$sql = "INSERT INTO tbl_altext_brand_keywrd_statistic
					(
						tbl_altext_brand_keywrd_statistic_kcount,
						tbl_altext_brand_keywrd_statistic_bkeywrd_id,
						tbl_altext_brand_keywrd_statistic_brand_id
					)
					VALUES
					(
						'1',
						'".$res[0]['tbl_param_brand_keywords_id']."',
						'".$brand."'
					)
					";
			$res_ins = mysql_query($sql) or die( mysql_error() );		
		}
		
		return $res[0]['tbl_param_brand_keywords_text'];	
	}
	
	
	/*
	* @insertToKeywordsStatistics($keyword_id,$keycategory_id)
	*
	*/
	public function insertToKeywordsStatistics($keyword_id,$keycategory_id)
	{
		$sql = "SELECT tbl_keyword_statistics_id, 
					   tbl_keyword_statistics_count
				FROM tpp.tbl_keyword_statistics
				WHERE  tbl_keyword_statistics_kwd_id = '".$keyword_id."' 
				AND tbl_keyword_statistics_ctgry_id = '".$keycategory_id."'  
				";
		$res = $this->excQuery($sql);
		if( is_numeric($res[0]['tbl_keyword_statistics_id'])  && strlen($keyword_id) && strlen($keycategory_id) && $keycategory_id > 0 )//Update
		{
			$sql = "UPDATE tpp.tbl_keyword_statistics SET 
						tbl_keyword_statistics_count = '".(++$res[0]['tbl_keyword_statistics_count'])."' 
					WHERE tbl_keyword_statistics_id = '".$res[0]['tbl_keyword_statistics_id']."' 
					";	
			$res_ins = mysql_query($sql) or die( "In Class fn(insertToKeywordsStatistics) : ".mysql_error() );
					
		}
		else if( ! is_numeric($res[0]['tbl_keyword_statistics_id'] ) && strlen($keyword_id) && strlen($keycategory_id) && $keycategory_id > 0  )//Insert
		{
			$sql = "INSERT INTO tpp.tbl_keyword_statistics
					(
						tbl_keyword_statistics_kwd_id,
						tbl_keyword_statistics_ctgry_id,
						tbl_keyword_statistics_count
					)
					VALUES
					(
						'".$keyword_id."',
						'".$keycategory_id."',  
						'1'
					)
					
					";	
			$res_ins = mysql_query($sql) or die( "In Class fn(insertToKeywordsStatistics) : ".mysql_error() );
		}
	}
	
	
	
	/*
	* @insertToKeywordsStatisticsALtText($keyword_id,$keycategory_id)
	*
	*/
	public function insertToKeywordsStatisticsALtText($keyword_id,$keycategory_id)
	{
		$sql = "SELECT tbl_altext_keyword_statistics_id, 
					   tbl_altext_keyword_statistics_count
				FROM tpp.tbl_altext_keyword_statistics
				WHERE  tbl_altext_keyword_statistics_kwd_id = '".$keyword_id."' 
				AND tbl_altext_keyword_statistics_ctgry_id = '".$keycategory_id."'  
				";
		$res = $this->excQuery($sql);
		if( is_numeric($res[0]['tbl_altext_keyword_statistics_id'])  && strlen($keyword_id) && strlen($keycategory_id) && $keycategory_id > 0 )//Update
		{
			$sql = "UPDATE tpp.tbl_altext_keyword_statistics SET 
						tbl_altext_keyword_statistics_count = '".(++$res[0]['tbl_altext_keyword_statistics_count'])."' 
					WHERE tbl_altext_keyword_statistics_id = '".$res[0]['tbl_altext_keyword_statistics_id']."' 
					";	
			$res_ins = mysql_query($sql) or die( "In Class fn(insertToKeywordsStatistics) : ".mysql_error() );
					
		}
		else if( ! is_numeric($res[0]['tbl_altext_keyword_statistics_id'] ) && strlen($keyword_id) && strlen($keycategory_id) && $keycategory_id > 0  )//Insert
		{
			$sql = "INSERT INTO tpp.tbl_altext_keyword_statistics
					(
						tbl_altext_keyword_statistics_kwd_id,
						tbl_altext_keyword_statistics_ctgry_id,
						tbl_altext_keyword_statistics_count
					)
					VALUES
					(
						'".$keyword_id."',
						'".$keycategory_id."',  
						'1'
					)
					
					";	
			$res_ins = mysql_query($sql) or die( "In Class fn(insertToKeywordsStatisticsALtText) : ".mysql_error() );
		}
	}
	
	
	/*
	* @updateWhoisOnline()
	*
	*/
	public function updateWhoisOnline()
	{
		$sql = "SELECT tbl_param_users_username,
						tbl_param_users_last_name,tbl_param_users_first_name
				FROM tpp.tbl_param_users
				WHERE tbl_param_users_id = '".$_COOKIE['USERID']."' 
				";
		$res = $this->excQuery($sql);		
		$name = $res[0]['tbl_param_users_last_name']." ".$res[0]['tbl_param_users_first_name'];
		if( count($res)<=0 )
			$name = "Guest";
		
		$wo_session_id = session_id();
   		$wo_ip_address = getenv('REMOTE_ADDR');
		$wo_last_page_url = "http://".$_SERVER['HTTP_HOST']."".getenv('REQUEST_URI');
		
		$current_time = time();
	    $xx_mins_ago = ($current_time - 900);
		
		// remove entries that have expired
	    $sql = "DELETE FROM tpp.whos_online  WHERE 
					time_last_click < '" . $xx_mins_ago . "'
				";
		$res_d = mysql_query($sql);		
		
		$sql = "SELECT count(*) AS counter
				FROM tpp.whos_online
				WHERE session_id = '".session_id()."'
				";
		$res_custmr = $this->excQuery($sql);		
		
    	if ($res_custmr[0]['counter'] > 0) 
		{
			$sql = "UPDATE tpp.whos_online SET
						customer_id = '" . (int)$_COOKIE['USERID'] . "',
						full_name = '" . $name . "',
						ip_address = '" . $wo_ip_address. "',
						time_last_click = '" . $current_time. "', 
						last_page_url = '" . $wo_last_page_url. "' 
						
					WHERE session_id = '".session_id()."'
					";	
			$res_up = mysql_query($sql) or die( mysql_error() );		
			//echo $sql;
 	   } 
		else 
		{
	      	$sql = "INSERT INTO tpp.whos_online
					(
					 	customer_id,
						full_name,
						ip_address,
						time_entry,
						time_last_click,
						last_page_url,
						session_id
					 )
					VALUES
					(
					 	'" . (int)$_COOKIE['USERID'] . "',
						'" . $name . "',
						'" . $wo_ip_address. "',
						'" . $current_time. "', 
						'" . $current_time. "', 
						'" . $wo_last_page_url. "',
						'".session_id()."'
					)
					";
			//echo $sql;
			$res_up = mysql_query($sql) or die( mysql_error() );	
		}
	} //End of function updateWhoisOnline()
	
	
	/*
	*@quickEditForm($url,$rowID,$table,$editField,$idField)
	*
	*/
	
	public function quickEditForm($url,$rowID,$table,$editField,$idField,$returnedURL,$__IDCOUNTER = "", $text = "Edit Comment")
	{
		$returnedURL = str_replace("?","@",$returnedURL);
		$idCOunter = "";
		if( strlen($__IDCOUNTER) ) $idCOunter = $__IDCOUNTER;
		else						 $idCOunter = $this->IDCOUNTER;
		
		$str = '<br>&nbsp;<div class="row-actions" id="rowActions'.$idCOunter.'" style="z-index:100; position:absolute; display:block; float:left; width:150px; background-color:#CCC; padding:0px; text-align:center;" onMouseOut="this.style.display=\'block\';" >
            	<span class="edit">
                <a href="javascript:void(0)" onclick="window.open(\''.$url.'?action=edit&amp;rowID='.$rowID.'&amp;table='.$table.'&amp;editField='.$editField.'&amp;idField='.$idField.'&amp;returnedURL='.$returnedURL.'\',\'quickEdit\',\'width=400,height=300\')" title="Edit this entry">'.$text.'</a>  </span>
           		</div>';	
		return $str;		
	}
	
	/*
	*@activeQuickEditForm()
	*
	*/
	public function activeQuickEditForm($__IDCOUNTER = "" )
	{
		//if( strlen($__IDCOUNTER) )	$this->IDCOUNTER = $__IDCOUNTER;
		//else						$this->IDCOUNTER += 1;
		$idCOunter = "";
		if( strlen($__IDCOUNTER) ) $idCOunter = $__IDCOUNTER;
		else						 $idCOunter = ++$this->IDCOUNTER;
		
		$str = "onMouseOver=\"document.getElementById('rowActions".$idCOunter."').style.display='block';\" 
				
				";	
				/*onMouseOut=\"document.getElementById('rowActions".$idCOunter."').style.display='none';\"*/
		return $str; 		
	}
	
	
	/*
	* @getMixInventoryLastQty($mix_id)
	*
	*/
	public function getMixInventoryLastQty($mix_id)
	{
		if( is_numeric( $mix_id ) )
		{
			$sql = "SELECT tbl_ts_inventory_mix_qty
					FROM tbl_ts_inventory_mix
					WHERE tbl_ts_inventory_mix_mix_id = '".$mix_id."' 
					ORDER BY tbl_ts_inventory_mix_date DESC";
			$res = $this->excQuery($sql);
			return $res[0]['tbl_ts_inventory_mix_qty'];		
		}
		else 
			return 0;
	}
	
	/*
	* @getMixLastInventoryField($color_id,$field)
	*
	*/
	public function getMixLastInventoryField($mix_id,$field)
	{
		if( is_numeric( $mix_id ) )
		{
			$sql = "SELECT $field
					FROM tbl_ts_inventory_mix
					WHERE tbl_ts_inventory_mix_mix_id = '".$mix_id."' 
					ORDER BY tbl_ts_inventory_mix_date DESC";
			$res = $this->excQuery($sql);
			return $res[0][$field];		
		}
		else 
			return 0;
	}
	
	
	/*
	* @getSamplesBoxesPrice($setCode_id) 
	*
	* Ypologizei tin timi tou set four code. Xrisimopoieitai gia na ypologisei tin timi sta mgp sample boxes
	* stin prosfora tis Myglassplate
	*/
	public function getSamplesBoxesPrice($setCode_id,$currency)
	{
		//Get 4code replacemnts
		$sql = "SELECT tbl_ts_4code_id,LS.*
				FROM glass_apps_all.tbl_ts_4code_link_set LS 
				JOIN glass_apps_all.tbl_ts_4code FC ON LS.tbl_ts_4code_link_repl_id = FC.tbl_ts_4code_id
				WHERE tbl_ts_4code_link_set_4code_id = '".$setCode_id."' 
				ORDER BY tbl_ts_4code_link_repl_serial";
		$res_r = $this->excQuery($sql);		
		$price = 0;
		for( $i=0;$i<count($res_r);$i++ )
		{
			$rpl_4code_id = $res_r[$i]['tbl_ts_4code_link_repl_id'];
			$rpl_qty = $res_r[$i]['tbl_ts_4code_link_repl_qty'];
			
			$sql = "SELECT * 
					FROM glass_apps_all.tbl_ts_4code
					WHERE tbl_ts_4code_id = '".$rpl_4code_id."'
					";
			$res_detail = $this->excQuery($sql);		
			
				$fieldPR = "priceMGP2";
				if( $res_detail[0]['tbl_ts_4code_pattern_id'] == X40_PATTERN && $res_detail[0]['tbl_ts_4code_color1_id'] == X40_COLOR )
					$fieldPR = "priceMGP1";
							
				//echo $fieldPR;
				$sql = "SELECT $fieldPR 
						FROM tpp.price_shape_v3 
						WHERE shape_id = '".$res_detail[0]['tbl_ts_4code_shape_id']."' ";
				$res_pr = $this->excQuery($sql);		
				$euro = $res_pr[0][$fieldPR]; 
	
				$shape_ts_masterpack_pcs = $this->getSomeDesc( $res_detail[0]['tbl_ts_4code_id'] ,"glass_apps_all.tbl_ts_4code","tbl_ts_4code_masterpack_pcs","tbl_ts_4code_id");
				
				if( $currency == US_DDP )
				{
					$sql_c = "SELECT priceMGP1,priceMGP2
							  FROM price_shapeus 
							  WHERE 3code = '".$this->getSomeDesc( $res_detail[0]['tbl_ts_4code_shape_id'],"tpp.general_table_tp","3code","gentable_id")."' ";
					$res_c = $this->excQuery($sql_c);		  
								  
					$unitPrice = $res_c[0]['priceMGP2'];
					if( $res_detail[0]['pattern_id'] == X40_PATTERN && $res_w[0]['first_color_id'] == X40_COLOR )
						$unitPrice = $res_c[0]['priceMGP1'];
					$euro = $unitPrice;	
				}			
				
			$price += $euro*$rpl_qty;
		} //end of for
		return $price;
	}//end of function 
	
	
	/*
	* @getSamplesBoxesQties($setCode_id) 
	*
	* Ypologizei tin posotita ton boxes tou set four code. 
	* Xrisimopoieitai gia na ypologisei tin timi sta mgp sample boxes
	* stin prosfora tis Myglassplate
	*/
	public function getSamplesBoxesQties($setCode_id)
	{
		//Get 4code replacemnts
		$sql = "SELECT tbl_ts_4code_id,LS.*
				FROM glass_apps_all.tbl_ts_4code_link_set LS 
				JOIN glass_apps_all.tbl_ts_4code FC ON LS.tbl_ts_4code_link_repl_id = FC.tbl_ts_4code_id
				WHERE tbl_ts_4code_link_set_4code_id = '".$setCode_id."' 
				ORDER BY tbl_ts_4code_link_repl_serial";
		$res_r = $this->excQuery($sql);		
		$samples_qty = 0;
		for( $i=0;$i<count($res_r);$i++ )
		{
			$samples_qty += $res_r[$i]['tbl_ts_4code_link_repl_qty'];
		} //end of for
		return $samples_qty;
	}//end of function 
	
	
	
	public function getShapeGlassThinkness($shape_id)
	{
		$sql = "SELECT tbl_ts_shape_link_optiwyn_thicknes
				FROM glass_apps_all.tbl_ts_shape_link_optiwyn
				WHERE tbl_ts_shape_link_optiwyn_shape_id = ".$shape_id."
				AND tbl_ts_shape_link_optiwyn_thicknes != '0'
				LIMIT 1
				";
		$res = 	$this->excQuery($sql);
		$thikness = $res[0]['tbl_ts_shape_link_optiwyn_thicknes'];
		$thikness_text = $this->getSomeDesc($thikness,"glass_apps_all.tbl_param_glass_thickness","tbl_param_glass_thickness_text","tbl_param_glass_thickness_id");
		
		$text = "";
		if( strlen($thikness_text) )
			$text = "Glass Thickness: ".$thikness_text;
		
		return $text;
	}
	
	
	/*
	* @getOrderTotalAmount($order_id)
	*
	* Ypologizei to sunoliko kostos mia paraggelias
	*/
	public function getOrderTotalAmount($order_id)
	{
		if( is_numeric($order_id) )
		{
			$offer_select_id = $this->getSomeDesc($order_id,"tpp.ordersgs","offer_select_id","id");
			$transport_cost  = $this->getSomeDesc($order_id,"tpp.ordersgs","transport_cost","id");
			$header_discount = $this->getSomeDesc($order_id,"tpp.ordersgs","header_discount","id");
			$header_discount = ( $header_discount > 1 )? ($header_discount/100):$header_discount;
			$prepay          = $this->getSomeDesc($order_id,"tpp.ordersgs","prepay","id");
			$offer_pricelist = $this->getSomeDesc($order_id,"tpp.ordersgs","offer_pricelist","id");
			
			if($offer_select_id == MYGLASS_STUDIO)//My Glass Studio
			{
				$sql = "SELECT 
						FROM ";	
				return 0;		
			}
			elseif($offer_select_id == TIGER_GLASS)//TIGER_GLASS
			{
				$sql = "SELECT price
						FROM tpp.wishbasket
						WHERE order_id = '".$order_id."'
						";	
				$res = $this->excQuery($sql);
				$total_amount = 0;
				for( $i=0;$i<count($res);$i++ )
				{
					$price  = $res[$i]['price'];
					/* Ta discounts (header, pricelist, shape) sumperilambanontai sto Price :) 
					$price -= $price * $header_discount;
					$price -= $price * $prepay;	*/
					
					$total_amount += $price;
				}
				
				$total_amount += $transport_cost;
				
				return $total_amount;
			}
			elseif($offer_select_id == MYGLASSPLATE)//MYGLASSPLATE
			{
				return 0;
			}
			else
			{
				return 0;	
			}
			
		}
		
		return 0;
	}
	
	
	/*
	* @getOfferPage($offer_id)
	*
	*/
	public function getOfferPage($offer_id)
	{
		$offer_select_id = $this->getSomeDesc($offer_id,"tpp.ordersgs","offer_select_id","offer_id");
		$order_id		 = $this->getSomeDesc($offer_id,"tpp.ordersgs","id","offer_id");
		
		switch($offer_select_id)
		{
			case MYGLASS_STUDIO:
				return "offer_glassstudio/offer_glassstudio_edit.php?order_id=".$order_id;
			break;
			case TIGER_GLASS:
				return "offer_add_edit/offer_tiger_glass.php?order_id=".$order_id;
			break;
			case MYGLASSPLATE:
				return "offer_add_edit/offer_glassplate.php?order_id=".$order_id;
			break;	
			default:
				return "offer_glassstudio/offer_glassstudio_edit.php?order_id=".$order_id;
			break;
				
		}
	}
	
	
	/*
	*@getCPMTotalEuro($tbl_ts_mixture_header_id,$cpm_id)
	*
	*/
	public function getCPMTotalEuro($tbl_ts_mixture_header_id,$cpm_id)
	{
		$sql = "SELECT tbl_ts_cpm_detail_cpm_id, tbl_ts_cpm_detail_id,
  					tbl_ts_cpm_detail_root_color_id, 
					tbl_ts_cpm_detail_cpm_mixture_header_qty,
					tbl_ts_cpm_detail_id, 
					tbl_ts_cpm_detail_consumption
				FROM ".GLASS_APPS_ALL.".tbl_ts_cpm_detail
				WHERE tbl_ts_cpm_detail_mixture_header_id = '".$tbl_ts_mixture_header_id."' 
				AND tbl_ts_cpm_detail_cpm_id = '".$cpm_id."'
				";
		//echo $sql;		
		//echo $sql;		
		$res_gcpm = $this->excQuery($sql);
					
		$cpm_cost = 0;
		for( $gc=0;$gc<count($res_gcpm);$gc++ )		
		{ 
			//$cpm_cost += $this->getTotalMiktikaEuro($res_gcpm[$gc]['tbl_ts_cpm_detail_id'],$res_gcpm[$gc]['tbl_ts_cpm_detail_root_color_id'],$res_gcpm[$gc]['tbl_ts_cpm_detail_cpm_mixture_header_qty']);
			
			$cpm_cost += $this->getCPMAndFluxEuro( $res_gcpm[$gc]['tbl_ts_cpm_detail_id'],$res_gcpm[$gc]['tbl_ts_cpm_detail_root_color_id'],$res_gcpm[$gc]['tbl_ts_cpm_detail_cpm_mixture_header_qty'] );
			
		}	
					
		return $cpm_cost;
	}
	
	/*
	*@getCPMTotalEuroPerM2($tbl_ts_mixture_header_id,$cpm_id)
	*
	*/
	public function getCPMTotalEuroPerM2($tbl_ts_mixture_header_id,$cpm_id)
	{
		$sql = "SELECT tbl_ts_cpm_detail_cpm_id, tbl_ts_cpm_detail_id,
  					tbl_ts_cpm_detail_root_color_id, 
					tbl_ts_cpm_detail_cpm_mixture_header_qty,
					tbl_ts_cpm_detail_id, 
					tbl_ts_cpm_detail_consumption
				FROM ".GLASS_APPS_ALL.".tbl_ts_cpm_detail
				WHERE tbl_ts_cpm_detail_mixture_header_id = '".$tbl_ts_mixture_header_id."' 
				AND tbl_ts_cpm_detail_cpm_id = '".$cpm_id."'
				";
		$res_gcpm = $this->excQuery($sql);
					
		$cpm_cost = 0;
		for( $gc=0;$gc<count($res_gcpm);$gc++ )		
		{
			
			//$cpm_cost += $this->getTotalMiktikaEuro($res_gcpm[$gc]['tbl_ts_cpm_detail_id'],$res_gcpm[$gc]['tbl_ts_cpm_detail_root_color_id'],$res_gcpm[$gc]['tbl_ts_cpm_detail_cpm_mixture_header_qty']);
			
			$cpm_cost += $this->getCPMAndFluxEuro( $res_gcpm[$gc]['tbl_ts_cpm_detail_id'],$res_gcpm[$gc]['tbl_ts_cpm_detail_root_color_id'],$res_gcpm[$gc]['tbl_ts_cpm_detail_cpm_mixture_header_qty'] );
			
			
			$cpm_cost_per 		 = $cpm_cost/100;
			$consumption_per_cm2 = $res_gcpm[$gc]['tbl_ts_cpm_detail_consumption'] / 100;
			
			$cpm_cost_per_cm2 += ( ($cpm_cost_per * $consumption_per_cm2) * 10000); //cm2 to m2; 
						
		}	
					
		return $cpm_cost;//$cpm_cost_per_cm2;
	}
	
	/*
	*@getCPMTotalEuroPerM2_V2($tbl_ts_mixture_header_id,$cpm_id)
	*
	*/
	public function getCPMTotalEuroPerM2_V2($root_color_id,$cpm_id)
	{
		$sql = "SELECT tbl_ts_cpm_detail_id, tbl_ts_cpm_detail_root_color_id,
  					tbl_ts_cpm_detail_cpm_mixture_header_qty,
					tbl_ts_cpm_detail_consumption
				FROM ".GLASS_APPS_ALL.".tbl_ts_cpm_detail
				WHERE tbl_ts_cpm_detail_root_color_id = '".$root_color_id."' 
				AND tbl_ts_cpm_detail_cpm_id = '".$cpm_id."'
				";
		//die( $sql );		
		$res_gcpm = $this->excQuery($sql);
					
		$cpm_cost = 0;
		for( $gc=0;$gc<count($res_gcpm);$gc++ )		
		{
			
			//$cpm_cost += $this->getTotalMiktikaEuro($res_gcpm[$gc]['tbl_ts_cpm_detail_id'],$res_gcpm[$gc]['tbl_ts_cpm_detail_root_color_id'],$res_gcpm[$gc]['tbl_ts_cpm_detail_cpm_mixture_header_qty']);
			
			$cpm_cost += $this->getCPMAndFluxEuro( $res_gcpm[$gc]['tbl_ts_cpm_detail_id'],$res_gcpm[$gc]['tbl_ts_cpm_detail_root_color_id'],$res_gcpm[$gc]['tbl_ts_cpm_detail_cpm_mixture_header_qty'] );
			
			
			$cpm_cost_per 		 = $cpm_cost/100;
			$consumption_per_cm2 = $res_gcpm[$gc]['tbl_ts_cpm_detail_consumption'] / 100;
			
			$cpm_cost_per_cm2 += ( ($cpm_cost_per * $consumption_per_cm2) * 10000); //cm2 to m2; 
						
		}	
					
		return $cpm_cost_per_cm2;
	}
	
	/*
	*@getShapeApplicationCat($shape_id,$appcat_code)
	*
	*/
	public function getShapeApplicationCat($shape_id,$appcat_code)
	{
		
		$joinShape_groupID = $this->getSomeDesc($shape_id,"tpp.general_table_tp","gentable_technic_group_id","gentable_id");
		//Get Technick group link
		$sql = "SELECT tbl_param_technic_shapes_group_link_technic_group_id,
							       tbl_param_technic_shapes_group_link_technic_technic_id,
								   tbtech4_unique, tbtech4_code
			FROM tpp.tbl_param_technic_shapes_group_link_technic LT
			JOIN tpp.technique4 T ON LT.tbl_param_technic_shapes_group_link_technic_technic_id = T.tbtech4_unique
			WHERE tbl_param_technic_shapes_group_link_technic_group_id = '".$joinShape_groupID."' 
			AND T.tbtech4_code LIKE '".$appcat_code."' 
			";
		//echo $sql;	
		$res = $this->excQuery($sql);
		for( $i=0;$i<count($res);$i++ ):
			if( $res[$i]['tbtech4_code'] == $appcat_code )
			{
				return true;
				break;
			}
		endfor;
		
		return false;
	}
	
	/*
	*@getPatternApplicationCat($pattern_id,$appcat_code)
	*
	*/
	public function getPatternApplicationCat($pattern_id,$appcat_code)
	{
		$pattern_tbt_unique = $this->getSomeDesc($pattern_id,"tpp.Patterns","tbtech4_unique","id");
		
		//Get Technick group link
		$sql = "SELECT tbtech4_unique, tbtech4_code
			FROM tpp.technique4 T 
			WHERE tbtech4_code LIKE '".$appcat_code."' 
			AND tbtech4_unique = '".$pattern_tbt_unique."'
			";
		//echo $sql;	
		$res = $this->excQuery($sql);
		if( $res[0]['tbtech4_code'] == $appcat_code && is_numeric($res[0]['tbtech4_unique']) )
		{
			return true;
		}
		
		return false;
	}
	
	/*
	*@getPriceOfCombination($shape_id,$pattern_id,$color_id)
	*
	*/
	public function getPriceOfCombination($shape_id,$pattern_id,$color_id)
	{
		//Get Pattern Pr Cat.
		$p_pcat = $this->getSomeDesc($pattern_id,"tpp.Patterns","price_category","id");
		$c_pcat = $this->getSomeDesc($color_id,"tpp.prototype_colors","color_price_cat","color_id");
		$shp_pcat = $p_pcat + $c_pcat;
		if( $shp_pcat > MAX_PRICE_CATEGORY ) $shp_pcat = MAX_PRICE_CATEGORY;
		if( $shp_pcat <= 0 ) $shp_pcat = 1;
		
		$code3 = $this->getSomeDesc($shape_id,"tpp.general_table_tp","3code","gentable_id");
		$filed = "price".$shp_pcat."";
		//Old
		/*
		$sql = "SELECT $filed
				FROM tpp.price_shape
				WHERE 3code = '".$code3."'
				";
		$res = $this->excQuery($sql);
		*/
		
		if( is_numeric($res[0][$filed]) )//Old
		{
			return 	$res[0][$filed];
		}
		elseif( !is_numeric($res[0][$filed]) )
		{
			//new
			$sql = "SELECT $filed 
					FROM tpp.price_shape_v3 
					WHERE shape_id = '".$shape_id."'
					";
			$res_n = $this->excQuery($sql);
			
			return $res_n[0][$filed];
		}
		
		
		return 0;
	}
	
	
	/*
	*@getPriceOfCombination_v3($shape_id,$pattern_id,$color_id,$sec_color_id)
	* 
	* With seconday color
	*/
	public function getPriceOfCombination_v3($shape_id,$pattern_id,$color_id,$sec_color_id)
	{
		//Get Pattern Pr Cat.
		$p_pcat = $this->getSomeDesc($pattern_id,"tpp.Patterns","price_category","id");
		$c_pcat = $this->getSomeDesc($color_id,"tpp.prototype_colors","color_price_cat","color_id");
		$sec_c_pcat = $this->getSomeDesc($sec_color_id,"tpp.prototype_colors","color_price_cat","color_id");
		
		$shp_pcat = $p_pcat + $c_pcat + $sec_c_pcat;
		
		if( $shp_pcat > MAX_PRICE_CATEGORY ) $shp_pcat = MAX_PRICE_CATEGORY;
		if( $shp_pcat <= 0 ) $shp_pcat = 1;
		
		$code3 = $this->getSomeDesc($shape_id,"tpp.general_table_tp","3code","gentable_id");
		$filed = "price".$shp_pcat."";
		//Old
		/*
		$sql = "SELECT $filed
				FROM tpp.price_shape
				WHERE 3code = '".$code3."'
				";
		$res = $this->excQuery($sql);
		*/
		
		if( is_numeric($res[0][$filed]) )//Old
		{
			return 	$res[0][$filed];
		}
		elseif( !is_numeric($res[0][$filed]) )
		{
			//new
			$sql = "SELECT $filed 
					FROM tpp.price_shape_v3 
					WHERE shape_id = '".$shape_id."'
					";
			$res_n = $this->excQuery($sql);
			
			return $res_n[0][$filed];
		}
		
		
		return 0;
	}
	
	/*
	* @create4CodeOnlyShPtCl($shapeID,$patternID,$color1ID,$color2ID)
	*
	*/
	public function create4CodeOnlyShPtCl($shapeID,$patternID,$color1ID,$color2ID)
	{
		$shapeCode = $this->getSomeDesc($shapeID,"tpp.general_table_tp","3code","gentable_id");
		$patternCode = $this->getSomeDesc($patternID,"tpp.Patterns","code","id");
		$color1Code = $this->getSomeDesc($color1ID,"tpp.prototype_colors","color_code","color_id");
		$color2Code = $this->getSomeDesc($color2ID,"tpp.prototype_colors","color_code","color_id");
		
		
	
		$code4 = $shapeCode;
		if( strlen($patternCode) )
			$code4 .= "-".$patternCode;
		if( strlen($color1Code) && strlen($patternCode) )
			$code4 .= $color1Code;
		else if( strlen($color1Code) )		
			$code4 .= "-".$color1Code;
	
		if( strlen($color2Code) && ( strlen($color1Code) || strlen($patternCode) ) )
			$code4 .= $color2Code;		
		else if( strlen($color2Code) )	
			$code4 .= "-".$color2Code;	
	
		
			
		return 	$code4;
	}
	
	/*
	*@getGlassLastCost($shape_glass_thickness,$pattern_gtype)
	*
	*/
	public function getGlassLastCost($shape_glass_thickness,$pattern_gtype)
	{
		$sql = "SELECT tbl_ts_glass_id
				FROM glass_apps_all.tbl_ts_glass
				WHERE tbl_ts_glass_thickness_id = '".$shape_glass_thickness."'
				AND tbl_ts_glass_glass_type_id = '".$pattern_gtype."'
				LIMIT 1
				";
		$res = $this->excQuery($sql);
		$glass_id = $res[0]['tbl_ts_glass_id'];
		//Last price
		$sql = "SELECT tbl_ts_pricelist_glass_price
				FROM glass_apps_all.tbl_ts_pricelist_glass
				WHERE tbl_ts_pricelist_glass_glass_id = '".$glass_id."'
				AND tbl_ts_pricelist_glass_supplier = '1'
				ORDER BY tbl_ts_pricelist_glass_id DESC,
				tbl_ts_pricelist_glass_date DESC
				LIMIT 1
				";
		//echo $sql;		
		$res_p = $this->excQuery($sql);		
		
		return $res_p[0]['tbl_ts_pricelist_glass_price'];
		
	}
	
	/*
	*@getLabortCostPerCm2()
	*
	*/
	public function getLabortCostPerCm2()
	{
		$sql = "SELECT tbl_param_labor_cost_per_cm2_cost
				FROM glass_apps_all.tbl_param_labor_cost_per_cm2
				ORDER BY tbl_param_labor_cost_per_cm2_id DESC
				";	
		$res = $this->excQuery($sql);
		return $res[0]['tbl_param_labor_cost_per_cm2_cost'];
	}
	
	
	/*
	*@getKopiTroxDifSundelesti($DifficultyGradeID)
	*
	*/
	public function getKopiTroxDifSundelesti($DifficultyGradeID)
	{
		$sql = "SELECT tbl_param_shape_difficulty_production_time
				FROM tpp.tbl_param_shape_difficulty
				WHERE tbl_param_shape_difficulty_id = '".$DifficultyGradeID."'
				";
		$res = $this->excQuery($sql);
		$sund_dfg = $res[0]['tbl_param_shape_difficulty_production_time'];
		/*
		$sund_dfg = 1;
		switch($DifficultyGradeID)
		{
					case "5": //Easy
						$sund_dfg = 0.80;
					break;
					case "1": //Difficult
						$sund_dfg = 0.90;
					break;
					case "2": //Very difficult
						$sund_dfg = 1;
					break;
					case "3": //Very very difficult
						$sund_dfg = 1.10;
					break;
					case "4": //Extremely difficult
						$sund_dfg = 1.20;
					break;
					case "6": //Extremely difficult
						$sund_dfg = 1.40;
					break;
					default:
						$sund_dfg = 1;
					break;	
		}
		*/
		
		return $sund_dfg;
	}
	
	/*
	*@showCm2PerHour($dpt_type_id)
	*
	*/
	public function showCm2PerHour($dpt_type_id)
	{
		$sql = "SELECT tbl_param_dptm_cm2_per_hour_per_person
						FROM glass_apps_all.tbl_param_dptm 
						WHERE tbl_param_dptm_id =  '".$dpt_type_id."' "; 
		$res_k = $this->excQuery($sql);
		$kopi_cm2_per_hour = $res_k[0]['tbl_param_dptm_cm2_per_hour_per_person'];
		
		return $kopi_cm2_per_hour;
	}
	
	/*
	*@showCm2PerHour_MC($dpt_type_id)
	*
	*/
	public function showCm2PerHour_MC($dpt_type_id,$company_id)
	{
		$sql = "SELECT tbl_param_dptm_mc_cm2_per_hour_per_person
				FROM glass_apps_all.tbl_param_dptm_mc 
				WHERE tbl_param_dptm_mc_id =  '".$dpt_type_id."' 
				AND tbl_param_dptm_mc_supplied_by_id = '".$company_id."'
				"; 
		//tbl_param_dptm_mc_company_id		
		//echo $sql;		
		$res_k = $this->excQuery($sql);
		$kopi_cm2_per_hour = $res_k[0]['tbl_param_dptm_mc_cm2_per_hour_per_person'];
		
		return $kopi_cm2_per_hour;
	}
	
	/*
	*@calculateHoursMin($kopi_cm2_per_hour,$TOTAL_KOPI_EASY_DIF)
	*
	*/
	public function calculateHoursMin($kopi_cm2_per_hour,$TOTAL_KOPI_EASY_DIF)
	{
		$hourMinArr = array();
		if( $kopi_cm2_per_hour != 0 ): 
			$this_hours = $TOTAL_KOPI_EASY_DIF / $kopi_cm2_per_hour;
			$hourMinArr[0] = $this_hours_H = (int)$this_hours;
			$hourMinArr[1] = $this_hours_M = round( ($this_hours-$this_hours_H) * 60 );
		
			$persons = (int)ceil($this_hours/5);
		
		elseif($kopi_cm2_per_hour == 0):	
			$this_hours = "";
			$hourMinArr[0] = "";
			$hourMinArr[1] = "";
		endif;	
		
		return $hourMinArr;
	}
	
	/*
	*@calculateHoursMinExtraMin($kopi_cm2_per_hour,$TOTAL_KOPI_EASY_DIF,$extraMin)
	*
	*/
	public function calculateHoursMinExtraMin($kopi_cm2_per_hour,$TOTAL_KOPI_EASY_DIF,$extraMin)
	{
		$hourMinArr = array();
		if( $kopi_cm2_per_hour != 0 ): 
			$this_hours = $TOTAL_KOPI_EASY_DIF / $kopi_cm2_per_hour;
			$this_hours += $extraMin/60; //Minute to Hours
			$hourMinArr[0] = $this_hours_H = (int)$this_hours;
			$hourMinArr[1] = $this_hours_M = round( ($this_hours-$this_hours_H) * 60 );
		
			$persons = (int)ceil($this_hours/5);
		
		elseif($kopi_cm2_per_hour == 0):	
			$this_hours = "";
			$hourMinArr[0] = "";
			$hourMinArr[1] = "";
		endif;	
		
		return $hourMinArr;
	}
	
	
	/*
	*@getNextOrderNo($order_no)
	*
	*/
	public function getNextOrderNo($order_no,$order_bg = "")
	{
		if( $order_no >= 1500 ){
			return $order_no;
		}
		
		
		if( $order_bg == "" ){
			$order_bg = $this->getSomeDesc($order_no,"glass_apps_all.tbl_pp_mandate_detail","tbl_pp_mandate_detail_bg","tbl_pp_mandate_detail_mandate_no");
		}
			
		$next_order_no = $order_no + 1;
		//Get Next Order No.
		$sql = "SELECT tbl_pp_mandate_detail_id
				FROM glass_apps_all.tbl_pp_mandate_detail MD
				
				LEFT JOIN glass_apps_all.tbl_pp_week_program WD ON MD.tbl_pp_mandate_detail_order_id = WD.tbl_pp_week_program_order_id
				
				LEFT JOIN tbl_pp_week_program_header WH ON WD.tbl_pp_week_program_week_program_header_id = WH.tbl_pp_week_program_header_id
				
				WHERE tbl_pp_mandate_detail_mandate_no = '".$next_order_no."'
				AND tbl_pp_mandate_detail_bg = '".$order_bg."'		
				AND tbl_pp_mandate_detail_qc_origin = '1'
				AND ( WH.tbl_pp_week_program_header_prog_type != 'Samples'
					  OR
					  WH.tbl_pp_week_program_header_prog_type IS NULL
					)
				LIMIT 1
				";
		$res = $this->excQuery($sql);
		if( is_numeric( $res[0]['tbl_pp_mandate_detail_id'] ) )
		{
			return 	$next_order_no;
		}
		elseif( !is_numeric( $res[0]['tbl_pp_mandate_detail_id'] ) && $next_order_no < 9999 )
		{
			return $this->getNextOrderNo($next_order_no,$order_bg);	
		}
		else
			return 0; 
		
	}
	
	
	/*
	*@getPreviousOrderNo($id,$order_bg)
	*
	*/
	public function getPreviousOrderNo($order_no,$order_bg = "")
	{
		if( $order_no <= 0 ){
			return 0;
		}
		
		if( $order_bg == "" ){
			
			$order_bg = $this->getSomeDesc($order_no,"glass_apps_all.tbl_pp_mandate_detail","tbl_pp_mandate_detail_bg","tbl_pp_mandate_detail_mandate_no");
			
		}
			
		$previous_order_no = $order_no - 1;
		//Get Next Order No.
		$sql = "SELECT tbl_pp_mandate_detail_id
				FROM glass_apps_all.tbl_pp_mandate_detail MD
				
				LEFT JOIN glass_apps_all.tbl_pp_week_program WD ON MD.tbl_pp_mandate_detail_order_id = WD.tbl_pp_week_program_order_id
				
				LEFT JOIN tbl_pp_week_program_header WH ON WD.tbl_pp_week_program_week_program_header_id = WH.tbl_pp_week_program_header_id
								
				WHERE tbl_pp_mandate_detail_mandate_no = '".$previous_order_no."'
				AND tbl_pp_mandate_detail_bg = '".$order_bg."'
				AND tbl_pp_mandate_detail_qc_origin = '1'
				AND ( WH.tbl_pp_week_program_header_prog_type != 'Samples'
					  OR
					  WH.tbl_pp_week_program_header_prog_type IS NULL
					)
				LIMIT 1
				";
		//echo $sql;		
		$res = $this->excQuery($sql);		
		if( is_numeric( $res[0]['tbl_pp_mandate_detail_id'] ) )
		{
			return 	$previous_order_no;
		}
		elseif( !is_numeric( $res[0]['tbl_pp_mandate_detail_id'] ) && $previous_order_no > 0 )
		{
			return $this->getPreviousOrderNo($previous_order_no,$order_bg);	
		}
		else
			return 0;
	}
	
	
	public function getGlassWaste()
	{
		$sql = "SELECT tbl_param_glass_budget_waste_value 
				FROM tpp.tbl_param_glass_budget_waste
				ORDER BY tbl_param_glass_budget_waste_id DESC
				LIMIT 1
				";	
		$res = $this->excQuery($sql);
		
		return $res[0]['tbl_param_glass_budget_waste_value'];
	}
	
	public function getColorWaste()
	{
		$sql = "SELECT tbl_param_color_budget_waste_value 
				FROM tpp.tbl_param_color_budget_waste
				ORDER BY tbl_param_color_budget_waste_id DESC
				LIMIT 1
				";	
		$res = $this->excQuery($sql);
		
		return $res[0]['tbl_param_color_budget_waste_value'];
	}
	
	public function getTotalProductWaste()
	{
		$sql = "SELECT tbl_param_totalproduct_budget_waste_value 
				FROM tpp.tbl_param_totalproduct_budget_waste
				ORDER BY tbl_param_totalproduct_budget_waste_id DESC
				LIMIT 1
				";	
		$res = $this->excQuery($sql);
		
		return $res[0]['tbl_param_totalproduct_budget_waste_value'];
	}
	
	
	public function getDudgetValue($continent_id,$date_from,$date_to)
	{
		$sql = "SELECT sum(tbl_link_project_budgets_budget) AS budgetSum
				FROM glass_apps.tbl_link_project_budgets LB
				JOIN glass_apps.tbl_crm_followup F ON LB.tbl_link_project_budgets_proj_id = F.tbl_crm_followup_id
				JOIN glass_apps.tbl_ab_company C ON F.tbl_crm_followup_company_id = C.tbl_ab_company_id
				WHERE C.tbl_ab_company_continent = '".$continent_id."'
				AND tbl_link_project_budgets_opening_date BETWEEN '".$date_from."' AND '".$date_to."'
				AND F.tbl_crm_followup_type != '5'
				";
		//echo $sql;		
		$res_budg = $this->excQuery($sql);
		$value = $res_budg[0]['budgetSum'];	
		
		return $value;
	}
	
	
	public function getUnderDiscussion($continent_id,$date_from,$date_to)
	{
		$sql = "SELECT sum(tbl_crm_discussion_budget) AS budgetSum
				FROM glass_apps.tbl_crm_discussion UD
				JOIN glass_apps.tbl_ab_company C ON UD.tbl_crm_discussion_company_id = C.tbl_ab_company_id
				WHERE C.tbl_ab_company_continent = '".$continent_id."'
				AND tbl_crm_discussion_deadline BETWEEN '".$date_from."' AND '".$date_to."'
				AND tbl_crm_discussion_result = '0'
				";
		$res = $this->excQuery($sql);		
		
		$result = $this->checkForCorrectValue($res[0]['budgetSum'], 0);
		
		return $result;
				
	}
	
	
	
	
	/*
	* @excQuery($sql)
	*
	* Δημιουργία options για select input
	*/
	public function createOptionsKilns($fieldsID,$fieldsText,$SelectedID,$table,$where,$orderBy,$descAsc,$kilns_ids)
	{
		$kilns_arr = array();
		$kilns_arr = explode(",",$kilns_ids);
		
		$sql = "SELECT $fieldsID,$fieldsText
				FROM $table ";
		if( strlen($where) > 0 )		
			$sql .= " WHERE ".$where . " " ;
		$sql .= " ORDER BY $orderBy $descAsc";	
		
		$res = mysql_query($sql);
		
		if( $res )
		{
			while( $row = mysql_fetch_array($res) )
			{
				if( $row[$fieldsID] == $SelectedID  )
					$selected = "selected";
				else
					$selected = "";	
				
				$backgroung = "";
				for( $i=0;$i<count($kilns_arr);$i++ )
				{
					if( $kilns_arr[$i] == $row[$fieldsID] )	
					{
						$backgroung = "style=\"background-color:red; color:#fff;\" ";
						break;
					}
				}
				
				$option .= "<option value=\"".$row[$fieldsID]."\" $selected $backgroung>".$row[$fieldsText]."</option>";	
			}
			
			return $option;
		}
		else
			return mysql_error();
		
	}
	
	
	/*
	*@catchErrors($error)	
	*
	*/
	public function catchErrors($error)	
	{
		$sql = "INSERT INTO catched_errors
				(
					catched_errors_date,
					catched_errors_ip,
					catched_errors_agent,
					catched_errors_error
				)
				VALUES
				(
					'".date('y-m-d h:i:s')."',
					'".$_SERVER['REMOTE_ADDR']."',
					'".$_SERVER['HTTP_USER_AGENT']."',
					'".htmlspecialchars($error, ENT_QUOTES)."'
				)
				";	
		$res = @mysql_query( $sql );
	}
	
	
	
	
	
}//end of class


//New Class
class TLogin extends TtblParamAddEditDelete 
{
	var $user_id;
	var $username;
	var $password;
	
	
	/*
	* @setUserID($user_id)
	*
	* Καταχωρεί το user id
	*/
	public function setUserID($user_id)
	{
		$this->user_id = $user_id;
		@session_start();
		//$this->updateWhoisOnline();
	}
	
	
	/*
	* @displayUsername($user_id)
	*
	* Εμφανίζει το Όνομα χρήστη Username
	*/
	public function displayUsername($user_id)
	{
		$sql = "SELECT tbl_param_users_username
				FROM tbl_param_users
				WHERE tbl_param_users_id = '".$this->user_id."' ";
		$res = $this->excQuery($sql);
		
		return $res[0]['tbl_param_users_username'];		
	}
	
	
	
	/*
	* @displayUsername($user_id)
	*
	* Βρίσκει εάν ανήκει ο χρήστης σε μια κατηγοράο φορμών
	*/
	public function hasGroupPrivilege( $RDGroupName )
	{
		$sql = "SELECT tbl_sys_panel_form_group_id
				FROM tbl_sys_panel_form_group FG
				INNER JOIN tbl_sys_link_user_group LG ON FG.tbl_sys_panel_form_group_id = LG.tbl_sys_link_user_group_group_id
				WHERE tbl_sys_panel_form_group_name LIKE '".$RDGroupName."-%'
				AND LG.tbl_sys_link_user_group_user_id = '".$this->user_id."'
				";
				
		$res = $this->excQuery($sql);
		
		if( is_numeric( $res[0]['tbl_sys_panel_form_group_id'] ) )		
			return true;
		else
			return false;	
	}
	
	
	/*
	* @hasGroupPrivilege( $RDGroupName )
	*
	* Βρίσκει εάν ο χρήστης έχει δικαίωμα σε μια φόρμα (formID).
	*/
	public function hasForThisFormPrivilege( $formID )
	{
		$sql = "SELECT tbl_sys_panel_form_group_id
				FROM tbl_sys_panel_form
				WHERE tbl_sys_panel_form_id = '".$formID."' ";
		$res = $this->excQuery($sql);		
		
		$groupID = $res[0]['tbl_sys_panel_form_group_id'];
				
				
		$sql_g = "SELECT tbl_sys_link_user_group_id
				FROM tbl_sys_link_user_group LG
				
				WHERE tbl_sys_link_user_group_group_id = '".$groupID."'  
				AND tbl_sys_link_user_group_user_id = '".$this->user_id."'
				";
		$res_g = $this->excQuery($sql_g);
		
		if( is_numeric( $res_g[0]['tbl_sys_link_user_group_id'] ) )		
			return true;
		else
			return false;
					
	}
	
	
	/*
	* @hasForThisFormPrivilegeDisabled( $authorityID )
	*
	* Βρίσκει εάν ο χρήστης έχει δικαίωμα σε μαι φόρμα (authorityID).
	* Εάν δεν έχει επιστρέφει disabled, αλλιώς τιποτα.
	* Χρισημοποιείται για να ενεγοποιησει ή να απενεργοποιήσει διάφορα
	* Buttons
	*/
	public function hasForThisFormPrivilegeDisabled( $authorityID )
	{
		$sql = "SELECT tbl_sys_link_dpt_authority_dpt_id
				FROM tpp.tbl_sys_link_dpt_authority 
				WHERE tbl_sys_link_dpt_authority_auth_id = '".$authorityID."' ";		
		$res = $this->excQuery($sql);		
		
		
		$itHas = false;
		for( $i=0;$i<count($res);$i++ )
		{
			$dpt_id = $res[$i]['tbl_sys_link_dpt_authority_dpt_id'];
			$sql_g = "SELECT tbl_sys_link_user_group_id
						FROM tpp.tbl_sys_link_user_group LG
				
						WHERE tbl_sys_link_user_group_group_id = '".$dpt_id."'  
						AND tbl_sys_link_user_group_user_id = '".$this->user_id."'
					";
			$res_g = $this->excQuery($sql_g);
		
			if( is_numeric( $res_g[0]['tbl_sys_link_user_group_id'] ) )		
			{
				$itHas = true;
				break;
			}	
			else
				$itHas = false;
		}		
		
		if( $itHas == false )
			$Disabled = "disabled";
		else if( $itHas == true )	
			$Disabled = "";
			
		return $Disabled;	
					
	}
	
	
	/*
	* @hasForThisFormPrivilegeDisabled_V1( $RDGroupName )
	*
	* Βρίσκει εάν ο χρήστης έχει δικαίωμα σε μαι φόρμα (formID).
	* Εάν δεν έχει επιστρέφει disabled, αλλιώς τιποτα.
	* Χρισημοποιείται για να ενεγοποιησει ή να απενεργοποιήσει διάφορα
	* Buttons  Παλιά Έκδοση
	*/
	public function hasForThisFormPrivilegeDisabled_V1( $formID )
	{
		$sql = "SELECT tbl_sys_panel_form_priv_id,tbl_sys_panel_form_group_id
				FROM tpp.tbl_sys_panel_form
				WHERE tbl_sys_panel_form_id = '".$formID."' ";
		$res = $this->excQuery($sql);		
		
		$group_id = $res[0]['tbl_sys_panel_form_group_id'];
		$priv_id = $res[0]['tbl_sys_panel_form_priv_id'];
				
				
		$sql_g = "SELECT tbl_sys_link_user_group_id
				FROM tpp.tbl_sys_link_user_group LG
				
				WHERE tbl_sys_link_user_group_group_id = '".$priv_id."'  
				AND tbl_sys_link_user_group_user_id = '".$this->user_id."'
				";
		$res_g = $this->excQuery($sql_g);
		
		if( is_numeric( $res_g[0]['tbl_sys_link_user_group_id'] ) )		
			$Disabled = "";
		else
			$Disabled = "disabled";
		
		return $Disabled;	
					
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
	
	
	
}			//end of Class TLogin



?>

