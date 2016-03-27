<?php
$image = "../../files/SAM_0175.JPG";//"image.jpg";
$exif = exif_read_data($image, 0, true);
foreach ($exif as $key => $section) 
{
	foreach ($section as $name => $val) 
	{
		if($key == "IFD0")
		{
			echo "<br><br> $key.$name: >> $val\n";
		}
		else if( $key == "COMPUTED" )
		{
			echo "<br><br> $key.$name: >> $val\n";
		}
		else if( $key == "FILE" )
		{
			echo "<br><br> $key.$name: >> $val\n";
		}
		else if( $key == "ANY_TAG" )
		{
			echo "<br><br> $key.$name: >> $val\n";
		}
		else if( $key == "THUMBNAIL" )
		{
			echo "<br><br> $key.$name: >> $val\n";
		}
		else if( $key == "COMMENT" )
		{
			echo "<br><br> $key.$name: >> $val\n";
		}
		else if( $key == "EXIF" )
		{
			echo "<br><br> $key.$name: >> $val\n";
		}
	}
}

?>