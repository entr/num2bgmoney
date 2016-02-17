<?php
/* Demostration */
$lib = '../num2bgmoney.php';
require($lib);

	if (isset($_SERVER["PATH_INFO"]) && $_SERVER["PATH_INFO"] == "/view/" ) {
		show_source($lib);
		exit;
	}
	if (isset($_SERVER["PATH_INFO"]) && $_SERVER["PATH_INFO"] == "/get/" ) {
		header("Content-Type: text/plain; charset=UTF-8");
		header("Content-Disposition: attachment; filename=num2bgmoney.php.txt");
		readfile($lib);
		exit;
	}

	header("Content-type: text/html; charset=UTF-8");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
					  "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>
<head>
	<title>Конверсия на числа в текстов вид</title>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<meta name="author" content="Georgi Chorbadzhiyski">
	<style type="text/css">
	<!--
		body    { background:#f5f5f5; font:11pt Verdana,Arial,Helvetica,sans-serif; }
		a       { color: #2020E0;      text-decoration: underline; padding:3px; border:1px solid #f5f5f5;}
		a:hover { background: #cdcdff; text-decoration: underline; border:1px solid blue; }
		form { margin:0px; }
	-->
	</style>
</head>

<body>
<h2><a href="http://georgi.unixsol.org/programs/num2bgmoney.php">Коверсия число -> текст</a></h2>

<?php
	$num = (float)preg_replace("/[^0-9\.]/","",@$_GET["num"]);

	if (!$num)
		$num = 0.001;

	if ($num) {
		print "Сума: <b>".number_format($num,2,".",",") . " лв.</b><br>";
		print "Текст: <b>".number2lv($num)."</b><br><br>";
	}

	$num = number_format($num,2,".","");
?>
<form action="<?=$_SERVER['PHP_SELF']?>" method="GET">
Въведете сумата: <input type="text" size="10" maxlength="10" name="num" value="<?=$num?>"><input type="submit" value="Покажи като текст">
</form>

<p><a href="<?=$_SERVER['PHP_SELF']?>/view/">Вижте изходният код на програмата</a>
<a href="<?=$_SERVER['PHP_SELF']?>/get/">Свалете си изходният код на програмата</a></p>

<p>Автор: <a href="http://georgi.unixsol.org/">Георги Чорбаджийски</a></p>

</body>
</html>