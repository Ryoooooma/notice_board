<?php

$dataFile = 'bbs.dat';

if ($_SERVER['REQUEST_METHOD'] == 'POST' &&
	isset($_POST['message']) &&
	isset($_POST['user'])) {

	$message = trim($_POST['message']);
	$user = trim($_POST['user']);


	if ($message !== '') {

		$user = ($user === '') ? '名前が記入されていません' : $user;

		// 
		$message = str_replace("\t", ' ', $message);
		$user = str_replace("\t", ' ', $user);

		$postedAt = date('Y-m-d H:i:s');

		// 挿入されるデータの内容を記載している
		// $messageを入れてTABで区切って、$userが来て、改行としている
		$newData = $message  . "\t" . $user . "\t" . $postedAt . "\n";

		// aというモードで開いている
		$fp = fopen($dataFile, 'a');
		fwrite($fp, $newData);
		fclose($fp);
	}
}

?>

<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title>簡易掲示板</title>
	</head>
	<body>
		<h1>簡易掲示板</h1>
		<form action="" method="post">
			Message: <input type="text" name="message">
			User: <input type="text" name="user">
			<input type="submit" value="投稿">

		</form>
		<h2>投稿一覧（0件）</h2>
		<ul>
			<li>まだ投稿はありません。</li>
		</ul>
	</body>
</html>