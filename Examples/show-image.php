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
<!doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title> Image <?php echo $target; ?></title>
</head>
<body>
<img src="<?php echo($folder ? $folder . '/' : '') . ($target); ?>" border=0 alt="<?php echo $target; ?>" align="left">
</body>
</html>
