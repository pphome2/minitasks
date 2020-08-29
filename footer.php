
</div>

<?php
    $nextstyle=$styleindex+1;
    if ($nextstyle>(count($MT_CSS)-1)){
		$nextstyle=0;
    }
?>

<footer>

  <ul class="sidenav">
    <li class="padleft"><?php echo($COPYRIGHT); ?></li>
    <li class="liright">
	<a href="<?php echo($MT_SITE_ADMINFILE."?".$MT_STYLEPARAM_NAME."=".$nextstyle); ?>"><?php echo($L_THEME); ?></a>
    </li>
    <li class="liright">
	<a href="<?php echo($MT_PRIVACY."?".$MT_STYLEPARAM_NAME."=".$styleindex) ?>" ><?php echo($L_PRIVACY_MENU); ?></a>
    </li>
  </ul>

</footer>

</body>
</html>
