<?php
function csvtoarray($filename='Book.csv', $delimiter){

    if(!file_exists($filename) || !is_readable($filename)) return FALSE;
    $header = NULL;
    $data = array();

    if (($handle = fopen($filename, 'r')) !== FALSE ) {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
        {   
            if(!$header){
                $header = $row;
            }else{
                $data[] = array_combine($header, $row);
            }
        }
        fclose($handle);
    }
    if(file_exists($filename)) @unlink($filename);

    return $data;
}

$data = csvtoarray('Book.csv', ',');

print_r($data);
?>
