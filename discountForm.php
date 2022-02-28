<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>8-4</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div>
<?php
require_once("libutil.php");
  //文字エンコードの検証
if (!cken($_POST)) {
  $encoding = mb_internal_encoding();
  $err = "Encoding Error! The expected encoding is".$encoding;
  exit($err);
}
$_POST = es($_POST); //HTMLエスケープ（xss）
?>

<?php
if (isset($_POST['kosu'])) {
  $kosu = $_POST['kosu'];
}else {
  $kosu = "";
}
?>

<?php
$discount = 0.8;
$off = (1-$discount)*100;
  if ($discount>0) {
    echo "<h2>このページでの購入は{$off}% OFFになります！</h2>";
  }
$tanka = 2900;
$tanka_fmt = number_format($tanka);
?>
  <!__入力フォームを作る__>
<form method="POST" action="discount.php">
  <input type="hidden" name="discount" value="<?php echo $discount; ?>">
  <input type="hidden" name="tanka" value="<?php echo $tanka; ?>">
  <ul>
    <li><label>単価：<?php echo $tanka_fmt; ?>円</label></li>
    <li><label>個数：<input type="number" name="kosu" value="<?php echo $kosu; ?>"></label></li>
    <li><input type="submit" value="計算する"></li>
  </ul>
</form>
</div>
</body>
</html>
