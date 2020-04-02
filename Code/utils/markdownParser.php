<?php
function parseMarkdown($str) {

	$link_rex = '\[([A-Za-z0-9 \.\-_\/\\]*)\]\((https?:\/\/[A-Za-z0-9\.\/\-_]*)\)/m';
	$it_rex = "/ _([A-Za-z0-9 \-\.\/\\]+)_ /m";
	$bold_rex = "/ \*\*([A-Za-z0-9 \-\.\/\\]+)\*\* /m";
	$h_rex = " ([A-Za-z0-9 \-\.\/\\_]+)/m";

	$out = preg_replace_callback($bold_rex, function ($m) {return "<b>$m[1]</b>";}, $str);
	$out = preg_replace_callback($it_rex, function ($m) {return "<i>$m[1]</i>";}, $out);
	$out = preg_replace_callback("/!" . $link_rex, function ($m) {return "<img src=\"$m[2]\" alt=\"$m[1]\"/>";}, $out);
	$out = preg_replace_callback("/" . $link_rex, function ($m) {return "<a href=\"$m[2]\">$m[1]</a>";}, $out);
	$out = preg_replace_callback("/###" . $h_rex, function ($m) {return "<h3>$m[1]</h3>";}, $out);
	$out = preg_replace_callback("/##" . $h_rex, function ($m) {return "<h2>$m[1]</h2>";}, $out);
	$out = preg_replace_callback("/#" . $h_rex, function ($m) {return "<h1>$m[1]</h1>";}, $out);

return $out;
}
?>