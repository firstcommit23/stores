<html>
    <head>
    	<title>Low-End Service</title>
        <meta charset="utf-8">
        <!-- styles -->
		<link href="/images/teddy.ico" rel="shortcut icon" type="/image/vnd.microsoft.icon">
        <link rel="stylesheet" type="text/css" href="/css/bootstrap-responsive.min.css">
        <link rel="stylesheet" type="text/css" href="/css/style.css">
        <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">

        <!-- Scripts -->
		<!-- [if lt IE 9] -->
     		 <script type="text/javascript" src="/js/html5.js'"></script>
		<!-- [endif] -->
        <script type="text/javascript" src="/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/js/jquery.min.js"></script>
    </head>
    <body>

    <!-- 共通メニュー -->
        <div class="container">
        <div align="right">
			<a href="https://twitter.com/share" class="twitter-share-button" data-text="注目テスト！" data-via="jm131313" data-lang="ja">ツイート</a>
			<div class="fb-like" data-href="http://estore.co.jp" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true" data-font="arial"></div>
			<div id="fb-root"></div>
		</div>
		<div class="container-narrow">
		      <div class="masthead">
		        <ul class="nav nav-pills pull-right">
		          <li><a href="/#menu1">サービス紹介</a></li>
		          <li><a href="/#menu2">はじめかた</a></li>
		          <li><a href="/#menu3">ストア事例</a></li>
		           <li><a href="/#menu4">機能</a></li>
		            <li><a href="/#menu5">料金</a></li>
		          <li class="active"><a href="/help">ヘルプ</a></li>
		          <li class="active"><a href="/login">ログイン</a></li>
		        </ul>
		        <h3 class="muted"><a href="/">StoreBox</a></h3>
		      </div>
		</div>
		<br>
	<!-- 共通メニュ Endー -->

	<!-- Content -->
        {$this->content}
	<!-- Content End -->

    <!-- 共通フッダー -->

    <footer >
			<hr class="soften">



			<div class="container-fluid">
			  <div class="row-fluid" >
			    <div class="span4">
			    	<ul class="unstyled">
			 			 <li><a href="#">運用会社</a></li>
						  <li><a href="#">アバウト</a></li>
						  <li><a href="#">プレス</a></li>
						  <li><a href="#">利用規約</a></li>
						  <li><a href="#">プライバシーポリ</a></li>
						  <li><a href="#">特定商取引法に基づく</a></li>
						  <li><a href="#">お問い合わせ</a></li>

					</ul>
    			</div>
    			<div class="span5">
    				 <iframe src="//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2FEstore.official&amp;width=500&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;border_color=%23fff&amp;stream=false&amp;header=false&amp;appId=338237512940636" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:500px; height:258px;" allowTransparency="true"></iframe>
    			</div>
  			  </div>
			</div>
			<br>
   			<p>&copy; 2013 Estore  All rights reserved.</p>
			{literal}
				<div id="fb-root"></div>
				<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/ko_KR/all.js#xfbml=1";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));</script>
				<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/ko_KR/all.js#xfbml=1";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));</script>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			{/literal}
  	</footer>
    <!-- 共通フッダー End -->
    </body>
</html>
