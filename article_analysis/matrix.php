<?php

    //01矩阵以及匹配的php文件 还未整合到服务器的
    header('content-type:text/html;charset=utf-8');   //规定编码
    //每一篇文章的关键词
  	$myfile = fopen("allkeyword.txt", "r+") or die("Unable to open file!");
	$cnt =  fgets($myfile);
	//var_dump(json_decode($cnt));
	$every_article_key = json_decode($cnt);   //从文件读取到的东西 我们转化为数组形式  
	fclose($myfile);
	//var_dump($every_article_key);
	// echo sizeof($every_article_key);
	//主要的100个标签
	$myfile = fopen("keywords.txt", "r+") or die("Unable to open file!");
	$cnt = fgets($myfile);
	$keywords = json_decode($cnt);
	fclose($myfile);
	//var_dump($keywords);
	$key_content = array();

	foreach ($keywords as $key => $value) {
		# code...
		$key_content[$key] = $value[1];
	}
	// print_r($key_content);
	// exit;
	$matrix = array();  //01矩阵
    $article = array();  //文章
	//构建01矩阵
    foreach ($every_article_key as $key => $value) {
    	# code...
    	$k = 0;
    	$str = array();
        $content = json_decode($value->key);
        $article[$value->id] =  $value->id;
        // 获取整篇文章的关键字
        for ($i=0; $i < sizeof($content); $i++) { 
        	# code...
        				# code....
			//echo $t[$i][1].'<br>';
			if (strlen($content[$i][1]) !=3 && !preg_match ("/^[A-Za-z]/", $content[$i][1]) && !strstr("二维码", $content[$i][1])) {
				# code...
				$str[$k++] = $content[$i][1];
			}
        }
        $article_key = implode(',', $str);
        // echo $article_key;
        // exit;
        $matrix[$value->id] = array();   
        foreach ($key_content as $k_id => $k_content) {
        	# code...  	
        	if ( strstr($article_key,$k_content) ) {
        		# code...
        		$matrix[$value->id][$k_id] = 1;
        	} else {
        		# code...
        		$matrix[$value->id][$k_id] = 0;
        	}
        }
    }

    //计算相似度
    $cos = array();
    $article_id = 234; 
    $current_arc = array();
    $current_arc = $matrix[$article_id];
    for ($i= 1; $i < sizeof($article) ; $i++) { 
    	# code...
    	if ($i == $article_id ) {
    		# code...
    		$cos[$i] = 1.00;
    		continue;
    	}
    	if ($i == 122) {
    		# code...
    		$cos[$i] = 0.00;
    		continue;
    	}
    	$vec_numerator = 0;                     //分子
    	$vec_denominator = 0;                    //分母
    	for ($j=0; $j < sizeof($matrix[$i]); $j++) { 
    		# code...
    		$vec_numerator = $vec_numerator + $current_arc[$j]*$matrix[$i][$j];
    		$vec_denominator = $vec_denominator +  ($current_arc[$j]-$matrix[$i][$j])*($current_arc[$j]-$matrix[$i][$j]);
    	}
    	if ($vec_denominator == 0) {
    		# code...
    		$cos[$i] = 0.0;
    		continue;
    	}
    	$cos[$i] = abs($vec_numerator) / sqrt($vec_denominator) >= 1 ? abs($vec_numerator) / sqrt($vec_denominator) -1:abs($vec_numerator) / sqrt($vec_denominator);   //相似度
    }
    $min = 1.1;
    $return_id = array();
    for ($i=1; $i < sizeof($cos); $i++) { 
    	# code...
    	if ($i <= 10) {
    		# code...
    		 $return_id[$i] = $i;
    		 if ($cos[$i] < $min) {
    		 	# code...
    		 	$min = $cos[$i];
    		 }
    	} else {
    		if($cos[$i] > $min) {
    			// var_dump($return_id);
    			$flag = array();
    			$tmp = $min;
    			$min = $cos[$i];
    			for ($j=1 ; $j <= 10; $j++) { 
    				# code..
    				if ($cos[$return_id[$j]] < $min) {
    					# code...
    					$min = $cos[$return_id[$j]];
    				}
    				if($cos[$return_id[$j]] == $tmp) {
    					if (in_array($i, $return_id) == true) {
    						# code...
    						continue;
    					}
    					$return_id[$j] = $i;
    				}
    			}
    		}
    	}
    }
    var_dump($return_id);
    // echo sizeof($matrix);
    // var_dump($matrix);


 ?>