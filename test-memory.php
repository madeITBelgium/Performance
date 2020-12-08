<pre><?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$megabyte = 1528; // define the max megabytes which should be tested
 
function tryAlloc($megabyte){
    echo "try allocating {$megabyte} megabyte...";
    $mb = $megabyte;
    $dummy = str_repeat("-",1048576*$mb);
    echo "pass.";
    echo "Usage: " . memory_get_usage(true)/1048576;
    echo " Peak: " . memory_get_peak_usage(true)/1048576;
    echo "\n";
}

for($i=8;$i<=$megabyte;$i+=8){
    $limit = $i.'M';
    ini_set('memory_limit', $limit);
    echo "set memory_limit to {$limit}\n";
    echo "memory limit is ". ini_get("memory_limit")."\n";
    
    //Limit memory -20% of max to stay lower then te maximum allowed memory.
    $testMemory = min($i - 3, round($i - $i / 100 * 20));
    tryAlloc($testMemory);
}
 
?></pre>
