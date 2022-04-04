# doc-phpxml

Documentation et exemples sur la manipulation de XML en php


## XML

Le document XML a une racine, c'est un graphe, comme un document HTML. Dans `data.xml`, notre fichier de données d'exemple, la root du document est `theme_official_plugins`.

# Valider le XML avec un DTD

Le [DTD](https://www.xml.com/pub/a/norm/part1/getstart1.html#xmlinidtd) est un fichier de documentation pour les données xml. Il peut etre interne au fichier XML mais généralement on le met dans un fichier externe. On le référence depuis le fichier XML qu'il décrit en introduisant cette balise dans le fichier XML

~~~xml
<!DOCTYPE root_element SYSTEM "{fichier.dtd}">
~~~

~~~php
$xml_file = 'data.xml';
$dom = new DOMDocument();
$dom->load($xml_file);
if ($dom->validate()) {
    echo "Le document XML " . $xml_file . " est valide." . PHP_EOL;
}
~~~

## XPath query

Xpath execute des requetes sur un document XML. Les fonctions built-in de Xpath cherche dans la node SimpleXML une node enfant qui match l'expression XPath.

Exemple avec la node root qui dispose d'un attribut namespace `xmlns`, généralement une URI pour assurer l'unicité.

~~~xml
<root xmlns="mon-namespace">
    <foo></foo>
</root>
~~~

~~~php
$dom = new DOMDocument();
$dom->load($xml_file);
$xpath = new DOMXpath($dom);
$xpath->registerNamespace('ns', 'mon-namespace')
$results = $xpath->evaluate('//ns:root/ns:foo');
~~~

Le résultat renvoyé par `$xpath->query()` est une [DOMNodeList](), chaque item de la liste est un [DOMNode](https://www.php.net/manual/en/class.domnode.php). [DOMElement](https://www.php.net/manual/en/class.domelement.php) hérite de DOMNode. Comme on utilise DOMXPath il nous renvoie une DOMNodeList de DOMElement, on peut donc utiliser les méthodes de DOMElement qui sont très completes pour parser les résultats de la requête.

Parcourir la liste avec les itérateurs, plus efficace,

~~~php
$node = $results->item(0);
if (!isset($node))
    return;
do {
    echo "name= " . $node->getAttribute('name') . PHP_EOL;
} while ($node = $node->nextSibling);
~~~

ou sinon

~~~php
foreach ($results as $result) {
    echo "name= " . $result->getAttribute('name') . PHP_EOL;
}
~~~

Exemple de requête

~~~php
$plugins_list = $xpath->query('//ns:theme_official_plugins/ns:theme[@name="atelierduboisdor"]/ns:plugin');
foreach($plugins_list as $plugin){
    echo $plugin->getElementsByTagName('name')->item(0)->nodeValue . PHP_EOL;
    echo $plugin->getElementsByTagName('description')->item(0)->nodeValue . PHP_EOL;
}
~~~

## Ressources

- [Site officiel XML](https://www.xml.com/)
- [PHP SimpleXML - Get Node/Attribute Values](https://www.w3schools.com/php/php_xml_simplexml_get.asp)
- [SimpleXMLElement::xpath](https://www.php.net/manual/en/simplexmlelement.xpath.php)
- [XPath tutorial](https://www.w3schools.com/xml/xpath_intro.asp)
- [PHP xpath() Function](https://www.w3schools.com/php/func_simplexml_xpath.asp)
- [Ultimate XPath Writing Cheat Sheet Tutorial with Syntax and Examples](https://www.softwaretestinghelp.com/xpath-writing-cheat-sheet-tutorial-examples/)