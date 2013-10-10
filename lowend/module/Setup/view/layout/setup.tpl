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
        <script type="text/javascript" src="js/ajaxfileupload.js"></script>
        <script type="text/javascript" src="js/store_design_js.js"></script>
        <script type="text/javascript" src="js/store_item_js.js"></script>
    </head>
    <body>
	<div class="container">
    <!-- 共通メニュー -->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">

          <a class="brand" href="/setup">Setup</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="/item">アイテム</a></li>
              <li><a href="/order">オーダー管理</a></li>
              <li><a href="/store_design">デザイン</a></li>
              <li><a href="/data">データ</a></li>
              <li><a href="/user">登録情報</a></li>
              <li><a href="/store">ストア管理</a></li>
              <li><a href="/logout">Logout</a></li>
               <li><a href="#">自分の店</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
	<!-- 共通メニュ Endー -->

	<!-- Content -->

        {$this->content}

	<!-- Content End -->

    <!-- 共通フッダー -->
    <footer >
<hr class="soften">
<a href="#">運用会社</a>
						  <a href="#">アバウト</a>
						  <a href="#">プレス</a>
						  <a href="#">利用規約</a>
						  <a href="#">プライバシーポリ</a>
						  <a href="#">特定商取引法に基づく</a>
						  <a href="#">お問い合わせ</a>
						  <br>
						 <p>&copy; 2013 Estore  All rights reserved.</p>
  	</footer>
    <!-- 共通フッダー End -->
    </div>
    </body>
</html>
