<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <title>{$title|default:''}</title>
  <link href="css/bootstrap.min.css" rel+"stylesheet" media="screen">
  <script src="http://code.jquery.com/jquery-1.8.0.min.js">
  <script src="js/bootstrap.min.js"></script>
</head>
<body>
{include file="./header.tpl"}
<div class="content">
{$content|default:''}
</div><!-- content -->
{include file="./footer.tpl"}
</body>
</html>