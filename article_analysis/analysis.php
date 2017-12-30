<?php

    header('content-type:text/html;charset=utf-8');   //规定编码
    $con = mysql_connect("localhost","root","");   //数据库链接
    mysql_select_db("test",$con);
    mysql_query("set names utf8");
    if($con) echo 'success';

    $result = mysql_query("select * from articles");
    $article = [];   //文章内容存取
    $article_id = [];   //用来存取文章id
    $i = 0;
    while ( $articles_content = mysql_fetch_assoc($result)) {
    	# code...
    	// echo $articles_content['content'].'<br/>';
         $article[$i] =  $articles_content['content'];
         $article_id[$i] = $articles_content['id'];
         $i++;
    }

    $myfile = fopen("allkeyword.txt", "w+") or die("Unable to open file!");   //提取出来的关键词放在这.txt文件中国
    $cnt = 0;
    $k = 0;
    $keywords = array();    //保存文章关键词和id
    $API_TOKEN = "vHs8jUdL.21435.-rzExKceLCCM";  //key 1DwUEeoy.19320.SIh8ADsPbOAT   _Y4fJqQe.21418.nlZL0Vunn9tY  vHs8jUdL.21435.-rzExKceLCCM
   //对每一篇文章进行分析
    foreach ($article as $key => $content) {

    	# code...
        if ( $content != null) {
    		# code...
    		 $data =  $content;
			/**
			 *关键提取
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
			$keywords[$cnt] = array();
			$keywords[$cnt]['id'] = $article_id[$k];
			$keywords[$cnt]['key'] = $result;
			$cnt++;
    	}
    	if ($k == 250) {
    		# code...
            $API_TOKEN = "1DwUEeoy.19320.SIh8ADsPbOAT";    //文章篇数过多 
    	}
    	$k++;
    }
    // exit;
  	fwrite($myfile,json_encode($keywords));
    fclose($myfile);
?>


