<?php

  include_once __DIR__."/../bootstrap/crypt.php";
  include_once __DIR__."/../modules/super_croissante_check.php";

  // avoir la clé publique
  function getPublicKey($tab = array(), $mod, $e) {
    $length_tab      = count($tab);
    $public_key      = array();
    $key_inv_mod     = inv_mod($e, $mod);
    $password_permut = null;

    if (super_croissance_check($tab)) {
      for ( $i = 0; $i < $length_tab; $i++) {
        $current_operation = ($tab[$i] * $e);
        $modulo_operation  = my_modulo($current_operation, $mod);
        array_push($public_key, $modulo_operation);
      }
      // ordonée sans changer la valeur de la clé
      natsort($public_key);

      // on fait un foreach pour trouver les valeurs de la clé
      foreach($public_key as $key => $value)
      {
        $password_permut .= $key;
      }
      echo "Alice garde precieusement le mot de passe : ", $password_permut, "\n";

      // on sort en modifiant les valeurs de l'index
      sort($public_key);
      echo "Alice envoie une clé publique à Bernard : [ ";
      foreach ($public_key as $values_in_key) {
        echo $values_in_key, " ";
      }
      echo "]\n";
      return [$public_key, $password_permut];
    }
  }
