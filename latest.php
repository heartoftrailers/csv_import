
<?php
$url = "Book1.csv";

$current = file_get_contents($url);

$a = htmlspecialchars($current);


$patterns = array();
$patterns[1] = '/jpg;http/';

$replacements = array();
$replacements[0] = 'jpg,http';

// $f = html_entity_decode($a, ENT_COMPAT | ENT_HTML5);
$f= $a;
$g = preg_replace($patterns, $replacements, $f);


file_put_contents('../php training/latest7.csv', $g);
?>