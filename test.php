<?php
include "api.php";
$re = new spotify();
echo $re->check("no14yy@gmail.com","thomasblue1");
$info = (json_decode($re, true));
$info->susbcription;
?>
