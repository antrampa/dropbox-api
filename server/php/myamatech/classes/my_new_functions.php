<?php


function getTableDuplicates($table)
{
	$newTable = array();
	$newTable = array_unique($table);
	
	return $newTable;
}



function ecartsemester( $date ) {
    $date_time = strtotime( $date );

    // dont ask me why 6.1 i dont know ;)
    // me demandez pas pourquoi 6.1, je sais pas ;)

    $current_semester = (int)floor(date('m', strtotime($date)) / 6.1) + 1;
    $debut_month = ( $current_semester - 1 ) * 6;
    $debut_month++;

    
    $date_start_time = mktime( 0, 0, 0, $debut_month, 1, date( 'Y', $date_time ) );
    $date_start = date( 'Y-m-d 00:00:00', $date_start_time );
    $date_end = date( 'Y-m-d 23:59:59', strtotime( '-1 year -1 day', $date_start_time ) );

    return array( 'date_start' => $date_start, 'date_end' => $date_end );
}


?>