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
    echo "name= " . $result->getAttribute('name') . PHP_EOL;
}

//Parcourir les résultats de manière plus efficace. Par contre item renvoie un DOMNode et non un DOMElement. Mais ça passe quand même avec le polymorphisme
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
foreach ($list as $element) {

    $plugins = $element->childNodes;
    foreach($plugins as $plugin){

        //Chaque élément de plugin est une donnée de plugin
        foreach($plugin->childNodes as $parameter){
            echo $parameter->nodeName . ' : ' . $parameter->nodeValue . PHP_EOL;
        }
    }
}


echo "Selectionne le noeud 'theme' dont l'attribut name vaut atelierduboisdor, enfant du noeud courant" . PHP_EOL;

//Selectionne le noeud 'theme' dont l'attribut name vaut atelierduboisdor, enfant du noeud courant
$plugins_list = $xpath->query('//ns:theme_official_plugins/ns:theme[@name="atelierduboisdor"]/ns:plugin');
foreach($plugins_list as $plugin){
    echo $plugin->getElementsByTagName('name')->item(0)->nodeValue . PHP_EOL;
    echo $plugin->getElementsByTagName('description')->item(0)->nodeValue . PHP_EOL;
}