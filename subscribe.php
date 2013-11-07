<?php

include_once('php-mailjet.class-mailjet-0.1.php');

# Parameters
$params = array(
    'method' => 'POST',
    'contact' => $_REQUEST['email'],
    'id' => '462645'
);
# Call
$response = $mj->listsAddContact($params);
 
# Result
$contact_id = $response->contact_id;
}

?>