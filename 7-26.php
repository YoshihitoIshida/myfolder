<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>7-26メニューのデフォルト値の設定</title>
</head>
<body>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $defaults = $_POST;
}else{
  $defaults = array('delivery' => 'yes','size' => 'medium','main_dish' => array('taro','tripe'),'sweet' => 'cake');
}

$sweets = array('puff'=>'Sesame Seed Puff','square'=>'Coconut Milk Gelatin Square','cake'=>'Brown Suger Cake','ricemeat'=>'Sweet Rice and Meat');

print '<select name="sweet">';
foreach ($sweets as $option => $label) {
  print '<opton value="' .$option .'"';
  if ($option == $defaults['sweet']) {
    print 'selected';
  }
  print ">$label</option>\n";
}
print '</select>';
?>
</body>
</html>
