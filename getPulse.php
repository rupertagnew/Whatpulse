<?php
 echo "Timedate,Timestamp,Keys,Clicks,DownloadMB,UploadMB,UptimeSeconds,Computer" . '<br>';
 
 $start    = 1483228800; //January 1 2017 
 $end      = time();
 $username = 'your-username-here';
 
 getPulse($username, $start, $end);
 
 function getPulse($username, $start, $end)
 {
     
     $url    = 'http://api.whatpulse.org/pulses.php?user=' . $username . '&start=' . $start . '&end=' . $end . '&format=json';
     $json   = file_get_contents($url);
     $result = json_decode($json);
     $length = json_decode($json, true);
     $length = count($length);
     if (!empty($result->error)) {
         echo "Something went wrong: " . $result->error;
     } else {
         $count = 0;
         foreach ($result as $pulse) {
             $timedate  = $pulse->Timedate;
             $timestamp = $pulse->Timestamp;
             $keys      = $pulse->Keys;
             $clicks    = $pulse->Clicks;
             $dlmb      = $pulse->DownloadMB;
             $upmb      = $pulse->UploadMB;
             $upsec     = $pulse->UptimeSeconds;
             $computer  = $pulse->Computer;
             
             if ($count < $length) {
                 echo $timedate . "," . $timestamp . "," . $keys . "," . $clicks . "," . $dlmb . "," . $upmb . "," . $upsec . "," . $computer . '<br>';
                 $count++;
				 
                 if ($count == $length) {

                     $newstart = $timestamp - 5259486;
                     $newend   = $timestamp - 1; //2 months
					 //echo "FINAL PULSE = " . $timedate . "" . '<br />';                    
                     //echo "NEW START = " . gmdate('Y-m-d H:i:s ',$newend) . '<br />';
                     //echo "NEW END = " . gmdate('Y-m-d H:i:s ',$newstart) . '<br />';
                     //echo $newurl = "NEW URL = " . 'http://api.whatpulse.org/pulses.php?user='.$username.'&start='.$newstart.'&end='.$newend.'&format=json' . '<br />';
                     
                     $count = 0;
                     sleep(1);
                     getPulse($username, $newstart, $newend);                    
                 }
             } else {
                 break;
             }            
         }
     }
 }
?>