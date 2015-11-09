
<?php
if(isset($_GET['offset']) && isset($_GET['limit']) && $_GET['limit']>0 && $_GET['offset']>0){
$array=array("health"=>array("http://www.usnews.com/blogrss/eat-run"),"Money"=>array("http://www.usnews.com/blogrss/outside-voices-careers"));
 if(!empty($array)){
 foreach($array as $key=>$value){
/*------------------------------------------get category id------------------------------------*/
$keyId='2';//
$arrayValues=array();
            if(!empty($value)){
                foreach($value as $url){
                      $getContent=file_get_contents($url); 
                      $xml = simplexml_load_string($getContent, "SimpleXMLElement", LIBXML_NOCDATA);
                      $json = json_encode($xml);
                      $array = json_decode($json,TRUE);
                   //print_r($array);
                    if(isset($array['channel']) && !empty($array['channel'])){
                        if(isset($array['channel']['item']) && !empty($array['channel']['item'])){
                         $arrayValues= array_merge($arrayValues,$array['channel']['item']);
                        }
                    } 
                }
            }
        }
 } 
 
 $sliceArray=array();
 if(!empty($arrayValues)){
    $sliceArray=array_slice($arrayValues,$_GET['offset'],$_GET['limit']);
    if(!empty($sliceArray)){
        $html='';
        foreach($sliceArray as $sliceArrayInfo){
            $link=isset($sliceArrayInfo['link'])?$sliceArrayInfo['link']:"";
            $title=isset($sliceArrayInfo['title'])?$sliceArrayInfo['title']:"";
            $pubDate=isset($sliceArrayInfo['pubDate'])?$sliceArrayInfo['pubDate']:"";
            $description=isset($sliceArrayInfo['description'])?$sliceArrayInfo['description']:"";
           $html.='<li class="regularitem">
<h4 class="itemtitle"><a href="'.$link.'" target="_blank">'.$title.'</a></h4>
<h5 class="itemposttime">
<span>Posted: </span>'.$pubDate.'</h5>
<div class="itemcontent" name="decodeable">'.$description.' [...]<a href="'.$link.'" target="_blank">read more</a></div>
</li>'; 
        }
echo $html;        
    }
 }
}
 ?>