<?php
header('Content-Type: text/plain');

if (isset($_REQUEST['payload']))
{
	$payload = json_decode(stripslashes($_REQUEST['payload']));
	list($refs, $type, $name) = explode('/', $payload->ref);
	$hash = $payload->after;
}
elseif (isset($_GET['type'], $_GET['name'], $_GET['hash']))
{
	$refs = 'refs';
	$type = $_GET['type'];
	$name = $_GET['name'];
	$hash = $_GET['hash'];
}
else
{
	die('missing arguments');
}

if ($refs == 'refs' && $type == 'tags')
{
	echo 'working dir: ', getcwd(), "\n";
	$res = system(getcwd() . '/repack ' . $name . ' ' . substr($hash, 0, 7), $status);
	if (false === $res)
		die('system failed');

	echo 'status: ', $status, "\n";	
}

die('done');



$payload = json_decode(stripslashes($_REQUEST['payload']));

list($refs, $type, $name) = explode('/', $payload->ref);

if ($refs == 'refs')
{
	switch ($type)
	{
		case 'tags':
			system('repack');
			/*
			$message = "Created tag '$name'";
			$zip_url = 'https://github.com/md2perpe/hook-test/zipball/' . $name;
			$tmp_path = tempnam('/tmp', 'hook-test-');
			mail('md2perpe@gmail.com', 'GitHub Hook', '$zip_url = ' . $zip_url . "\n" . '$tmp_path = ' . $tmp_path);
			rename($zip_url, $tmp_path);
			mail('md2perpe@gmail.com', 'GitHub Hook', 'Renamed $zip_url = ' . $zip_url . ' to ' . '$tmp_path = ' . $tmp_path);
			chdir(dirname($tmp_path));
			system('unzip ' . basename($tmp_path));
			$tmp_content = `ls $tmp_path`;
			mail('md2perpe@gmail.com', 'GitHub Hook', '$tmp_content = ' . $tmp_content);
			*/
			break;

		default:
			$message = "Pushed to '{$payload->ref}'";
			break;
	}
}

echo '<p>Sending mail with $_REQUEST</p>';
mail('md2perpe@gmail.com', 'GitHub Hook', $message . "\n\n" . print_r($payload, true));
echo '<p>Done</p>';
