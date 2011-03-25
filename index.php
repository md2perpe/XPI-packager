<?php
$payload = json_decode(stripslashes($_REQUEST['payload']));

echo '<p>Sending mail with $_REQUEST</p>';
mail('md2perpe@gmail.com', 'GitHub Hook', print_r($payload, true));
echo '<p>Done</p>';
