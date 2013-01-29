<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head><!--{{{-->
<!-- vim:foldmethod=marker
-->
  <title>itemCompare Demo Page</title>
  <link rel="stylesheet" href="styles.css" type="text/css" media="screen" charset="utf-8" />
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <script src="../iCompare.js"></script>
</head><!--}}}-->
<body><!--{{{-->
<div id="container">
<div id="sidebar">
<div id="menu">
	<h1 id="heading">iCompare Demo</h1>
	<ul>
	<?php
	$files = array();
	$dh = opendir (".");
	while (
		false != $fn = readdir($dh)
	) if (
		($l = strpos ($fn, '.tbl.'))
		&& $fn[0] != '.'
	) $files[$fn] = $l;
	ksort($files);
	foreach ($files as $fn => $l) {
		echo "		<li><a class=\"demo\" href=\"{$fn}\">" . substr($fn, 0, $l) . "</a></li>\n";
	};
	?>
	</ul>
	<p><em>Get iCompare from GitHub:</em> <a href="https://github.com/bitifet/icompare">https://github.com/bitifet/icompare</a></p>
</div>
<h2>Source:</h2>
<div id="source">
</div>
</div>
<div id="view">
</div>
<script type="text/javascript" language="javascript">
<!--
	$(function(){
		$("div#menu ul a").click(function(e){
			var url=$(this).attr("href");
			$("div#view").load(url);
			$("div#source").load("get_code.php?file="+url);
			e.preventDefault();
		}).first().click();

	});
-->
</script>
</body><!--}}}-->
</html>
