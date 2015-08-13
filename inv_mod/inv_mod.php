<?php
function check_numeric($int , $n)
{
  if (strpos($int, ",") == true || strpos($int, ".") == true || strpos($n, ",") == true || (strpos($n, ".") == true)) {
    return false;
  }
  else
  {
    return true;
  }
}
function my_modulo($int, $n)
{
  if ($int > 0 && is_int($int) && is_int($n) && $n > 0 && !is_float($int) && !is_float($n) || check_numeric($int, $n) == true )
  {
    $partie_entiere = intval($int / $n);
    $mod = $partie_entiere * $n;
    $modulo = $int - $mod;
    return $modulo;
  }
  else if ($int < 0 && is_int($int) && is_int($n) && $n > 0 && !is_float($int) && !is_float($n) || check_numeric($int, $n) == true)
  {
    $partie_entiere = intval($int / $n);
    $mod = $partie_entiere * $n;
    $modulo = $int - $mod;
    return $modulo;
  }
  else {
    echo "va t'acheter des doigts !\n";
    return 0;
  }
}

function inv_mod($a, $n){
  $a_init = $a;
  $n_init = $n;
  $res = my_modulo($n, $a);
  if ($res == 1){
    for ($i = 1;is_int($test2) != true;$i++){
      $test = $n * $i + 1;
      $test2 = $test / $a;

    }
    // return $test2;
    echo $test2;
  }

  else if ($res == 0){
    return 0;
  }
  else {
    while ($res != 1 && $res != 0){

      $n = $a;
      $a = $res;
      $res = my_modulo($n, $a);
    }
    if ($res == 0){
      echo "va t'acheter des doigts !\n";
      return 0;
    }
    else if ($res == 1){
      for ($i = 1; is_int($test2) != true;$i++){
        $test = $n_init * $i + 1;
        $test2 = $test / $a_init;
      }
      echo $test2;
      // return $test2;
    }
  }

}
//Exemple avec de grands nombres
inv_mod(197, 3000);
//Exemple qui fonctionne avec 0 iterations
// inv_mod(13, 27);
//Exemple avec 1 iteration
// inv_mod(8, 27);
//Exemple qui n'a pas de pgcd
// inv_mod(12, 27);
