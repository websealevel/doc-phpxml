<?php


$xml = simplexml_load_file('data.xml');

var_dump($xml);

//Acceder au premier element du document par indice
// var_dump($xml->theme[0]->plugins);

// foreach ($xml->children() as $theme) {
//     var_dump($theme['name']);
//     echo "<br>";
// }

//Selectionne les noeuds 'theme' enfant du noeud courant
$plugins = $xml->xpath("theme");
var_dump($plugins);
