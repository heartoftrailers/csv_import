<?php

$row = 1;
$csv = array();
if (($handle = fopen("puimic_catalog-2.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);

        $list = array();
        $url = array();
      
       
        if($row == 1) {
            // print_r($data);
            $list = $data;
            $hc = $num;
        }else {
            if($hc != $num) {
                echo "ERROR!, $row";
                echo $num;
                print_r($data);
                
               
            }

            for ($c=0; $c < $num; $c++) {
                // echo htmlspecialchars_decode($data[$c]);
                
                $patterns = array();
                $patterns[1] = 'jpg;http';
                $patterns[2] = '&lt;table&gt';
                $patterns[3] = '&lt;/table&gt;';

                $replacements = array();
                $replacements[0] = 'jpg,http';
                $replacements[-1] = '';
                $replacements[-2] = '';
                
                $list[] = htmlspecialchars_decode(str_replace($patterns,$replacements,$data[$c]));
                
                $pattern = '#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#';
                if($num_found = preg_match_all($pattern, $list[$c], $matches))
                {
                    // print_r($matches[0]);

                    $url[] = array('line' => $row,
                    'urls' => $matches[0]);
                    unset($matches);
                    

                    // foreach ($array as $url) {
                        
                    //     if (http_response($url, 200)) {
                    //         echo("\n VALID");
                    //     }
                    //     else {
                    //         echo("INVALID");
                    //     }
                    //  }
                }
            }
        }
        // print_r($url);
        $csv[] = $list;
        // echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;
    }
    fclose($handle);
}




// $url_links = fopen("Urls_File.csv", "w");
// foreach ($matches as $links) {
//     fputcsv($url_links, $links);
    // print_r ($fields);
// }


$current = fopen("booktrans.csv", "w");
foreach ($csv as $fields) {
    fputcsv($current, $fields);
    // print_r ($fields);
}

function http_response($url, $status = null, $wait = 3)
{
        $time = microtime(true);
        $expire = $time + $wait;

        // we fork the process so we don't have to wait for a timeout
        $pid = pcntl_fork();
        if ($pid == -1) {
            die('could not fork');
        } else if ($pid) {
            // we are the parent
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, TRUE);
            curl_setopt($ch, CURLOPT_NOBODY, TRUE); // remove body
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            $head = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
           
            if(!$head)
            {
                return FALSE;
            }
           
            if($status === null)
            {
                if($httpCode < 400)
                {
                    return TRUE;
                }
                else
                {
                    return FALSE;
                }
            }
            elseif($status == $httpCode)
            {
                return TRUE;
            }
           
            return FALSE;
            pcntl_wait($status); //Protect against Zombie children
        } else {
            // we are the child
            while(microtime(true) < $expire)
            {
            sleep(0.5);
            }
            return FALSE;
        }
    } 

?>