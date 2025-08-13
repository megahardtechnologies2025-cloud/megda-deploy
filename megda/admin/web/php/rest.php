<?php
    echo 'Initiating Curl Call';
    
            $curl = curl_init();
            
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://10.65.46.55:9001/siebel/v1.0/data/Contact/Contact?recordcountneeded=true',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'HEAD',
              CURLOPT_HTTPHEADER => array(
                'Authorization: Basic U0FETUlOOlNJRUJFTA=='
              ),
            ));
    
            
            $response = curl_exec($curl);
            
            curl_close($curl);
            echo $response;
/*            
            $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
            $headers = substr($response, 0, $header_size);
            $body = substr($response, $header_size);
            
            // Parse the headers
            $header_lines = explode("\r\n", trim($headers));
            $header_array = array();
            
            foreach ($header_lines as $line) {
              if (strpos($line, ': ') !== false) {
                list($key, $value) = explode(': ', $line, 2);
                $header_array[trim($key)] = trim($value);
              }
            }
            
            // Now you can access the header values:
            if (isset($header_array['Total-Record-Count'])) {
                $record_count = "Total-Record-Count: " . $header_array['Total-Record-Count'] . "\n";
                
            }
            echo $record_count;
*/

?>