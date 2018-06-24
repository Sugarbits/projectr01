<?php
$myfile = fopen("../set/word.txt", "r") or die("Unable to open file!");

// Output one character until end-of-file
       
$str = "";
while(!feof($myfile)) {
  $str.=fgetc($myfile);
}
fclose($myfile);
$str = str_replace("\r\n","$",$str);
//die($str);
//$crr=array("id","name","note");
//$brr = explode("\r\n",$str);
$arr = explode('@@',$str);
echo json_encode($arr);				
/*
foreach ($arr as $key => $value) {
	 echo "{$key} => {$value} ";
	}
*/
?>
