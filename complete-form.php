<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>7-31フォームを生成する</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<form method="post" action="<?= $form->encode($_SERVER['PHP_SELF'])?>" >
<table>
  <?php if($errors){ ?>
    <tr>
      <td>You need to correct the following errors:</td>
      <td><ul>
        <?php foreach($errors as $error){ ?>
          <li><?= $form->encode($error) ?></li>
        <?php }?>
      </ul></td>
  <?php } ?>

  <tr><td>Your Name:</td><td><?= $form->input('text',['name'=>'name']) ?>
  </td></tr>

  <tr><td>Size:</td>
    <td><?= $form->input('radio',['name'=>'size','value'=>'small']) ?>Small<br/>
      <?= $form->input('radio',['name'=>'size','value'=>'medium']) ?>Medium<br/>
      <?= $form->input('radio',['name'=>'size','value'=>'large']) ?>Large<br/>
    </td></tr>

  <tr><td>Pick on sweet item:</td>
    <td><?= $form->select($GLOBALS['sweets'],['name'=>'sweet']) ?></td></tr>

  <tr><td>Pick two main dishes:</td>
    <td><?= $form->select($GLOBALS['main_dishes'],['name'=>'main_dish','multiple'=>true]) ?></td>
  </tr>

  <tr><td>Do you want your order deliverd?</td>
    <td><?= $form->input('checkbox',['name'=>'delivery','value'=>'yes']) ?>Yes</td>
  </tr>

  <tr><td>Enter any special instructions.<br/>
    if you want your order deliverd,put your address here:</td>
    <td><?= $form->textarea(['name'=>'comments']) ?></td>
  </tr>

  <tr><td colspan="2" align="center">
  <?= $form->input('submit',['value'=>'order']) ?></td>
  </tr>
</table>
</form>
</body>
</html>
