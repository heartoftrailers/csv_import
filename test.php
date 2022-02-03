
<?php
$url = "Book1.csv";

$current = file_get_contents($url);

$s = html_entity_decode($current);
$s = strip_tags($s);
$s = preg_replace('/\xA0/u','', $s);

$patterns = array();
$patterns[1] = '/jpg;http/';

$replacements = array();
$replacements[0] = 'jpg,http';


$parsed = preg_replace($patterns, $replacements, $s);

file_put_contents('../php training/book.csv', $parsed);
?>
