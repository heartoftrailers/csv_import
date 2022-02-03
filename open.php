<?php
$file = fopen("Book1.csv","r");
while (($data = fgetcsv($file)) !== false) {
  
    // HTML tag for placing in row format
    echo "<tr>";
    foreach ($data as $i) {
        echo "<td>" . htmlspecialchars($i) 
            . "</td>";
    }
    echo "</tr> \n";
}

// Closing the file
fclose($file);

echo "\n</table></center></body></html>";
?>
