<?php

$u = "root";
$p = "usbw";
$db = "events";

mysql_connect('localhost', $u, $p) or die('Unable to connect to database: ' . mysql_error()); 
mysql_select_db($db) or die('Unable to select database');
$sql = "SELECT * from event";

$result = mysql_query($sql) or die('Query Failed: ' . mysql_error());



$out = array();
if(!ini_get('date.timezone') )
{
    date_default_timezone_set('EST');
}
while ($row = mysql_fetch_object($result))
{
	$out[] = array(
        'id' => $row->id,
        'title' => $row->title,
        'url' => $row->url . '?id=' . $row->id,
        'class' => $row->class,
        'start' => strtotime($row->start) . '000',
        'end' => strtotime($row->end) . '000'
    );
}

echo json_encode(array('success' => 1, 'result' => $out));
exit;
?>