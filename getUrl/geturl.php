<?php
   /**
    *  提取文章的url
    **/
    header("Content-type: text/html; charset=utf-8");
    $conn = mysql_connect("127.0.0.1","root","");
    mysql_select_db("stardust",$conn);
    mysql_query("set names uft8");
    if($conn) echo "链接数据库成功"."<br/>";
    function searchUrl($html) {
        $htm = file_get_contents($html);   //获取url中的内容   该页面的整个html代码
        $prefix = 'http://chuansong.me';
        $dom = new DOMDocument();    //一个容器
        @$dom -> loadHTML($htm);
        //爬取html body a 标签中的url
        $xpath = new DOMXPath($dom);
        $hrefs = $xpath -> evaluate("/html/body//a");
        for ($i = 0; $i < $hrefs->length; $i++) {
            $href = $hrefs->item($i);
            $url = $href->getAttribute('href');  //获取url
            $tmp = $prefix.$url;
            //过滤掉垃圾链接
            if(strstr($url,'#') == false && strstr($url,'app') == false && strstr($url,'account') == false && strstr($url,'about') == false && strstr($url,'http://werank.cn') == false){
                if(strstr($url,'/n') == true){
                    echo $prefix.$url.'<br /><br /><br /> <br />';
                    mysql_query("insert into articles(url) values('$tmp')");
                }
            }
        }
    }
    $s = -12;
    for($i=1;$i<64;$i++){
        $s = $s + 12; 
        searchUrl("http://chuansong.me/account/knowyourself2015?start=".$s); 
    }

?>