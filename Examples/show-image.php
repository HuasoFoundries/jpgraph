<?php
$target = basename(urldecode($_GET['target']));

$folder = null;
if (isset($_GET['folder'])) {
    $folder = basename(urldecode($_GET['folder']));
}
/*echo $folder;
echo '<br>';
echo $target;
die();*/

?>
<!doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title> Image <?php echo ($target); ?></title>
</head>
<body>
<img src="<?php echo ($folder ? $folder . '/' : '') . ($target); ?>" border=0 alt="<?php echo ($target); ?>" align="left">
</body>
</html>
