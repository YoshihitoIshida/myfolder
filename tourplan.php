<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>9-2</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div>
<?php
require_once("./libutil.php");
  //文字エンコード検証
if (!cken($_POST)) {
  $encoding = mb_internal_encouding();
  $err = "Encoding Error! The expected encoding is".$encoding;
  exit($err);
}
  //HTMLエスケープ(xss対策)
$_POST = es($_POST);
?>

<?php
$error = [];
if (isSet($_POST['meal'])) {
  $meals = ["朝食","夕食"];
  $diffValue = array_diff($_POST['meal'],$meals);
  if (count($diffValue)==0) {
    $mealChecked = $_POST['meal'];
  }else{  //false
    $mealChecked = [];
    $error[] = "「食事」に入力エラーがありました。";
  }
}else{  //POSTされた値がないとき pageが初めて開いたということ
  $mealChecked = [];
}
  //POSTされたtourを取り出す
if (isSet($_POST['tour'])) {
  $tours = ["カヌー","MTB","トレラン"];
  $diffValue = array_diff($_POST['tour'],$tours);
  if (count($diffValue)==0) {
    $tourChecked = $_POST['tour'];
  }else {
    $tourChecked = [];
    $error[] = "「ツアー」に入力エラーがありました。";
  }
} else {
  $tourChecked = [];
}
?>

<?php
function checked($value,$question){
  if (is_array($question)) {
      //配列のとき値が含まれていればtrue
    $isChecked = in_array($value,$question);
  }else {
      //配列でないとき値が一致すればtrue
    $isChecked = ($value===$question);
  }
  if ($isChecked) {
    print "checked";
  }else {
    print "";
  }
}
?>

<!--入力フォームを作る（現在のpageにPOSTする)-->
<form method="post" action="<?php echo es($_SERVER['PHP_SELF']); ?>" >
  <ul>
    <li><span>食事：</span>
      <label><input type="checkbox" name="meal[]" value="朝食"<?php checked("朝食",$mealChecked); ?>>朝食</label>
      <label><input type="checkbox" name="meal[]" value="夕食"<?php checked("夕食",$mealChecked); ?>>夕食</label>
    </li>
    <li><span>ツアー</span>
      <label><input type="checkbox" name="tour[]" value="カヌー"<?php checked("カヌー",$tourChecked); ?>>カヌー</label>
      <label><input type="checkbox" name="tour[]" value="MTB"<?php checked("MTB",$tourChecked); ?>>MTB</label>
      <label><input type="checkbox" name="tour[]" value="トレラン"<?php checked("トレラン",$tourChecked); ?>>トレラン</label>
    </li>
    <li><input type="submit" value="送信する"></li>
  </ul>
</form>

<?php
$isSelected = count($mealChecked)>0 || count($tourChecked)>0;
if ($isSelected) {
  echo "<HR>";
  echo "お食事：",implode("と",$mealChecked),"<br>";
  echo "ツアー：",implode("と",$tourChecked),"<br>";
}else {
  echo "<HR>";
  echo "選択されているものはありません。";
}
?>
<?php
if (count($error)>0) {
  echo "<HR>";
  echo '<span class="error">',implode("<br>",$error),'</span>';
}
?>
</div>

</div>
</body>
</html>
