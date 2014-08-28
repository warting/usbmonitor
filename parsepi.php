<html><body><?php

ini_set('display_errors', true);


date_default_timezone_set('Europe/Stockholm');

include('db.php');

if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
}
?>
<table border="1">
<tr>
<th>Namn</th>
<th>Serienummer</th>
<th>Senast inkopplad</th>
<th></th>
</tr>
<?php

$pluggedRow = 
$timestampOnline = 0;
/* Select queries return a resultset */
if ($result = $db->query("SELECT * FROM usb order by timestampOnline DESC")) {
    // printf("Select returned %d rows.\n", $result->num_rows);

    /* now you can fetch the results into an array - NICE */
    while ($row = $result->fetch_object()) {
		if($timestampOnline == 0) {
			$timestampOnline = $row->timeStampOnline;
		}
		$isPlugged = $timestampOnline == $row->timeStampOnline;
        // use your $myrow array as you would with any other fetch
        print "<tr><td>".$row->name."</td><td>".$row->serialNumber."</td><td>".date('Y-m-d H:i:s', $row->timeStampOnline)."</td><td><img style=\"height:25px\" src=\"".($isPlugged?"green":"red").".png\" \></td></tr>\n";

    }

    /* free result set */
    $result->close();
}

?>
</table>
</body>
</html>
