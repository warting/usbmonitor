<?php
ini_set('display_errors', true);
if($_POST['name']=='usb') {
        $file = file_get_contents($_FILES["filedata"]["tmp_name"]);
        print "ok";
}
else {
        print 'error';
}


preg_match_all('/SerialNumber=(.*?)\s/is', $file, $out);

$dropTableIdExists = "DROP TABLE IF EXISTS usb";

$createTable = "CREATE TABLE IF NOT EXISTS usb (
   id int(11) unsigned NOT NULL auto_increment,
   name varchar(255) NOT NULL default '',
   image varchar(255) NOT NULL default '',
   serialNumber varchar(255) NOT NULL default '',
   timeStampOnline int(11) NOT NULL default '0',
   PRIMARY KEY  (id),
   CONSTRAINT CserialNumber UNIQUE (serialNumber)
   ) ENGINE=MyISAM  DEFAULT CHARSET=utf8";


include('db.php');

if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
}

if(!$result = $db->query($createTable)){
    die('There was an error running the query [' . $db->error . ']');
}
$serials = array();
foreach($out[1] as $serial) {
	if(preg_match("/^[a-zA-Z0-9_]+$/", $serial) == 1) {
		$serials[] = $serial;
	}
}
$time = time();
if(count($serials)>0) {

        $sql = "INSERT INTO usb (serialNumber,timeStampOnline) VALUES ";
        for ($i = 0; $i < count($serials); ++$i)
        {
            if ($i > 0) $sql .= ", ";
            $sql .= "('".$serials[$i]."', ".$time.")";
        }
        $sql .= " ON DUPLICATE KEY UPDATE timeStampOnline=VALUES(timeStampOnline)";
        if(!$result = $db->query($sql)){
            die('There was an error running the query [' . $db->error . ']');
        }
}

?>
