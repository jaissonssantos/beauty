<?php

use Utils;

ob_start();
session_start();

require_once 'conn/conexao.class.php';
require_once 'conn/url.class.php';
require_once 'vendor/functions.php';

?>

<!DOCTYPE html>
<!--[if IE 8 ]>
<html class="ie" xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br"> 
<![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br">
<!--<![endif]-->
<head>
<!-- Basic Page Needs -->
<meta charset="utf-8">
<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
<title><?=TITLE_APP?></title>
<base href="/">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="">
<!-- Mobile Specific Metas -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="stylesheet" type="text/css" href="main.css">
<link rel="stylesheet" type="text/css" href="assets/css/shortcodes.css">
<link href="images/common/favicon.png" rel="shortcut icon">
<!-- Javascript -->
<script type="text/javascript" src="assets/javascript/plugins.js"></script>
<script type="text/javascript" src="assets/javascript/jquery.livequery.min.js"></script>
<!--[if lt IE 9]>
	<script src="javascript/html5shiv.js"></script>
	<script src="javascript/respond.min.js"></script>
<![endif]-->
</head>

<body>

<?php

$url_path = Url::getURL(0);
$url_subpath = Url::getURL(1);
$url_file = Url::getURL(2);
$url_params = Url::getURL(3);

// echo $url_path.'<br/>';
// echo $url_subpath.'<br/>';
// echo $url_file.'<br/>';
// echo $url_params.'<br/>';

//route url
if(empty($url_path)){
	include 'views/home.php';
}else if(file_exists('views/'.$url_path.'.php')){
	include 'views/'.$url_path.'.php';
}else if(file_exists('views/'.$url_path.'/'.$url_subpath.'.php')){
	include 'views/'.$url_path.'/'.$url_subpath.'.php';
}else if(file_exists('views/'.$url_path.'/'.$url_subpath.'/'.$url_file.'.php')){
	include 'views/'.$url_path.'/'.$url_subpath.'/'.$url_file.'.php';
}else if(file_exists('views/'.$url_path.'/'.$url_subpath.'/')){
	if(file_exists('views/'.$url_path.'/'.$url_subpath.'/index.php')){
		include 'views/'.$url_path.'/'.$url_subpath.'/index.php';
	}else{
		include 'views/'.$url_path.'/'.$url_subpath.'/list.php';
	}
}elseif(file_exists('views/'.$url_path.'/'.$url_subpath.'/'.$url_file.'.php')){
	include 'views/'.$url_path.'/'.$url_subpath.'/'.$url_file.'.php';
}else{
	include 'views/404.php';
}
?>

<!-- Javascript -->
<script type="text/javascript" src="assets/javascript/jquery.countdown.min.js"></script>
<script type="text/javascript" src="assets/javascript/main.js"></script>
<script type="text/javascript" src="assets/javascript/bootstrap-select.min.js"></script>
<script type="text/javascript" src="assets/javascript/app.js"></script>

</body>
</html>