<?php

$string = "Text att kryptera!";
$salt = "asdkmpäöl8234-23439*¨¨^?#=)€++98";

echo "Plain-text: $string <br />";
echo "md5(): ". md5($string) ." <br />";
echo "crypt(): ". crypt($string, $salt) ." <br />";
echo "sha1: ". sha1($string) ."<br />";