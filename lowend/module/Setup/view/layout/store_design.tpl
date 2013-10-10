<html>
    <head>
    	<title>Low-End Service</title>
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- styles -->
		<link href="/images/teddy.ico" rel="shortcut icon" type="/image/vnd.microsoft.icon">
        <link rel="stylesheet" type="text/css" href="/css/bootstrap-responsive.min.css">
        <link rel="stylesheet" type="text/css" href="/css/style.css">
        <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
        <link href="/css/store_layout_css.css" rel="stylesheet" type="text/css" />

        <!-- Scripts -->
		<!-- [if lt IE 9] -->
     		 <script type="text/javascript" src="/js/html5.js'"></script>
		<!-- [endif] -->
        <script type="text/javascript" src="/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/js/jquery.min.js"></script>
        <script type="text/javascript" src="js/ajaxfileupload.js"></script>
		<script type="text/javascript" src="js/store_design_js.js"></script>

        <style>
body{
	    padding-top: 0px;
	    padding-bottom: 0px;
}
h3 {
font-size:14px;
font-family:verdana, helvetica, arial, sans-serif;

color:#fff;


}

.panel {
z-index:4;
 overflow: scroll;
position: fixed;
top: 10px;
right: 0;
display: true;
color:#666;
background: #000000;
border:1px solid #111111;
-moz-border-radius-topleft: 20px;
-webkit-border-top-left-radius: 20px;
-moz-border-radius-bottomleft: 20px;
-webkit-border-bottom-left-radius: 20px;
width: 280px;
height: 100%;
padding: 30px 130px 30px 30px;
filter: alpha(opacity=85);
opacity: .85;
 padding-bottom: 10px;
}

a.trigger{
z-index:5;
position: fixed;
text-decoration: none;
top: 50px; right: 0;
font-size: 16px;
letter-spacing:-1px;
font-family: verdana, helvetica, arial, sans-serif;
color:#fff;
padding: 20px 15px 20px 40px;
font-weight: 700;
background:#333333 url(images/setup.png) 15% 55% no-repeat;
border:1px solid #444444;
-moz-border-radius-topleft: 20px;
-webkit-border-top-left-radius: 20px;
-moz-border-radius-bottomleft: 20px;
-webkit-border-bottom-left-radius: 20px;
-moz-border-radius-bottomright: 0px;
-webkit-border-bottom-right-radius: 0px;
display: block;
}

a.trigger:hover{
position: fixed;
text-decoration: none;
top: 50px; right: 0;
font-size: 16px;
letter-spacing:-1px;
font-family: verdana, helvetica, arial, sans-serif;
color:#fff;
padding: 20px 20px 20px 40px;
font-weight: 700;
background:#222222 url(images/setup.png) 15% 55% no-repeat;
border:1px solid #444444;
-moz-border-radius-topleft: 20px;
-webkit-border-top-left-radius: 20px;
-moz-border-radius-bottomleft: 20px;
-webkit-border-bottom-left-radius: 20px;
-moz-border-radius-bottomright: 0px;
-webkit-border-bottom-right-radius: 0px;
display: block;
}

a.active.trigger {
background:#222222 url(images/setup.png) 15% 55% no-repeat;
}

ul{
padding: 10px;
margin: 0;
display:block;
list-style: none;
line-height: 100%;
  overflow: auto;

}
.mheader{
 padding-bottom: 10px;
display:block;
font-weight: bold;
}
li{
padding: 0;
float: left;
margin: 0;
display:block;
list-style-type: none;


}

hr{
background-color: #333333;
height: 1px;
}

.color-box{

width:20px;height:20px;
}

.bg_img{
display:block;
width:40px;height:40px;
}

.layoutview{

	width:50px;
	height:50px;
	background-repeat: no-repeat;
	background-position: top;

}
		</style>

		<script>
var store_layout = '{$store->layout}';
var store_name_text_color = '{$store->title_text_color}';
var menu_text_color = '{$store->menu_text_color}';
var item_text_color = '{$store->item_text_color}';
var price_text_color = '{$store->price_text_color}';
var display_item = '{$store->item_display_flag}';
var display_price = '{$store->price_display_flag}';
var display_frame = '{$store->frame_display_flag}';

var store_logo = '{$store->logo}';
var background = '{$store->background}';

var background_original_repeat = 1;

function save(){
	var body = document.body,
    attries = body.attributes,
    arr     = [];
	for(var i=0, len=attries.length; i<len; i++){
	    var attr = attries[i];
	    if(attr.specified){
	        var attr_name = attr.nodeName,
	            attr_val  = attr_name === "style" ? body.style.cssText
	                                              : attr.nodeValue;
	        arr.push( attr_val );
	    }
	}
	var x = arr.join(" ");

	if(display_price == 'Y'){
		display_price = 'N';
	}else{
		display_price = 'Y';
	}

	if(display_frame == 'Y'){
		display_frame = 'N';
	}else{
		display_frame = 'Y';
	}

	document.store_design.layout.value = store_layout;
	document.store_design.title_text_color.value = store_name_text_color;
	document.store_design.menu_text_color.value = menu_text_color;
	document.store_design.item_text_color.value = item_text_color;
	document.store_design.price_text_color.value = price_text_color;
	document.store_design.item_display_flag.value = display_item;
	document.store_design.price_display_flag.value = display_price;
	document.store_design.frame_display_flag.value = display_frame;
	document.store_design.background.value = x;
	document.store_design.logo.value = store_logo;

	document.store_design.submit();
}

</script>

    </head>
    <body style="{$store->background}">
	<!-- Content -->

        {$this->content}

	<!-- Content End -->
<form name="store_design" action="/store_design/excute" method="post">
	<input type="hidden" name="layout" value="sad"/>
	<input type="hidden" name="title_text_color"/>
	<input type="hidden" name="menu_text_color"/>
	<input type="hidden" name="item_text_color"/>
	<input type="hidden" name="price_text_color"/>
	<input type="hidden" name="item_display_flag"/>
	<input type="hidden" name="price_display_flag"/>
	<input type="hidden" name="frame_display_flag"/>
	<input type="hidden" name="logo"/>
	<input type="hidden" name="background"/>
</form>
    </body>
</html>
