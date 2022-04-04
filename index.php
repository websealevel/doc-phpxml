<?php

$xml_file = 'data.xml';

//Validation du document XML avec un DTD

//On cree une abstraction du DOM
$dom = new DOMDocument();

//Remove redundant white spaces
$dom->preserveWhiteSpace = false;

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

//Selectionne tous les noeuds 'theme'
$results = $xpath->query('//ns:theme_official_plugins/ns:theme');

//Nombre de résultats
echo "Nombre de résultats matchant la requête : " . $results->count() . PHP_EOL;

//Parcourir les résultats 
foreach ($results as $result) {
    //$result est un DOMElement (suremement DOMXpath qui capte ça)
    var_dump($result);
    echo "name= " . $result->getAttribute('name') . PHP_EOL;
}

//Parcourir les résultats de manière plus efficace
$node = $results->item(0);
if (!isset($node))
    return;
do {
    echo "name= " . $node->getAttribute('name') . PHP_EOL;
} while ($node = $node->nextSibling);

//Selectionne le noeud 'theme' dont l'attribut name vaut atelierduboisdor, enfant du noeud courant
$list = $xpath->query('//ns:theme_official_plugins/ns:theme[@name="atelierduboisdor"]');

if (empty($list))
    return;
//Nombre de résultats
echo "Nombre de résultats matchant la requête : " . $list->count() . PHP_EOL;

// //Parcourir les résultats 
foreach ($list as $item) {

    $plugins = $item->childNodes;
    foreach($plugins as $plugin){

        //Chaque élément de plugin est une donnée de plugin
        foreach($plugin->childNodes as $parameter){
            echo $parameter->nodeName . ' : ' . $parameter->nodeValue . PHP_EOL;
        }
    }
}
