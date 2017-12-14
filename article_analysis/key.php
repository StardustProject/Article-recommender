<?php
    
    // 查看提取出来的100个关键词
    header('content-type:text/html;charset=utf-8');
	$myfile = fopen("keywords.txt", "r+") or die("Unable to open file!");
	$cnt =  fgets($myfile);	
	fclose($myfile);
	$myfile = fopen("tmp.txt", "w+") or die("Unable to open file!");
	$key = json_decode($cnt);
    foreach ($key as $index => $value) {
    	# code...
    	echo $value[1].'<br/>';
    	$tmp = '  \n\n\t  '. $value[1] . '|';
    	fwrite($myfile, $tmp);
    }
    fclose($myfile);
    var_dump($key);
?>