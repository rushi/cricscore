<?php
require_once 'config.php';

$do = true;

$status = NULL;
while ($do) {
    $matches = makeRequest(getMatchURL());
    //print_r($matches[0]);
    $m = new Match($matches[0]);
    
    if ($m->getSummary() != $status) {
        $last_ball = $m->lastBall();
        $runs = $m->lastRuns();
        
        echo_debug($m->getSummary());
        echo_debug(json_encode($last_ball) . "\n");
        
        if ($last_ball->dismissal != '') {
            $level = 1;
            $title = $m->getSummary();
            $msg = $last_ball->players . ", OUT! " . $last_ball->dismissal . "\n" . $last_ball->text;
        } else {
            $title = $m->getSummary();
            $msg = $last_ball->players . ", " . $last_ball->event . "\n";

            if ($last_ball->pre_text != '') {
                $msg .= strip_tags($last_ball->pre_text) . "\n";
            }

            if ($last_ball->text != "") {
                $msg .= $last_ball->text . "\n";
            }

            $level = ($runs >= 4) ? 2 : ($runs >= 1) ? 3 : 4;
        }

        if (VERBOSE >= $level) {
            doGrowl($title, $msg);
        } elseif ($last_ball->pre_text != '') {
            doGrowl($m->getSummary(), strip_tags($last_ball->pre_text));
        }
        
        $status = $m->getSummary();    
    }
    
    flush();
    sleep(SLEEP_INTERVAL);
}