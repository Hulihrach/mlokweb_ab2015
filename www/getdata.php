<?php

if (!$_GET['type']) {
	header('Location: /ajax/ajax.php');
}

$type = $_GET['type'];
$pdo = new PDO('mysql:host=localhost;dbname=mlok', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));

if ($type === "getnum") {
	$sql2 = "SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'mlok' AND TABLE_NAME = 'article';";
	$query2 = $pdo->prepare($sql2);
	$query2->execute();
	$res2 = $query2->fetch(PDO::FETCH_NUM);
	echo $res2['0'];
}

if (($type === "next") || ($type === "prev")) {
	$id = $_GET['data'];
	$max = $id + 5;
	$sql = "SELECT * FROM `article` WHERE `id` BETWEEN :idmin AND :idmax ORDER BY `created_at` DESC LIMIT 5";
	$query = $pdo->prepare($sql);
	$query->execute(array(':idmin' => $id, ':idmax' => $max));
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	foreach ($res as $r) {
		echo "<div class='article'>
			#".$r['id']."&emsp;<h2><a href='/front/article/detail/".$r['id']."'>".$r['title']."</a></h2>".
			 "<p>".$r['content'] . "</p>" .
			 "<small>Napsal: " . $r['account_id'] . "&emsp;" . $r['created_at'] . "</small>
			 </div>";
	}
}
