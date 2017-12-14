<?php

    header('content-type:text/html;charset=utf-8');
	$myfile = fopen("allkeyword.txt", "r+") or die("Unable to open file!");
	$cnt =  fgets($myfile);
	//var_dump(json_decode($cnt));
	$article = json_decode($cnt);   //从文件读取到的东西 我们转化为数组形式  
	fclose($myfile);
    //查看关键词以及对应的文章id
    // var_dump($article);
    // exit();
    $str = [];
    $k = 0;
    //将所有的关键词处理 处理掉英文 还有奇奇怪怪的词汇  
	foreach ($article as $key => $value) {

		# code...
		$content = json_decode($value->key);
		for ($i=0; $i < sizeof($content ) ; $i++) { 
			# code....
			//echo $t[$i][1].'<br>';
			if (strlen($content[$i][1])!=3 && !preg_match ("/^[A-Za-z]/", $content[$i][1]) && !strstr("二维码", $content[$i][1])) {
				# code...
				$str[$k++] = $content[$i][1];
				// echo strlen($content[$i][1]);
				// exit;
			}
		}
		// echo $value->id .' ';
		// var_dump($value->key);
	}



    // $t = array();
    // $t = json_encode($str);
    // var_dump(json_decode($t));
	// var_dump($str);
	// exit;
	
	$data = implode(',', $str);  //将数组转化为字符串
	$API_TOKEN = "_Y4fJqQe.21418.nlZL0Vunn9tY";  //key  1DwUEeoy.19320.SIh8ADsPbOAT 
	/**
	关键提取
	**/
	$SENTIMENT_URL = 'http://api.bosonnlp.com/keywords/analysis';   //提取关键词  按权重去排序
	$ch = curl_init();
	curl_setopt_array($ch, array(
		CURLOPT_URL => $SENTIMENT_URL,
		CURLOPT_HTTPHEADER => array(
			"Accept:application/json",
			"Content-Type: application/json",
			"X-Token: $API_TOKEN",
		),
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => json_encode($data, JSON_UNESCAPED_UNICODE),
		CURLOPT_RETURNTRANSFER => true,
	)); 

	$result = curl_exec($ch);
	// var_dump(json_decode($result));
	curl_close($ch);
	$file = fopen('keywords.txt', 'w+') or die("Unable to open file!");;
	fwrite($file,$result);
	fclose($file);
	// print_r($str);	
?>