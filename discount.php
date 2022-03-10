!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>section8-5_P301</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div>
<?php
   //文字エンコードの検証
require_once("libutil.php");
if (!cken($_POST)) {
  $encoding = mb_internal_encoding();
  $err = "Encoding Error! The expected encoding is".$encoding;
  exit($err);
}
$_POST = es($_POST);  //HTMLエスケープ（XSS）
?>

<?php
$errors = [];
  //クーポンコード
if (isset($_POST['couponCode'])) {
  $couponCode = $_POST['couponCode'];
}else {
  $couponCode = "";  //未設定エラー
}
if (isset($_POST['goodsID'])) {
  $goodsID = $_POST['goodsID'];
}else {
  $goodsID = "";  //未設定エラー
}
?>

<?php
require_once("saledata.php");
$discount = getCouponRate($couponCode);
$tanka = getPrice($goodsID);
   //割引率と単価に値があるかチェックする
 if (is_null($discount)||is_null($tanka)) {
  $err = '<div cladd="error">不正な操作がありました。</div>';
  exit($err);
 }
?>

<?php
if (isset($_POST['kosu'])) {
  $kosu = $_POST['kosu'];
  if (!ctype_digit($kosu)) {
    $errors[] = "個数は正の整数で入力してください。";
  }
}else {
  $errors[] = "個数が未設定";
}
?>

<?php
if (count($errors)>0) {
  echo '<ol class="error">';
  foreach($errors as $value){
    echo "<li>,$value,</li>";
  }
  echo "</li>";
}else {
  $price = $tanka * $kosu;
  $discount_price = floor($price * $discount);
  $off_price = $price - $discount_price;
  $off_per = (1 - $discount) * 100;

  $tanka_fmt = number_format($tanka);
  $discount_price_fmt = number_format($discount_price);
  $off_price_fmt = number_format($off_price);

  echo "単価：{$tanka_fmt}円、","個数：{$kosu}個","<br>";
  echo "金額：{$discount_price_fmt}円","<br>";
  echo "(割引：-{$off_price_fmt}円、{$off_per}% OFF)","<br>";
}
?>

  <!__戻りボタンのフォーム__>
<form method="post" action="discountForm.php">
  <input type="hidden" name="kosu" value="<?php echo $kosu; ?>">
  <ul>
    <li><input type="submit" value="戻る"></li>
  </ul>
</form>

</div>
</body>
</html>
