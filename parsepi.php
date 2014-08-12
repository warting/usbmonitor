<html><body><?php

ini_set('display_errors', true);


date_default_timezone_set('Europe/Stockholm');

$file = file_get_contents('out.txt');

preg_match_all('/SerialNumber=(.*?)\s/is', $file, $out);
//print_r($out[1]);


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
</tr>
<?php

/* Select queries return a resultset */
if ($result = $db->query("SELECT * FROM usb order by timestampOnline DESC")) {
    // printf("Select returned %d rows.\n", $result->num_rows);

    /* now you can fetch the results into an array - NICE */
    while ($row = $result->fetch_object()) {
        // use your $myrow array as you would with any other fetch
        print "<tr><td>".$row->name."</td><td>".$row->serialNumber."</td><td>".date('Y-m-d H:i:s', $row->timeStampOnline)."</td></tr>\n";

    }

    /* free result set */
    $result->close();
}

?>
</table>
</body>
</html>
