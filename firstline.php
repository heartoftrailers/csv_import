<?php
$old_file = 'book.csv';
$new_file = 'testdata_new.csv';

$file_to_read = file_get_contents($old_file);  // Reading entire file
$lines_to_read = explode("\n", $file_to_read);  // Creating array of lines

if ( $lines_to_read == '' ) die('EOF'); // No data 

$line_to_append = array_shift( $lines_to_read ); // Extracting first line
echo $line_to_append; 

$file_to_append = file_get_contents($new_file);  // Reading entire file

if ( substr($file_to_append, -1, 1) != "\n" ) $file_to_append.="\n";  // If new file doesn't ends in new line I add it

// Writing files
file_put_contents($new_file, $file_to_append . $line_to_append . "\n");
file_put_contents($old_file, implode("\n", $lines_to_read));
?>