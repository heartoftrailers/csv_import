<?php
    $finfo = finfo_open(FILEINFO_MIME_TYPE); // Return MIME type
    foreach (glob("*") as $filename) {
        echo finfo_file($finfo, $filename) . "\n";
    }
    finfo_close($finfo);

$file = 'puimic_catalog-2.csv';

if (file_exists($file)) {
    echo "$file was last modified: " . date ("F d Y H:i:s.", filemtime($file));
}

$contents = file_get_contents($file);
$pattern = '@((https?://)?(http?://)?([-\\w]+\\.[-\\w\\.]+)+\\w(:\\d+)?(/([-\\w/_\\.]*(\\?\\S+)?)?)*)@';
if(preg_match_all($pattern, $contents, $matches)){
    // echo "Found VALID matches:\n";
    // // echo implode("\n", $matches[0]);

    $array = $matches[0];

    foreach ($array as $url) {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            echo("\n $url  \n Valid URL");
            // if (http_response($url, 200)) {
            //     echo("\n VALID");
            // }
            // else {
            //     echo("INVALID");
            // }
        } else {
            // echo "\n Found invalid matches:\n";
            // echo("$url is not a valid URL");
        }
    }
}
else{
    echo "No matches found";
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