<?php
  include_once __DIR__."/bootstrap/crypt.php";
  include_once __DIR__."/bootstrap/decrypt.php";

  // //clé publique
  $tabTmp = [43, 143, 256, 429, 515, 613, 695, 715, 859];
  //
  $tabmess = [ 987, 0];
  // //message codé ceci devrait afficher, Mahefa andrianifahanana
  // $tabmess = [ 1012, 1639, 1341, 399, 1228, 987, 838, 613, 1128, 1825, 1380, 1137, 701, 912, 838, 2136, 1384,  1682,  1380,  914,  881,  299,  1895,  1351,  1570,  944,  613
  // ];
  //
  // // fonction de decoder le message
  decrypt($tabTmp, 47, 960, $tabmess);

  // la clé privée
  $private_key = [1, 3, 5, 11, 25, 53, 101, 205, 512];

  // fonction principale qui permet de coder le message
  cryptMessage($private_key, 960, 143, "2");
