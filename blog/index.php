<?php
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
    $sliceArray=array_slice($arrayValues,0,10);
 }
  
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 
<script src="jquery-1.11.1.min.js"></script>
<style type="text/css">
.regularitem {
    list-style: none outside none;
    margin: 10px;
    padding: 10px;
    width: 960px;

background-image: linear-gradient(left top, rgb(245,37,172) 17%, rgb(152,71,222) 59%);
background-image: -o-linear-gradient(left top, rgb(245,37,172) 17%, rgb(152,71,222) 59%);
background-image: -moz-linear-gradient(left top, rgb(245,37,172) 17%, rgb(152,71,222) 59%);
background-image: -webkit-linear-gradient(left top, rgb(245,37,172) 17%, rgb(152,71,222) 59%);
background-image: -ms-linear-gradient(left top, rgb(245,37,172) 17%, rgb(152,71,222) 59%);

background-image: -webkit-gradient(
  linear,
  left top,
  right bottom,
  color-stop(0.17, rgb(245,37,172)),
  color-stop(0.59, rgb(152,71,222))
);

-webkit-border-radius: 10px;
-moz-border-radius: 15px;
border-radius: 15px;

}
h4, h5 {
      margin: 0;
    padding: 0;
}
h4 {
  padding: 5px 0;
}
h4 a {
    color: white;
    font-size: 25px;
    text-decoration: none;
}
</style>
 
</head>

<body>
<?php if(!empty($sliceArray)){ ?>
<div style="text-align: center;"><h1>My Blog</h1></div>
<div>
<ul class="results" id="results" style="margin-left: 9%;">
<?php foreach($sliceArray as $sliceArrayInfo){

 ?>
<li class="regularitem">
<h4 class="itemtitle"><a href="<?php echo isset($sliceArrayInfo['link'])?$sliceArrayInfo['link']:"";  ?>" target="_blank"><?php echo isset($sliceArrayInfo['title'])?$sliceArrayInfo['title']:""; ?></a></h4>
<h5 class="itemposttime">
<span>Posted: </span><?php echo isset($sliceArrayInfo['pubDate'])?$sliceArrayInfo['pubDate']:""; ?></h5>
<div class="itemcontent" name="decodeable"><?php echo isset($sliceArrayInfo['description'])?$sliceArrayInfo['description']:""; ?> [...]<a href="<?php echo isset($sliceArrayInfo['link'])?$sliceArrayInfo['link']:"";  ?>" target="_blank">read more</a></div>
</li>
<?php } ?>
</ul>
<div id="loader_message"></div>
</div>


<script type="text/javascript">
      var busy = false;
      var limit = 10
      var offset = 0;

      function displayRecords(lim, off) {
        $.ajax({
          type: "GET",
          async: false,
          url: "ajax_content.php",
          data: "limit=" + lim + "&offset=" + off,
          cache: false,
          beforeSend: function() {
            $("#loader_message").html("").hide();
            $('#loader_image').show();
          },
          success: function(html) {
            $("#results").append(html);
            $('#loader_image').hide();
            if (html == "") {
              $("#loader_message").html('<button class="btn btn-default" type="button">No more records.</button>').show()
            } else {
              $("#loader_message").html('<img src="loading_large.gif"/>').show();
            }
            window.busy = false;
          }
        });
      }

      $(document).ready(function() {
        // start to load the first set of data
        if (busy == false) {
          //busy = true;
          // start to load the first set of data
          //displayRecords(limit, offset);
        }


        $(window).scroll(function() {
            console.log('-----');
            console.log($(window).scrollTop() + $(window).height() );
            console.log($("#results").height());
            console.log(busy);
          // make sure u give the container id of the data to be loaded in.
          if ($(window).scrollTop() + $(window).height() > $("#results").height() && !busy) {
            busy = true;
            offset = limit + offset;

            // this is optional just to delay the loading of data
            setTimeout(function() { displayRecords(limit, offset); }, 500); 
            // you can remove the above code and can use directly this function
            // displayRecords(limit, offset); 
          }
        });
      });
    </script>
<?php }else{ ?>
<div style="text-align: center;"><h1>No Record Found</h1></div>
<?php  } ?>
 
</body>

</html>

