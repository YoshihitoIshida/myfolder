<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>9-1</title>
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
  //POSTされた性別を取り出す
if (isSet($_POST['sex'])) {
  $sexValues = ["男性","女性"];
  $isSex = in_array($_POST['sex'],$sexValue);
  if ($isSex) {  //true
    $sex = $_POST['sex'];  //ラジオボタンで選択された性別の値を取り出す
  }else{  //false
    $sex = "error";
    $error[] = "「性別」に入力エラーがありました。";
  }
}else{  //POSTされた値がないとき pageが初めて開いたということ
  $isSex = false;
  $sex = "男性";  //pageを最初に開いたときの状態
}
  //POSTされた結婚を取り出す
if (isSet($_POST['marriage'])) {
  $marriageValue = ["独身","既婚","同棲中"];
  $isMarriage = in_array($_POST['marriage'],$marriageValue);
  if ($isMarriage) {
    $marriage = $_POST['marriage'];
  }else {
    $marriage = "error";
    $error[] = "「結婚」に入力エラーがありました。";
  }
} else {
  $isMarriage = false;
  $marriage = "独身";
}
?>

<?php
  //ここでは$questionが配列になることはない
  //チェックボックスでも使えるようにするため配列対応している
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
    <li><span>性別：</span>
      <label><input type="radio" name="sex" value="男性"<?php checked("男性",$sex); ?>>男性</label>
      <label><input type="radio" name="sex" value="女性"<?php checked("女性",$sex); ?>>女性</label>
    </li>
    <li><span>結婚</span>
      <label><input type="radio" name="marriage" value="独身"<?php checked("独身",$marriage); ?>>独身</label>
      <label><input type="radio" name="marriage" value="既婚"<?php checked("既婚",$marriage); ?>>既婚</label>
      <label><input type="radio" name="marriage" value="同棲中"<?php checked("同棲中",$marriage); ?>>同棲中</label>
    </li>
    <li><input type="submit" value="送信する"></li>
  </ul>
</form>

<?php
$isSubmited = $isSex && $isMarriage;
if ($isSubmited) {
  echo "<HR>";
  echo "あなたは「{$sex}、{$marriage}」です。";
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
