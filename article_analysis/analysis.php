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
    // print_r($article_id);
    // echo sizeof($article);
    // exit;




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
		    //怒、恶、悲、惧、无、惊、好、乐

		    //羞愧  、 内疚 、 冷淡 、 悲观 、 恐惧 、 欲望 、 愤怒 、 骄傲 、 勇气 、 淡定 、 主动 、 宽容 、 明智 、 真爱 、 喜悦 、 平和 、 开悟
		    //1-7 0.17652325219754、0.041510454336762、0.061416377088452、0.2325224905626、0.028832583282193、0.93251588300342、0.088186615651019

		    //8-14 0.99733400722636 0.64032008942675  0.2876725750397   0.959884160367  0.96862063538169  0.71656317208128 0.92522555230401

		    //15-17  0.93037535168914 0.99346271093782  0.96828551555116


		    //开心、伤心、激动、感激、懊丧、愤怒、忧愁、烦乱
		    //0.99997883433992 0.0020279860820273  0.99755022809114 0.92426998614955  0.052522474378796 0.088186615651019 0.32163152828701  0.15833726368225
			/**
			   文章情绪分析
			**/
		   
		 //    $SENTIMENT_URL = 'http://api.bosonnlp.com/sentiment/analysis';   //情绪分析  只能分析到负面概率 和非负面概率
			// $ch = curl_init();
			// curl_setopt_array($ch, array(
			// 	CURLOPT_URL => $SENTIMENT_URL,
			// 	CURLOPT_HTTPHEADER => array(
			// 		"Accept:application/json",
			// 		"Content-Type: application/json",
			// 		"X-Token: $API_TOKEN",
			// 	),
			// 	CURLOPT_POST => true,
			// 	CURLOPT_POSTFIELDS => json_encode($data),
			// 	CURLOPT_RETURNTRANSFER => true,
			// ));
			// $result = curl_exec($ch);
			// var_dump(json_decode($result));
			// curl_close($ch);
            // exit;

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
			$keywords[$cnt] = array();
			$keywords[$cnt]['id'] = $article_id[$k];
			$keywords[$cnt]['key'] = $result;
			// $cnt++;
			echo ++$cnt;
			if($cnt == 1) {
				break;
			}
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


