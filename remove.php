<?php 

//Enter it as it is and escape any single quotes
//Replace Malicious Code

$find='Malicious Code';

 

echo findString('./',$find);

 

function findString($path,$find){

$return='';

ob_start();

if ($handle = opendir($path)) {

while (false !== ($file = readdir($handle))) {

if ($file != "." && $file != "..") {

if(is_dir($path.'/'.$file)){

$sub=findString($path.'/'.$file,$find);

if(isset($sub)){

echo $sub.PHP_EOL;

}

}else{

$ext=substr(strtolower($file),-3);

if($ext=='php'){

$filesource=file_get_contents($path.'/'.$file);

$pos = strpos($filesource, $find);

if ($pos === false) {

continue;

} else {

//The cleaning bit

echo "The string '".htmlentities($find)."' was found in the file '$path/$file and exists at position $pos and has been removed from the source file.<br />";

$clean_source = str_replace($find,'',$filesource);

file_put_contents($path.'/'.$file,$clean_source);

}

}else{

continue;

}

}

}

}

closedir($handle);

}

$return = ob_get_contents();

ob_end_clean();

return $return;

}

?>
