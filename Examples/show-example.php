<?php
$target = urldecode($_GET['target']);
$folder = null;
if (isset($_GET['folder'])) {
    $folder = urldecode($_GET['folder']);
}
/*echo basename($folder);
echo '<br>';
echo basename($target);*/

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
    echo '<frame src="show-image.php?' . 'folder=' . basename($folder) . '&target=' . basename($target) . '" name="image">';
    echo '<frame src="show-source.php?folder=' . basename($folder) . '&target=' . basename($target) . '" name="source">';
} else {
    echo '<frameset rows="*" onLoad="resize()">';
    echo '<frame src="' . basename($folder) . '/' . basename($target) . '" name="image">';

}
?>


</frameset>
</html>
