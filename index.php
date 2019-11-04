<?php 
    libxml_disable_entity_loader (false);
    $xmlfile = file_get_contents('php://input');
    $dom = new DOMDocument();
    $dom->loadXML($xmlfile, LIBXML_NOENT | LIBXML_DTDLOAD);
    $creds = simplexml_import_dom($dom);
    $user = $creds->user;
    $pass = $creds->pass;
	$file = 'blindResult.txt'
	$current = file_get_contents($file);
	$current .= $var1;
	file_put_contents($file, $current);
	
    echo "$user";
	echo "$var1";
?> 