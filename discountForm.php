<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>8-5 P298</title>
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
require_once("saledata.php");
$couponCode = "ha45as";
$goodsID = "ax102";
$discount = getCouponRate($couponCode);
$tanka = getPrice($goodsID);
if(is_null($discount)||is_null($tanka)){
  $err = '<div class="error">不正な操作がありました。</div>';
  exit($err);
}
?>
<?php
$off = (1-$discount)*100;
  if ($discount>0) {
    echo "<h2>このページでの購入は{$off}% OFFになります！</h2>";
  }
$tanka_fmt = number_format($tanka);
?>
  <!__入力フォームを作る__>
<form method="POST" action="discount.php">
  <!__隠しフィールドにクーポンコードと商品IDを設定してPOSTする__ >
  <input type="hidden" name="couponCode" value="<?php echo $couponCode; ?>">
  <input type="hidden" name="goodsID" value="<?php echo $goodsID; ?>">
  <ul>
    <li><label>単価：<?php echo $tanka_fmt; ?>円</label></li>
    <li><label>個数：<input type="number" name="kosu" value="<?php echo $kosu; ?>"></label></li>
    <li><input type="submit" value="計算する"></li>
  </ul>
</form>
</div>
</body>
</html>
