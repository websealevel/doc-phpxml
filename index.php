<?php


$xml = simplexml_load_file('data.xml');

//Ca marche pas
// var_dump($xml['plugins']);

var_dump($xml);

var_dump($xml->children('theme_official_plugins'));
