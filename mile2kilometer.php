<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>8-6</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div>
<?php
require_once("./libutil.php");
if (!cken($_POST)) {
  $encoding = mb_internal_encoding();
  $err = "Encoding Error! The expected encoding is".$encoding;
  exit($err);
}
$_POST = es($_POST);
?>
<?php
if (isSet($_POST['mile'])) {  //isNumにtrue,falseが入る
    //true POSTで値が送られてきた
  $isNum = is_numeric($_POST['mile']);
  if ($isNum) {
    $mile = $_POST['mile'];
    $error = "";
  }else {
    $mile = "";
    $error = '<span class="error">←数値を入力してください</span>';
  }
}else {  //false POSTされた値がない
  $isNum = false;
  $mile = "";
  $error = "";
}
?>

<!--入力フォームを作る（現在のページにPOSTする）-->
<form method="post" action="<?php echo es($_SERVER['PHP_SELF']); ?>">
  <ul>
    <li><label>マイルをkmに換算：
      <input type="text" name="mile" value="<?php echo $mile; ?>">
    </label>
    <!--エラー表示-->
    <?php echo $error; ?>
  </li>
  <li><input type="submit" value="計算する"></li>
  </ul>
</form>

<?php    //$mileが数値ならば計算結果を表示する
if ($isNum) {
  echo "<HR>";
  $kilometer = $mile*1.609344;
  echo "{$mile}マイルは{$kilometer}kmです。";
}
?>
</div>
</body>
</html>
