<?php

$root = $_SERVER['DOCUMENT_ROOT'];

echo $root;
echo "<br>";
echo $_SERVER['SCRIPT_FILENAME'];
echo "<br>";
echo $_SERVER['PHP_SELF'];

echo "<br>";

$rootArr = explode("/", $_SERVER['PHP_SELF'] );

$root = "";
for( $i=0;$i<count($rootArr)-3;$i++ )
$root .= $rootArr[$i]."/";


echo $root;

?>