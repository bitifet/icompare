<?php
$f = $_GET["file"];

// Protect from malicious access.
if (
	strpos($f, '/')
	|| !preg_match('/\.tbl\.(?:php|html)$/', $f)
) die("Noghing to look here... ;-)");

highlight_file($f);

?>
