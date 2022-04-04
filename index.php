<?php

$xml_file = 'data.xml';


//Validation du docment XML avec un DTD
$dom = new DOMDocument();
$dom->load($xml_file);
if ($dom->validate()) {
    echo "Le document XML " . $xml_file . " est valide." . PHP_EOL;
}

$xml = simplexml_load_file($xml_file);

// var_dump($xml);

//Acceder au premier element du document par indice
// var_dump($xml->theme[0]->plugins);

// foreach ($xml->children() as $theme) {
//     var_dump($theme['name']);
//     echo "<br>";
// }

//Selectionne les noeuds 'theme' enfant du noeud courant
$plugins = $xml->xpath("theme_official_plugins/theme");
var_dump($plugins);

//Selectionne le noeud 'theme' dont l'attribut name vaut atelierduboisdor, enfant du noeud courant
$plugins = $xml->xpath('theme_official_plugins/theme[@name="atelierduboisdor"]');
var_dump($plugins);
