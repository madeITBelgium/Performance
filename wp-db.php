<?php
/*
 * Add to wp-config.php:
 * define('SAVEQUERIES', true);
 * define('START_TIME', microtime(true));
 *
 * View admin pages and add ?debug=true or &debug=true to the url.
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
