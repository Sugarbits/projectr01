<?php
$data = $_POST['data'];
$text=$data;
$filename = 'word.txt';
///

error_reporting(E_ALL);
ini_set('display_errors','On');

//$file = "a.jpg";
$file = 'word.txt';

echo sprintf('%o',fileperms($file), PHP_EOL);


if (is_file($file)){
    echo "is_file", PHP_EOL;
    ;
}

if (is_readable($file)){
    echo "is_readable", PHP_EOL;
    ;
}

if (is_writable($file)){
    echo "is_writable", PHP_EOL;
}

$myfile = fopen($filename, "w") or die("Unable to open file!");
echo fwrite($myfile, $text);
fclose($myfile);

/*
if (file_exists($filename)) {
    chmod($filename, 0777);
    echo "The file $filename exists";
	
} else {
    echo "The file $filename does not exist";
}

	$myfile = fopen($filename, "w") or die("Unable to open file!");
	echo fwrite($myfile, $text);
	fclose($myfile);
	*/
?>