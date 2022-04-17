<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>multiple</title>
</head>
<body>
<?php
namespace Meals;

class Ingredient{
  protected $name;
  protected $cost;

  public function __construct(name,cost){
    $this->name = $name;
    $this->cost = $cost;
  }
  public function getName(){
    return $this->name;
  }
  public function getCost(){
    return $this->cost;
  }
  public function setCost($cost){
    $this->cost = $cost;
  }
}
?>

<?php
class PricedEntree extends Entree{
  public function __construct($name,$ingredients){
    parent::__construct($name,$ingredients);
    foreach ($this->ingredients as $ingredient) {
      if (!$ingredient instanceof \Meals\Ingredient) {
        throw new Exception('Elements of $ingredients must be Ingredient object');

      }
    }
  }
  public function getCost(){
    $cost = 0;
    foreach ($this->ingredients as $ingredient) {
      $cost += $ingredient->getCost();
    }
    return $cost;
  }
}
?>
</body>
</html>
