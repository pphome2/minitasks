<!DOCTYPE HTML>
<html>
	<head>
		<title><?php echo($MT_SITENAME); ?></title>
		<meta charset="utf-8" />
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="icon" href="favicon.png">
		<link rel="shortcut icon" type="image/png" href="favicon.png" />
	</head>
	<style><?php include("$MT_CSS[$styleindex]"); ?></style>
<body>


<div class=all-page>


<header>
<div class="menu">
<ul class="sidenav">
  <li><a class="active" href="<?php echo($MT_SITE_HOME); ?>"><?php echo($L_SITEHOME); ?></a></li>
  <li><a href="<?php echo($MT_ADMINFILE.'?'.$MT_STYLEPARAM_NAME.'='.$styleindex); ?>"><?php echo($L_MTHOME); ?></a></li>
  <li class="liright">
	<div onclick="cardopenclose(cardbodyf)" class="search_icon">
		<div style="transform:rotate(90deg);">&#9740;</div>
	</div>
  </li>
</ul>
</div>

</header>

