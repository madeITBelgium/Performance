<?php
/*
 * Plugin Name: Performance analyze
 * Plugin URI: https://www.madeit.be
 * Description: A wordpress plugin to analyze the performance of the WordPress Core
 * Author: Tjebbe Lievens
 * Author URI: https://www.madeit.be
 * Version: 1.0.0
 * Text Domain: performance
 * Domain Path: /languages
 * License: GPLv3.
 */

/*
 * Add to wp-config.php:
 * define('SAVEQUERIES', true);
 * define('START_TIME', microtime(true));
 *
 * View admin pages and add ?debug=true or &debug=true to the url.
 *
 *
 * Add to functions.php:
 */


/*
 * Add to wp-config.php:
 * define('SAVEQUERIES', true);
 * define('START_TIME', microtime(true));
 *
 * View admin pages and add ?debug=true or &debug=true to the url.
 *
 *
 * Add to functions.php:
 */

if (!defined('SAVEQUERIES')) {
    define('SAVEQUERIES', true);
}
if (!defined('START_TIME')) {
    define('START_TIME', microtime(true));
}
if(!defined('WRITE_TO_LOG')) {
    define('WRITE_TO_LOG', false);
}

function test_db()
{
    global $wpdb, $_GET;

    if (isset($_GET['debug'])) {
        $nQrs = 0;
        $totalTime = 0;
        $maxTime = 0;
        $maxQry = 0;

        $startTime = START_TIME;
        $endTime = microtime(true);

        foreach ($wpdb->queries as $query) {
            ++$nQrs;
            $totalTime += $query[1];
            if ($query[1] > $maxTime) {
                $maxQry = $query;
                $maxTime = $query[1];
            }
        }
        
        if(WRITE_TO_LOG) {
            $fp = fopen('query.log', 'a');
            fwrite($fp, ($_SERVER['REQUEST_URI'] ?? '') . ' - Queries: '.$nQrs.' - Total Time:'.round($totalTime, 3).'s - maxTime: '.round($maxTime, 3).'s - Totale page time: '.round($endTime - $startTime, 3).'s' . "\n");
            fwrite($fp, print_r($wpdb->queries[$maxIndex], true) . "\n");
            fclose($fp);
        }
        else {
            echo '<div style="margin-left: 200px">';
            echo 'Queries: '.$nQrs.' - Total Time:'.round($totalTime, 3).'s - maxTime: '.round($maxTime, 3).'s - Totale page time: '.round($endTime - $startTime, 3).'s <br>';
            echo '<pre>';
            print_r($maxQry);
            echo '</pre>';

            echo '<pre>';
            print_r($wpdb->queries);
            echo '</pre>';
            echo '</div>';
        }
    }
}
add_action('admin_footer', 'test_db');

function test_wp_db()
{
    global $wpdb, $_GET, $wp;

    if (isset($_GET['debug'])) {
        $nQrs = 0;
        $totalTime = 0;
        $maxTime = 0;
        $maxQry = 0;
        $maxIndex = null;
        
        $startTime = START_TIME;
        $endTime = microtime(true);

        foreach ($wpdb->queries as $index => $query) {
            ++$nQrs;
            $totalTime += $query[1];
            if ($query[1] > $maxTime) {
                $maxQry = $query;
                $maxTime = $query[1];
                $maxIndex = $index;
            }
        }
        
        if(WRITE_TO_LOG) {
            $fp = fopen('query.log', 'a');
            fwrite($fp, ($_SERVER['REQUEST_URI'] ?? '') . ' - Queries: '.$nQrs.' - Total Time:'.round($totalTime, 3).'s - maxTime: '.round($maxTime, 3).'s - Totale page time: '.round($endTime - $startTime, 3).'s' . "\n");
            fwrite($fp, print_r($wpdb->queries[$maxIndex], true) . "\n");
            fclose($fp);
        }
        else {
            echo '<div style="margin-left: 200px">';
            echo 'Queries: '.$nQrs.' - Total Time:'.round($totalTime, 3).'s - maxTime: '.round($maxTime, 3).'s - Totale page time: '.round($endTime - $startTime, 3).'s <br>';
            echo '<pre>';
            print_r($maxQry);
            echo '</pre>';

            echo '<pre>';
            print_r($wpdb->queries);
            echo '</pre>';
            echo '</div>';
        }
    }
}
add_action('wp_footer', 'test_wp_db');


$fp = fopen('data.txt', 'a');
$perf = [
    'times' => 0,
    'prevTag' => null,
    'prevTiming' => START_TIME,
    
    'maxTime' => 0,
    'maxTag' => 0,
    'maxTiming' => 0,
    'tags' => [],
];

add_action('all', function ( $tag ) use ($fp, &$perf) {
    global $wpdb, $_GET;
    
    if(!isset($_GET['debug'])) {
        return;
    }
    
    $timing = round(microtime(true) - START_TIME, 4);
    $runTime = $timing - $perf['prevTiming'];
    
    //fwrite($fp, "[" . date('Y-m-d H:i:s') . "]: " . $tag . ' -> ' . $timing . "\n");
    if($runTime > 0.5) {
        //fwrite($fp, "[" . date('Y-m-d H:i:s') . "]: " . $perf['times'] . " -> " . $perf['prevTag'] . ' -> ' . $timing . " -> " . $runTime . "\n");
    }


    if($runTime > $perf['maxTiming']) {
        $perf['maxTime'] = $perf['times'];
        $perf['maxTag'] = $perf['prevTag'];
        $perf['maxTiming'] = $runTime;
    }
    
    $perf['times']++;
    
    $perf['prevTag'] = $tag;
    $perf['prevTiming'] = $timing;
    
    if(!isset($perf['tags'][$tag])) {
        $perf['tags'][$tag] = ['tag' => $tag, 'times' => 0, 'time' => 0];
    }
    
    $perf['tags'][$tag]['times']++;
    $perf['tags'][$tag]['time'] += $runTime;
    
    
    
    if($tag === 'shutdown') {
        $data = $perf;
        unset($perf['tags']);
        $maxTime = 0;
        $maxTimes = 0;
        $maxTimeItem = [];
        $maxTimesItem = [];
        
        foreach($data['tags'] as $k => $tag) {
            if($maxTime < $tag['time']) {
                $maxTime = $tag['time'];
                $maxTimeItem = $tag;
            }
            
            if($maxTimes < $tag['times']) {
                $maxTimes = $tag['times'];
                
                $maxTimesItem = $tag;
            }
        }
        
        $perf['tags'] = [
            'max_times' => $maxTimesItem,
            'max_time' => $maxTimeItem,
        ];
        fwrite($fp, "[" . date('Y-m-d H:i:s') . "]: " . print_r($perf, true));
        fclose($fp);
    }
});
