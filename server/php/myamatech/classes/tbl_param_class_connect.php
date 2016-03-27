<?php
/*
 * Το αντικείμενο TConnect πραγματοποιεί σύνδεση με την βάση δεδομένων MySql
 * Δέχεται σαν ορίσματα τα στοιχεία της βάσης που απαιτούνται για την πραγματοοίηαη
 * της σύνδεσης.
 *
 * Η κλάση αυτή διανέμεται δωρεάν από τον ιδιοκτήτη της.
 *
 *
 * @link 
 * @author   Αντώνης - Αντρανίκ Αμπαρτσουμιάν
 * @package tbl_param_frorm ( Parametric Forms for tpp and address book )
 *
 * @version 1.2
 *
 * @Date Thursday, July 24, 2008

*/

class TConnect
{
	var $database_host;									//Η διεύθυνση IP της βάσης MySql
	var $database_name;									//το όνομα της βάσης
	var $database_user;									//το όνομα χρήστη της βάσης
	var $database_passwd;								//Ο κωδικός της βάσης
	var $database_port;									//Η θύρα της βάσης
	
		
	var $conn_id;   									//Η επιστροφή της mysql_connect για εκτέλεση ερωτημάτων
														//με διαφορετικές συνδέσης βάσεων.
	var $connections_count;						        //Ο αριθμός των συνδέσεων.
	

	public function TConnect()							//δήλωση της κλάσης χωρίς ορίσματα
	{
		$this->database_host   = "";					//Αρχικοποίηση των μεταβλητών
		$this->database_name   = "";
		$this->database_user   = "";
		$this->database_passwd = "";
		$this->database_port   = "3306";				//By default τιμή της MySql
		$this->conn_result     = "";
	}
	
	
	public function helloWorld()
	{
		return "Hello World!";
	}
	
	/*
	* @setValue
	*
	* Ορισμός των παραμέτρων για την 
	* σύνδεση με την βάση δεδομένων									
	*/
	public function setValue($database_host,$database_name,$database_user,$database_passwd)	 
	{
		$this->database_host   = $database_host;
		$this->database_name   = $database_name;
		$this->database_user   = $database_user;
		$this->database_passwd = $database_passwd;
	}
	
	/*
	* @printValue()
	*
	* Εξαγωγή των ορισμάτων της βάσης. 
	* Χρησιμοποιείται γα έλεγχο τψν παραμέτρων. 
	*/
	public function printValue()
	{
		echo "<br>".
			 $this->database_host." ".
		     $this->database_name." ".
		     $this->database_user." ".
		     $this->database_passwd;
	}	 
	
	/*
	* @connectToDatabase()
	*
	* Σύνδεση με την βάση δεδομένων									  
	*/
	public function connectToDatabase()
	{
		$this->conn_id = @mysql_connect($this->database_host,$this->database_user,$this->database_passwd);
		if( $this->conn_id )
		{
			$this->connections_count++;				//Αυξάνεται ο αριθμός των συνδέσεων με την βάση
			return $this->conn_id;
		}
		else
		{
			return mysql_error();
		}
		
	}
	
	public function selectDatabase()
	{
		$result = mysql_select_db($this->database_name);
		if( $result )
		{
			$resultUTF8 = mysql_query("SET NAMES 'utf8'"); 
			
			//include( "onUnload_function.php" );
			
			return $result;
		}
		else
		{
			return die("unable to select db");
		}
	}
	
	/*
	* @quickConnect($database_host,$database_name,$database_user,$database_passwd)
	*
	* Σύνδεση με την βάση δεδομένων με μια εντολή									  
	*/
	public function quickConnect($database_host,$database_name,$database_user,$database_passwd)
	{
		$this->setValue($database_host,$database_name,$database_user,$database_passwd);
		$result = $this->connectToDatabase();
		$result2 = $this->selectDatabase();
		return $result;	 
	}
	
	
	public function mysqlClose()
	{
		mysql_close($this->conn_id);
	}
	
	
	
}

?>