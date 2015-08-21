<?php
  function checkLengthBlock($private_key = array(), $block_limit) {

    $length_private_key = count($private_key);
    if ($length_private_key <= $block_limit) {
      echo "Bernard voit que la longueur de la clé publique est égale au bloc, il décida donc de tout recommencer\n";
      return false;
    }
    else if ($length_private_key <= 5) {
      echo "la clé publique est trop petite pour trouver un bon compromis\n";
      return false;
    }
    else if($block_limit <= 5) {
      echo "le bloc est bien trop petit pour trouver un bon compromis\n";
      return false;
    }
    return true;
  }
