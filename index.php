<?php

$xml_file = 'data.xml';


//Validation du docment XML avec un DTD

//On cree une abstraction du DOM
$dom = new DOMDocument();

//On valide le XML avec le DTD
$dom->load($xml_file);
if ($dom->validate()) {
    echo "Le document XML " . $xml_file . " est valide." . PHP_EOL;
}
//On cree une abstraction de XPath a partir du dom
$xpath = new DOMXpath($dom);

//On enregistre un namespace pour ne pas avoir à le taper à chaque query
$xpath->registerNamespace('ns', 'https://websealevel.com/wordpress/plugins/wsl_theme_dependencies'); 

//Query

//Selectionne le noeud 'theme' dont l'attribut name vaut atelierduboisdor, enfant du noeud courant
$themes = $xpath->query('//ns:theme_official_plugins/ns:theme');

//Exploite les résultats

foreach($themes as $theme){
    var_dump($theme);
}
