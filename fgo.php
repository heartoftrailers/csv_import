<?php
$row = 1;
$csv = array();
$url1 = array();
// if (($handle = fopen("JucariiOnline-2022-01-11T180744.395.csv", "r")) !== FALSE) {
if (($handle = fopen("puimic_catalog-2.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
        $num = count($data);
        $list = array();
        $url = array();

        if($row == 1) {
            print_r($data);
            $list = $data;
            $hc = $num;
        }else {

            if($hc != $num) {
                echo "HC: $hc<br>";
                echo "Num: $num<br>";
                echo "<br>";
                //cho "ERROR!, $row";
                echo 'Error ! Line:'.$num.'<br>';
                
               
            }

            for ($c=0; $c < $num; $c++) {
                $patterns = array();
                $patterns[] = 'jpg;http';
                $patterns[] = 'jpeg;http';
                $patterns[] = 'gif;http';
                $patterns[] = '&lt;table&gt';
                $patterns[] = '&lt;/table&gt;';
                $patterns[] = 'png;http';
                $patterns[] = 'PNG;http';

                $replacements = array();
                $replacements[] = 'jpg,http';
                $replacements[] = 'jpeg,http';
                $replacements[] = 'gif,http';            
                $replacements[] = '';
                $replacements[] = '';
                $replacements[] = 'png,http';
                $replacements[] = 'PNG,http';

                $list[] = htmlspecialchars_decode(str_replace($patterns,$replacements,$data[$c]));
                // $list[] = htmlspecialchars_decode($data[$c]);
                $imgRes = array();
                // $pattern = '#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#';

                if (preg_match_all('/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&\/\/=]*)/', $list[$c], $matches))
                // if (preg_match_all($pattern, $list[$c], $matches))
                {                    
                    print_r($matches[0]);
                    $imgRes = array(
                        'line' => $list[0],                        
                        'urls' => $matches[0]
                    );
                    unset($matches);
                    $url = $imgRes;
                    // print_r($imgRes);
                }
               
                

            }
            
        }
        // print_r($url);
        // printArray($list);
        $url1[] = $url;
        $csv[] = $list;
        // echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;
        
    }
    fclose($handle);

}

$x =json_encode($url1);
file_put_contents('filename.txt', print_r($x, true));
// print_r($url1);


$current = fopen("fgo.csv", "w");
foreach ($csv as $fields) {
    fputcsv($current, $fields);
    // print_r ($fields);
}
?>