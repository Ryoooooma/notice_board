<?php

$dataFile = 'bbs.dat';

// エスケープする際は命令が長いので独自関数を作るのが定石
function h($s) {
	return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

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

// fileで中身を取り出して配列にしてくれる。オプションで最後の改行記号を取り去ってくれる
$posts = file($dataFile, FILE_IGNORE_NEW_LINES);

// 配列の中身を逆順で表示させる命令
$posts = array_reverse($posts);


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
		<h2>投稿一覧（<?php echo count($posts);?>件) </h2>
		<ul>
			<?php if (count($posts)) : ?>
				<?php foreach ($posts as $post) : ?>
				<?php list($message, $user, $postedAt) = explode("\t", $post); ?>
					<li><?php echo h($message); ?> (<?php echo h($user); ?>) - <?php echo h($postedAt); ?></li>
				<?php endforeach ; ?>
			<?php else : ?>
			<li>まだ投稿はありません。</li>
			<?php endif; ?>
		</ul>
	</body>
</html>