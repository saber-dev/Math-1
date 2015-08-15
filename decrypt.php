<?php
  include_once __DIR__."/modules/super_croissante_check.php";
  include_once __DIR__."/modules/inv_mod_build.php";

  // decoder le message
  function decryptMess($mess = array(), $mod, $d) {
    $new_array = array();
    foreach ($mess as $values_in_mess) {
      $tmp_result = ($values_in_mess * $d);
      array_push($new_array, my_modulo($tmp_result, $mod));
    }
    return $new_array;
  }

  //fonction permettant de transformer le message codé en binaire
  function decryptMessToBin($key = array(), $mess = array()) {
    $key_count     = count_tab($key);
    $mess_count    = count_tab($mess);
    $array_binarie = array();
    $result        = null;
    $bin_result    = null;
    $tmp_array     = array();

    // prendre les valeur dans le tableau
    //boucle for en premier temps
    for ($i = 0; $i < $mess_count; $i++) {
      $tmp_value = $mess[$i];
      while ($tmp_value > 0) {
        for ($j = ($key_count -1); $j >= 0; $j--) {
          if ($tmp_value >= $key[$j]) {
            $tmp_value -= $key[$j];
            $result    += $key[$j];
            // on push le resultat dans un tableau temporaire
            array_push($tmp_array, $key[$j]);
          }
        }
        var_dump($tmp_array);
        $tmp_array = array();
      }
    }
  }

  // decoder la clé publique
  function decryptKey($tab = array(), $d, $mod) {
    $tmp_array = array();
    $array_new = array();
    // parcours du tableau
    foreach($tab as $message ) {
      //calcul du resultat
      $tmp_result = ($message * $d);
      // ajout dans le tableau accompagné de son modulo
      array_push($tmp_array, my_modulo($tmp_result, $mod));
    }
    // on tri le tableau pour former une suite superCroissante
    natsort($tmp_array);
    foreach ($tmp_array as $values_in_array) {
      array_push($array_new, $values_in_array);
    }
    return $array_new;
  }

  // fonction maitresse
  function decryptCodeToBin($tab = array(),$d, $mod, $mess = array()) {
    $key_array     = array();
    $message_array = array();
    $key_array     = decryptKey($tab, $d, $mod);
    if (super_croissance_check($key_array)) {
      $message_array = decryptMess($mess, $mod, $d);
      decryptMessToBin($key_array, $message_array);
      // var_dump($message_array);
    }
  }

  //clé publique
  $tabTmp = [43, 143, 256, 429, 515, 613, 695, 715, 859];
  //message codé
  $tabmess = [1085, 515, 1185, 1128];
  // fonction de decodage
  decryptCodeToBin($tabTmp, 47, 960, $tabmess);
