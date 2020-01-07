<?php
if (!isset($_GET['target'])) {
    $_GET['target'] = 'axislabelbkgex01.php';
}
if (!isset($_GET['folder'])) {
    $_GET['folder'] = 'examples_axis';
}

$target = basename(urldecode($_GET['target']));
$folder = basename(urldecode($_GET['folder']));

?>
<!doctype html public "-//W3C//DTD HTML 4.0 Frameset//EN">
<html>
<head>
<title> Test suite for JpGraph - <?php echo $target; ?></title>
<script type="text/javascript" language="javascript">
<!--
function resize()
{
	return true;
}
//-->
</script>
</head>

	<?php
if (!strstr($target, 'csim')) {
    echo '<frameset rows="*,*" onLoad="resize()">';
    echo '<frame src="show-image.php?' . 'folder=' . ($folder) . '&target=' . ($target) . '" name="image">';
    echo '<frame src="show-source.php?folder=' . ($folder) . '&target=' . ($target) . '" name="source">';
} else {
    echo '<frameset rows="*" onLoad="resize()">';
    echo '<frame src="' . ($folder) . '/' . ($target) . '" name="image">';
}
?>


</frameset>
</html>
