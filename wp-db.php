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
add_action('admin_footer', 'test_db');

function test_wp_db()
{
    global $wpdb, $_GET;

    if (true || isset($_GET['debug'])) {
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
        $fp = fopen('query.log', 'a');
        fwrite($fp, 'Queries: '.$nQrs.' - Total Time:'.round($totalTime, 3).'s - maxTime: '.round($maxTime, 3).'s - Totale page time: '.round($endTime - $startTime, 3).'s' . "\n");
        fwrite($fp, print_r($wpdb->queries[$maxIndex], true) . "\n");
        fclose($fp);
        
        
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
add_action('wp_footer', 'test_wp_db');
