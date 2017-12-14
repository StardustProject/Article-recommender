<?php

    //解析从微信上爬取下来的url  从中爬取 作者 时间 标题 内容
    header("Content-type: text/html; charset=utf-8");
    $url='http://chuansong.me/n/2053881051333';
    $wx_content=file_get_contents($url);//利用函数获得网址的内容
 
    $title_html="/.*?<title>(.*?)<\/title>.*?/";//正则匹配文章的标题


    preg_match($title_html, $wx_content, $matchs);
    echo "<<标题>>".$matchs[1];
    //正则匹配文章的添加时间
    $creattime_html="/.*?<em id=\"post-date\" class=\"rich_media_meta rich_media_meta_text\">(.*?)<\/em>.*?/";
    preg_match($creattime_html, $wx_content, $matchs);
    // echo '<pre>';var_dump($matchs);echo '</pre>';
    echo "<<发布时间>>".$matchs[1];
    //     //正则匹配文章的作者
    $wxh_html="/.*?<a class=\"rich_media_meta rich_media_meta_link rich_media_meta_nickname\" href=\"##\" id=\"post-user\">(.*?)<\/a>.*?/";
    preg_match($wxh_html, $wx_content, $matchs);
    // // echo '<pre>';var_dump($matchs);echo '</pre>';
    echo "<<作者>>".$matchs[1]."<br />";
    
    // $result['author'] = $matchs[1];
    $content_html="/<div class=\"content\">(.*?)<\/div>/";
    preg_match($content_html, $wx_content,$mat);
    // preg_match('|<div class="rich_media_content " id="js_content">(.*?)<\/div>|si', $wx_content, $mat);
    echo "文章内容:"."<br />".$mat[1];
  ?>