<?php

header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=file.dat");
header("Pragma: no-cache");
header("Expires: 0");

if ($_POST['f']){
  echo($_POST['f']);
}

die;

?>
