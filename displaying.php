<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>7-30デフォルト・検証・処理を伴う表示</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<?php
require 'FormHelper.php';
  //selectメニューに選択肢の配列を用意する
  //これらはdisplay_form() validate_form() process_form()で必要なのでグローバルスコープで宣言
$sweets = array('puff'=>'Sesame Seed Puff','square'=>'Coconut Milk Gelatin Square','cake'=>'Brown Suger Cake','ricemeat'=>'Sweet Rice and Meat');

$main_dishes = array('cuke' => 'Braisd Sea Cucumber','stomach' => 'Sauteed Trip with Wine Sauce','taro' => 'Stewed Pork with Wine Sauce','giblets' => 'Baked Giblets with Salt','abalone' => 'Abalone with Marrow and Duck Feet');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  list($errors,$input)=validate_form();
  if ($errors) {
    show_form($errors);
  }else {
    process_form($input);  //submitされたdateが有効なら処理する
  }
}else {
  show_form();  //formがsubmitされなかったので表示する
}

function show_form($errors = array()){
  $defaults = array('delivery' => 'yes','size' => 'medium');
    //適切なデフォルトで$formｗ用意する
  $form = new FormHelper($defaults);
    //すべてのHTMLとform表示をわかりやすくするため個別ファイルに入れる
  include 'complete-form.php';
}

function validate_form(){
  $input = array();
  $errors = array();

  $input['name'] = trim($_POST['name']?? '');
  if (!strlen($input['name'])) {
    $errors[] = 'Please enter your name.';
  }

  $input['size'] = $_POST['size']?? '';
  if (! in_array($input['size'],['small','medium','large'])){
    $errors[] = 'Please select a size.';
  }

  $input['sweet'] = $_POST['sweet']?? '';
  if (! array_key_exists($input['sweet'],$GLOBALS['sweets'])) {
    $errors[] = 'Please select a valid sweet item.';
  }
    //2つのメインディッシュが必要
  $input['main_dish'] = $_POST['main_dish']?? array();
  if (count($input['main_dish']) !=2) {
    $errors[] = 'Please select exactly two main dishes.';
  }else {
    if(!(array_key_exists($input['main_dish'][0],$GLOBALS['main_dish']) && array_key_exists(input['main_dish'][1],$GLOBALS['main_dish']))) {
      $errors[] = 'Please select exactly two valid main dishs.';
    }
  }
  $input['delivery'] = $_POST['delivery']?? 'no';
  $input['comments'] = trim($_POST['comments']?? '');
  if (($input['delivery'] == 'yes') && (! strlen($input['comments']))) {
    $errors[] = 'Please enter your address for delivery.';
  }
  return array($errors,$input);
}

function process_form($input){
  $sweet = $GLOBALS['sweets'][$input['sweet']];
  $main_dish_1 = $GLOBALS['main_dish'][$input['main_dish'][0]];
  $main_dish_2 = $GLOBALS['main_dish'][$input['main_dish'][1]];
  if (isset($input['delivery']) && ($input['delivery'] == 'yes')) {
    $delivery = 'do';
  }else {
    $delivery = 'do not';
  }

  //注文メッセージのテキストを作成する
  $message=<<<_ORDER_
Thank you for your order,{$input['name']}.You requested the {$input['size']}size of $sweet,$main_dish_1,and $main_dish_2.You $delivery want delivery.
_ORDER_;
  if (strlen(trim($input['comments']))) {
    $message .='You comments: '.$input['comments'];
  }
    //messageをシェフに送る
  mail('chef@restaurant.example.com','New Order',$message);
  print nl2br(htmlentities($message,ENT_HTML5));
}
?>
</body>
</html>
