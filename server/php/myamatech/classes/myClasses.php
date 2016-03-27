<?
/*
*	@myClasses.php
*	
*	@Version 3.0
*	@Date	 18-11-2008
*
*	@Created 05-11-2008 
*	@By Ambitos2000
*
*	@Owner 	 Ampartsoumian Antranik - Glass Studio 2008
*
*/
include_once('simple_image.php');

Class TFileUpload extends SimpleImage
{
	var $fileName;
	var $fileFolder;
	var $fileMaxSize;
	var $errorMessage;
	
	function TFileUpload($file_name,$file_folder,$file_maxsize)
	{
		$this->fileName    = $file_name;
		$this->fileFolder  = $file_folder;
		$this->fileMaxSize = $file_maxsize;
		
		$this->errorMessage = "ok";
	}
	
	/*
	*	uploadFile()
	*	
	*/
	public function uploadFile()
	{
		$file_name = $_FILES[$this->fileName]["name"];
		
		if( $_FILES[$this->fileName]["size"] > $this->fileMaxSize ) 
		{
			$this->errorMessage = "File must be small from   ".$this->fileMaxSize." bytes";
			return $this->errorMessage;
		}
		
		if( $file_name == '' || $file_name == null || $file_name == " " ) 
		{
			$this->errorMessage = " Empty file name ";
			return $this->errorMessage;
		}
		
		if( file_exists( $this->fileFolder . $file_name  ) ) 
		{
			 unlink( $this->fileFolder . $file_name );
		}
		
		if( copy( $_FILES[$this->fileName]["tmp_name"], $this->fileFolder . $file_name ) )
		{
			$this->errorMessage = " File Uploaded ";
		}
		else
		{
			$this->errorMessage = " File Not Uploaded ";
		}
		return "ok ".$this->errorMessage;
		
	}
	
	/*
	*	uploadFileAndRename($new_name_prothema)
	*	
	*/
	public function uploadFileAndRename($new_name_prothema)
	{
		$file_name = $_FILES[$this->fileName]["name"];
		//$file_name = rename($file_name,$new_name_prothema.$file_name);
		
		if( $_FILES[$this->fileName]["size"] > $this->fileMaxSize ) 
		{
			$this->errorMessage = "File must be small from   ".$this->fileMaxSize." bytes";
			return $this->errorMessage;
		}
		
		if( $file_name == '' || $file_name == null || $file_name == " " ) 
		{
			$this->errorMessage = " Empty file name ";
			return $this->errorMessage;
		}
		
		if( file_exists( $this->fileFolder . $file_name  ) ) 
		{
			 unlink( $this->fileFolder . $file_name );
		}
		
		if( copy( $_FILES[$this->fileName]["tmp_name"], $this->fileFolder . $new_name_prothema.$file_name ) )
		{
			$this->errorMessage = " File Uploaded ";
			
		}
		else
		{
			$this->errorMessage = " File Not Uploaded ";
		}
		return "ok ".$this->errorMessage;
		
	}
	
	/*
	*	uploadFileAndRename($new_name_prothema)
	*	
	*/
	public function uploadFileRenameAndResize($new_name_prothema,$width)
	{
		$file_name = $_FILES[$this->fileName]["name"];
		//$file_name = rename($file_name,$new_name_prothema.$file_name);
		
		if( $_FILES[$this->fileName]["size"] > $this->fileMaxSize ) 
		{
			$this->errorMessage = "File must be small from   ".$this->fileMaxSize." bytes";
			return $this->errorMessage;
		}
		
		if( $file_name == '' || $file_name == null || $file_name == " " ) 
		{
			$this->errorMessage = " Empty file name ";
			return $this->errorMessage;
		}
		
		if( file_exists( $this->fileFolder . $file_name  ) ) 
		{
			 unlink( $this->fileFolder . $file_name );
		}
		
		if( copy( $_FILES[$this->fileName]["tmp_name"], $this->fileFolder . $new_name_prothema.$file_name ) )
		{
			 $image = new SimpleImage();
			 $image->load($this->fileFolder . $new_name_prothema.$file_name);
		     $image->resizeToWidth($width);
			 $image->save($this->fileFolder . $new_name_prothema.$file_name);
			$this->errorMessage = " File Uploaded ";
			
		}
		else
		{
			$this->errorMessage = " File Not Uploaded ";
		}
		return "ok ".$this->errorMessage;
		
	}
	
	
	/*
	*	uploadFileRenameAndResizeWidthHeight($new_name_prothema,$width,$height)
	*	
	*/
	public function uploadFileRenameAndResizeWidthHeight($new_name_prothema,$width,$height)
	{
		$file_name = $_FILES[$this->fileName]["name"];
		//$file_name = rename($file_name,$new_name_prothema.$file_name);
		
		if( $_FILES[$this->fileName]["size"] > $this->fileMaxSize ) 
		{
			$this->errorMessage = "File must be small from   ".$this->fileMaxSize." bytes";
			return $this->errorMessage;
		}
		
		if( $file_name == '' || $file_name == null || $file_name == " " ) 
		{
			$this->errorMessage = " Empty file name ";
			return $this->errorMessage;
		}
		
		if( file_exists( $this->fileFolder . $file_name  ) ) 
		{
			 unlink( $this->fileFolder . $file_name );
		}
		
		if( copy( $_FILES[$this->fileName]["tmp_name"], $this->fileFolder . $new_name_prothema.$file_name ) )
		{
			 $image = new SimpleImage();
			 $image->load($this->fileFolder . $new_name_prothema.$file_name);
		     $image->resize($width,$height); //resizeToWidth($width);
			 $image->save($this->fileFolder . $new_name_prothema.$file_name);
			$this->errorMessage = " File Uploaded ";
			
		}
		else
		{
			$this->errorMessage = " File Not Uploaded ";
		}
		return "ok ".$this->errorMessage;
		
	}
	
	/*
	*	getFileName()
	*/
	public function getFileName()
	{
		return $_FILES[$this->fileName]["name"];
	}
	
	/*
	*	deleteFile()
	*/
	public function deleteFile()
	{
		if( file_exists( $this->fileFolder . $this->fileName  ) ) 
		{
			 if( unlink( $this->fileFolder . $this->fileName ) )
			 	return "Deleted File";
			else
				return "Error";	
		}
		else
			return "File not exist";
	}
	
}

Class TSorter
{
	var $PARAM_NAMES;									//Request Parameters Names
	var $PARAM_VALUES;									//Request Parameters Values
	
	var $formName;										//Form Name for submit
	var $formAction;
	
	var $upImgPath;
	var $downImgPath;
	
	var $sortedField;
	var $descAsc;
	
	function TSorter($arrParamNames,$arrParamValues,$frName,$frAction,$upImagePath,$downImagePath,$stdFiled)
	{
		for( $i=0; $i<count( $arrParamNames ); $i++ )
		{
			$this->PARAM_NAMES[$i]  = $arrParamNames[$i];
			$this->PARAM_VALUES[$i] = $arrParamValues[$i];
		}
		
		$this->formName    = $frName;
		$this->upImgPath   = $upImagePath;
		$this->downImgPath = $downImagePath;
		$this->sortedField = $stdFiled;
		$this->formAction  = $frAction;
	}
	
	/*
	* @createInputsParameters()
	*/
	public function createInputsParameters()
	{
		for( $i=0; $i<count( $this->PARAM_NAMES ); $i++ )
		{
			print "<input type=\"hidden\" name=\"".$this->PARAM_NAMES[$i]."\" value=\"".$this->PARAM_VALUES[$i]."\">";
		}
		print "<input type=\"hidden\" name=\"sortedField\" value=\"".$this->sortedField."\">";
		print "<input type=\"hidden\" name=\"ascDesc\" value=\"".$this->descAsc."\">";
	}
	
	
	/*
	* @sorted($fildText,$sortedFD,$descAsc,$thisSortedFieldName,$class)
	*/
	public function sorted($fildText,$sortedFD,$descAsc,$thisSortedFieldName,$class)
	{
		if( $descAsc == "DESC" )
		{
			$descAsc = "ASC";
			if( $thisSortedFieldName == $this->sortedField )
				$img = "<font style=\"text-decoration:none;\">&nbsp;&nbsp; <img border=\"0\" src=\"".$this->downImgPath."\"> </font>";
		}	
		else if( $descAsc == "ASC" )
		{
			$descAsc = "DESC";	
			if( $thisSortedFieldName == $this->sortedField )
				$img = "<font style=\"text-decoration:none;\">&nbsp;&nbsp; <img border=\"0\" src=\"".$this->upImgPath."\"> </font>";
		}	
		else if( $descAsc == "" )
		{
			$descAsc = "DESC";	
			//$img = "<img src=\"".$this->upImgPath."\">";
		}	
		else
		{
			$descAsc = "";	
			$img = "";
		}
		
		echo "<a href=\"#\" class=\"".$class."\" onClick=\"document.".$this->formName.".ascDesc.value = '".$descAsc."'; document.".$this->formName.".sortedField.value = '".$sortedFD."'; document.".$this->formName.".action = '".$this->formAction."';  document.".$this->formName.".submit();\"> $fildText $img</a>";
		/*print "<script> document.".$this->formName.".submit(); </script>";*/
	}				
	
}



Class TPagging
{
	var $MAX_PAGE;								//Number of items in a page
	var $page_number;							//Number of all items ( count(*) )				
	var $max_page_soring;						//Max number of page numbers ( 1,2,3,4.... i )	i->max_page_soring
	
	var $url;
	var $form;
	
	
	public function TPagging($the_max_page,$the_page_number,$the_max_page_sorting,$the_url,$the_from)
	{
		$this->MAX_PAGE        = $the_max_page;
		$this->page_number     = $the_page_number;
		$this->max_page_soring = $the_max_page_sorting;
		$this->url             = $the_url;
		$this->from            = $the_from;
	}
	
	
	/*
	* @showSorters($className)
	*
	*/
	public function showSorters($from,$className)
	{
		if( $this->from == ( ($this->max_page_soring -1) * $this->MAX_PAGE  ) )	
			$this->max_page_soring++;
		
		if( intval( ($this->page_number/$this->MAX_PAGE) ) <= $this->max_page_soring )
			$this->max_page_soring = intval( ($this->page_number/$this->MAX_PAGE) );
	
	
		if( $this->from > 0 )
			echo "<a class=\"".$className."\" href=\"".$this->url."?max_page_soring=".$this->max_page_soring."&from=0\">First</a> ";
        else
			echo "First ";
			
		if( $this->from > 0 )
	        echo "<a class=\"".$className."\" href=\"".$this->url."?max_page_soring=".$this->max_page_soring."&from=".( $this->from - $this->MAX_PAGE )."\">Prev</a> &nbsp;";
		else	
        	echo "Prev &nbsp;"; 
        
		
		for( $i=0; $i<$this->max_page_soring; $i++ )
		{
			if( $this->from == ( $i * $this->MAX_PAGE ) )
				echo ($i+1)." ";	
			else
				echo "<a class=\"".$className."\" href=\"".$this->url."?max_page_soring=".$this->max_page_soring."&from=".( $i * $this->MAX_PAGE )."\">".($i+1)."</a> ";
		}	
		
		echo "&nbsp; of ".intval( ($this->page_number/$this->MAX_PAGE) )."&nbsp;";
        
		if( ( $this->from + $this->MAX_PAGE ) <= $this->page_number )
	        echo "&nbsp; <a class=\"".$className."\" href=\"".$this->url."?max_page_soring=".$this->max_page_soring."&from=".( $this->from + $this->MAX_PAGE )."\">Next</a>";
		else	
        	echo "&nbsp; Next";
		
		if( ( $this->from + $this->MAX_PAGE ) <= $this->page_number )
	        echo " <a class=\"".$className."\" href=\"".$this->url."?max_page_soring=".$this->max_page_soring."&from=".( $this->page_number - $this->MAX_PAGE )."\">Last</a>";
        else
			echo " Last";
		
	}
	
}



Class TSorterPagging
{
	var $PARAM_NAMES;									//Request Parameters Names
	var $PARAM_VALUES;									//Request Parameters Values
	
	var $formName;										//Form Name for submit
	var $formAction;
	
	var $upImgPath;
	var $downImgPath;
	
	var $sortedField;
	var $descAsc;
	
	var $limit_from;
	var $limit_to;
	var $limit_diafora;
	var $paggng_lastPage;
	
	var $previous_img;
	var $next_img;
	var $first_page;
	var $last_page;
	
	var $pagImgWidth;
	
	var $show_me_all;	
	
	
	function TSorterPagging($arrParamNames,$arrParamValues,$frName,$frAction,$upImagePath,$downImagePath,$stdFiled,$prevImg,$nextImg,$limitFrom,$limitTo,$diafora, $firstPage = '', $lastPge = '', $__show_me_all = '' )
	{
		for( $i=0; $i<count( $arrParamNames ); $i++ )
		{
			$this->PARAM_NAMES[$i]  = $arrParamNames[$i];
			$this->PARAM_VALUES[$i] = $arrParamValues[$i];
		}
		
		$this->formName    = $frName;
		$this->upImgPath   = $upImagePath;
		$this->downImgPath = $downImagePath;
		$this->sortedField = $stdFiled;
		$this->formAction  = $frAction;
		
		$this->previous_img = $prevImg;
		$this->next_img     = $nextImg;
		$this->limit_from   = $limitFrom;
		$this->limit_to 	= $limitTo;
		$this->limit_diafora = $diafora;
		
		$this->pagImgWidth = 12;
		
		$this->first_page = $firstPage;
		$this->last_page = $lastPge;
		
		$this->show_me_all = $__show_me_all;
	}
	
	/*
	* @createInputsParameters()
	*/
	public function createInputsParameters()
	{
		for( $i=0; $i<count( $this->PARAM_NAMES ); $i++ )
		{
			print "<input type=\"hidden\" name=\"".$this->PARAM_NAMES[$i]."\" value=\"".$this->PARAM_VALUES[$i]."\">";
		}
		print "<input type=\"hidden\" name=\"sortedField\" value=\"".$this->sortedField."\">";
		print "<input type=\"hidden\" name=\"ascDesc\" value=\"".$this->descAsc."\">";
		
		print "<input type=\"hidden\" name=\"limit_from\" value=\"".$this->limit_from."\">";
		print "<input type=\"hidden\" name=\"limit_to\" value=\"".$this->limit_to."\">";
		print "<input type=\"hidden\" name=\"show_me_all\" value=\"".$this->show_me_all."\">";
	}
	
	
	/*
	* @sorted($fildText,$sortedFD,$descAsc,$thisSortedFieldName,$class)
	*/
	public function sorted($fildText,$sortedFD,$descAsc,$thisSortedFieldName,$class)
	{
		if( $descAsc == "DESC" )
		{
			$descAsc = "ASC";
			if( $thisSortedFieldName == $this->sortedField )
				$img = "<font style=\"text-decoration:none;\">&nbsp;&nbsp; <img border=\"0\" src=\"".$this->downImgPath."\"> </font>";
		}	
		else if( $descAsc == "ASC" )
		{
			$descAsc = "DESC";	
			if( $thisSortedFieldName == $this->sortedField )
				$img = "<font style=\"text-decoration:none;\">&nbsp;&nbsp; <img border=\"0\" src=\"".$this->upImgPath."\"> </font>";
		}	
		else if( $descAsc == "" )
		{
			$descAsc = "DESC";	
			//$img = "<img src=\"".$this->upImgPath."\">";
		}	
		else
		{
			$descAsc = "";	
			$img = "";
		}
		
		echo "<a href=\"#\" class=\"".$class."\" onClick=\"document.".$this->formName.".ascDesc.value = '".$descAsc."'; document.".$this->formName.".sortedField.value = '".$sortedFD."'; document.".$this->formName.".action = '".$this->formAction."';  document.".$this->formName.".submit();\"> $fildText $img</a>";
		/*print "<script> document.".$this->formName.".submit(); </script>";*/
	}	
	
	
	
	/*
	* @pagging()
	*/
	public function pagging($count,$class)
	{
		if( $this->limit_from > 0 )	//Previous
		{
			echo "<a href=\"#\"  title=\"Previous\" class=\"".$class."\" onClick=\"document.".$this->formName.".limit_from.value = '".( $this->limit_from - $this->limit_diafora) ."'; document.".$this->formName.".action = '".$this->formAction."';  document.".$this->formName.".submit();\"> <img src=\"".$this->previous_img."\" border=\"0\" width=\"".$this->pagImgWidth."\"></a>";
		}
		else
		{
			echo "<a  title=\"Previous\" class=\"".$class."\" > <img src=\"".$this->previous_img."\" border=\"0\"  width=\"".$this->pagImgWidth."\"></a>";
		}	
		
		$pageNumbers = (int)($count / $this->limit_diafora); 
		
		$upolupo = ($count % $this->limit_diafora);
		if( $upolupo > 0 )
			$pageNumbers++;
		
		if( $pageNumbers == 0 )
			$pageNumbers = 1;
			
		$displayedPage = (int)round( ($this->limit_from / $this->limit_diafora) +1 ); 
		
		echo " &nbsp;&nbsp;
				<font class=\"".$class."\">
					".$displayedPage." / ".$pageNumbers." Pages
				</font>
			   &nbsp;&nbsp; 	
			";
		
	/*	echo " &nbsp;&nbsp;
				<font class=\"".$class."\">
					".$this->limit_from." - ".( $this->limit_from + $this->limit_diafora )." / ".$count."
				</font>
			   &nbsp;&nbsp; 	
			";
	*/	
			
			
		
		if( ( $this->limit_from + $this->limit_diafora ) < $count )	//Next
		{
			echo "<a href=\"#\" title=\"Next\" class=\"".$class."\" onClick=\"document.".$this->formName.".limit_from.value = '".( $this->limit_from + $this->limit_diafora) ."'; document.".$this->formName.".limit_to.value = '".( $this->limit_from + $this->limit_diafora) ."'; document.".$this->formName.".action = '".$this->formAction."';  document.".$this->formName.".submit();\"> <img src=\"".$this->next_img."\" border=\"0\"  width=\"".$this->pagImgWidth."\"></a>";
		}
		else
		{
			echo "<a  title=\"Next\" class=\"".$class."\" > <img src=\"".$this->next_img."\" border=\"0\"  width=\"".$this->pagImgWidth."\"></a>";
		}	
		
	}
	
	
	
	/*
	* @pagging_v4()
	*/
	public function pagging_v4($count,$class)
	{
		if( $this->limit_from > 0 )	//Previous
		{
			echo "<a href=\"#\"  title=\"First Page\" class=\"".$class."\" onClick=\"document.".$this->formName.".limit_from.value = '0'; document.".$this->formName.".action = '".$this->formAction."';  document.".$this->formName.".submit();\"><img src=\"".$this->first_page."\" border=\"0\" width=\"".$this->pagImgWidth."\"></a> &nbsp; ";
						
			echo "<a href=\"#\"  title=\"Previous\" class=\"".$class."\" onClick=\"document.".$this->formName.".limit_from.value = '".( $this->limit_from - $this->limit_diafora) ."'; document.".$this->formName.".action = '".$this->formAction."';  document.".$this->formName.".submit();\"><img src=\"".$this->previous_img."\" border=\"0\" width=\"".$this->pagImgWidth."\"></a>";
		}
		else
		{
			echo "<a  title=\"First Page\" class=\"".$class."\" > <img src=\"".$this->first_page."\" border=\"0\" width=\"".$this->pagImgWidth."\"></a> &nbsp; ";
			echo "<a  title=\"Previous\" class=\"".$class."\" > <img src=\"".$this->previous_img."\" border=\"0\" width=\"".$this->pagImgWidth."\"></a>";
		}	
		
		$pageNumbers = (int)($count / $this->limit_diafora); 
		
		$upolupo = ($count % $this->limit_diafora);
		if( $upolupo > 0 )
			$pageNumbers++;
		
		if( $pageNumbers == 0 )
			$pageNumbers = 1;
			
		$displayedPage = (int)round( ($this->limit_from / $this->limit_diafora) +1 ); 
		
		$this->paggng_lastPage = ($pageNumbers * $this->limit_diafora ) - $this->limit_diafora;//$this->limit_from + ( $this->limit_diafora * $pageNumbers );
		
		echo " &nbsp;&nbsp;
				<div class=\"paggeNo\" style=\"display:inline;\">
					".$displayedPage." / ".$pageNumbers." Pages
				</div>
			   &nbsp;&nbsp; 	
			";
		
	/*	echo " &nbsp;&nbsp;
				<font class=\"".$class."\">
					".$this->limit_from." - ".( $this->limit_from + $this->limit_diafora )." / ".$count."
				</font>
			   &nbsp;&nbsp; 	
			";
	*/	
			
	
	/*	
		for( $i=1;$i<=$pageNumbers;$i++ )
		{
			$Fclass = "pagging_numbers";
			if( $i == (($this->limit_from / $this->limit_diafora)+1) ) $Fclass = "pagging_numbers_selected";
		
			$paging_numbers .= " &nbsp;<u><a href=\"javascript:void(0)\" title=\"page ".$i."\" class=\"".$Fclass."\" onClick=\"document.".$this->formName.".limit_from.value = '".( $this->limit_diafora*($i-1) ) ."'; document.".$this->formName.".limit_to.value = '".( $this->limit_diafora*($i-1) )."'; document.".$this->formName.".action = '".$this->formAction."';  document.".$this->formName.".submit();\"> ".$i." </a></u>&nbsp; ";
		}
	*/	
		/*
		echo " &nbsp;&nbsp;
				 <div class=\"paggeNo\">
					page ".$displayedPage." of ".$pageNumbers." 
				</div>
			   &nbsp;&nbsp; 	
			";
			*/
	/*	
	echo " &nbsp;&nbsp;
				 <div class=\"paggeNo\">
					".$paging_numbers."
				</div>
			   &nbsp;&nbsp; 	
			";
		*/	
			
		
		if( ( $this->limit_from + $this->limit_diafora ) < $count )	//Next
		{
			echo "<a href=\"javascript:void(0)\" title=\"Next\" class=\"".$class."\" onClick=\"document.".$this->formName.".limit_from.value = '".( $this->limit_from + $this->limit_diafora) ."'; document.".$this->formName.".limit_to.value = '".( $this->limit_from + $this->limit_diafora) ."'; document.".$this->formName.".action = '".$this->formAction."';  document.".$this->formName.".submit();\"><img src=\"".$this->next_img."\" border=\"0\"  width=\"".$this->pagImgWidth."\"></a> &nbsp; ";
				 
			echo "<a href=\"javascript:void(0)\" title=\"Last Page\" class=\"".$class."\" onClick=\"document.".$this->formName.".limit_from.value = '".( $this->paggng_lastPage ) ."'; document.".$this->formName.".limit_to.value = '".( $this->paggng_lastPage ) ."'; document.".$this->formName.".action = '".$this->formAction."';  document.".$this->formName.".submit();\"><img src=\"".$this->last_page."\" border=\"0\"  width=\"".$this->pagImgWidth."\"></a>";	 
			
		}
		else
		{
			echo "<a  title=\"Next\" class=\"".$class."\" > <img src=\"".$this->next_img."\" border=\"0\"  width=\"".$this->pagImgWidth."\"></a> &nbsp; ";
			
			echo "<a  title=\"Last Page\" class=\"".$class."\" > <img src=\"".$this->last_page."\" border=\"0\"  width=\"".$this->pagImgWidth."\"></a>";
		}	
		
	}
	
	/*
	* @showMeAll() 
	*
	*/
	public function showMeAll($count,$className)
	{
		$pageNumbers = (int)($count / $this->limit_diafora); 
		
		$upolupo = ($count % $this->limit_diafora);
		if( $upolupo > 0 )
			$pageNumbers++;
		
		if( $pageNumbers == 0 )
			$pageNumbers = 1;
			
		$displayedPage = (int)round( ($this->limit_from / $this->limit_diafora) +1 ); 
		
		$this->paggng_lastPage = ($pageNumbers * $this->limit_diafora );// - $this->limit_diafora;//$this->limit_from + ( $this->limit_diafora * $pageNumbers );
		if( $this->paggng_lastPage <= 0 )
			$this->paggng_lastPage = $count;//$this->limit_diafora;
		
	
		echo "<input type=\"button\" class=\"".$className."\" value=\"Show Me All\" title=\"Show Me All\" onClick=\"document.".$this->formName.".limit_from.value = '".( 0 ) ."'; document.".$this->formName.".show_me_all.value = '".( $this->paggng_lastPage) ."'; document.".$this->formName.".action = '".$this->formAction."';  document.".$this->formName.".submit();\" >&nbsp; ";
	}
	
	
	/*
	* @Print() 
	*
	*/
	public function searchPrint($count,$className,$siteName,$target)
	{
		$pageNumbers = (int)($count / $this->limit_diafora); 
		
		$upolupo = ($count % $this->limit_diafora);
		if( $upolupo > 0 )
			$pageNumbers++;
		
		if( $pageNumbers == 0 )
			$pageNumbers = 1;
			
		$displayedPage = (int)round( ($this->limit_from / $this->limit_diafora) +1 ); 
		
		$this->paggng_lastPage = ($pageNumbers * $this->limit_diafora );// - $this->limit_diafora;//$this->limit_from + ( $this->limit_diafora * $pageNumbers );
		if( $this->paggng_lastPage <= 0 )
			$this->paggng_lastPage = $count;//$this->limit_diafora;
			
		echo "<input type=\"button\" class=\"".$className."\" value=\"Print All\" title=\"Print All\" onClick=\"
		document.".$this->formName.".limit_from.value = '".( 0 ) ."'; document.".$this->formName.".show_me_all.value = '".( $this->paggng_lastPage) ."'; document.".$this->formName.".action = '".$siteName."';  document.".$this->formName.".target = '".$target."';  document.".$this->formName.".submit();\" >&nbsp;&nbsp;  ";
	}
	
				
	
}//end of Class

?>