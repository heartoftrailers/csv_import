
<?php
$url = "Book1.csv";

$current = file_get_contents($url);

// $a = htmlspecialchars($current);
$a = htmlspecialchars_decode($current);
 

// $b = htmlspecialchars_decode($a);
 
// $c =htmlspecialchars_decode($b);

// $patterns = array();
// $patterns[1] = '/jpg;http/';

// $replacements = array();
// $replacements[0] = 'jpg,http';

// $f = html_entity_decode($a, ENT_COMPAT | ENT_HTML5);

// $g = preg_replace($patterns, $replacements, $a);

file_put_contents('../php training/latest8.csv',$a);

$x = str_getcsv($a);

print_r($x);


?>