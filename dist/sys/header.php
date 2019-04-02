<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
<title><?php echo $tit;?></title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link type="text/css" rel="stylesheet" href="style.css"/>
<script type="text/javascript" src="/static/js/jquery-3.1.1.min.js"></script>
<script src="scripts.js"></script>
</head>
<body>

<div id="wrapper">
<div id="header">
<?php
if (!empty($log)) {
   echo $log;
}
?>

<a class="btn" href="?route=categories&action=rfd">Remove Finished Coupons</a>
<a class="btn" href="?route=import-coupons">Import all coupons</a>
<a class="link-btn" href="?route=categories">Categories</a>
<a class="link-btn" href="/sys/">Shops</a>

</div>
<div class="title"><?php echo $tit;?></div>