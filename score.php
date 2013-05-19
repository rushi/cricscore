<?php
require_once 'config.php';

$do = true;

$status = NULL;
while ($do) {
    $matches = makeRequest(getMatchURL());
    //print_r($matches[0]);
    $m = new Match($matches[2]);
    $do = $m->isRunning();
    
    if ($m->getSummary() != $status) {
        $last_ball = $m->lastBall();
        $runs = $m->lastRuns();
        
        echo_debug($m->getSummary());
        echo_debug(json_encode($last_ball) . "\n");
        
        $sticky = false;
        if ($last_ball->dismissal != '') {
            $level = 1; $sticky = true;
            $title = $last_ball->players . ", OUT";
            $msg = $last_ball->dismissal . "\n" . $last_ball->text . "\n";
            $msg .= $m->getSummary();
        } else {
            $msg = $last_ball->players . ", " . $last_ball->event . "\n";

            if ($last_ball->pre_text != '') {
                $msg .= strip_tags($last_ball->pre_text) . "\n";
            }

            if ($last_ball->text != "") {
                $msg .= $last_ball->text . "\n";
            }

            if ($runs >= 4) {
                $level = 2;
            } elseif ($runs >= 1) {
                $level = 3;
            } else {
                $level = 4;
            }

            if ($runs >= 4) {
                $title = "SHOT $runs runs - " . $m->getScore();
                $msg .= "\n" . $m->getSummary() . "\n";
            } else {
                $title = $m->getSummary();
            }
        }

        if (VERBOSE >= $level) {
            doGrowl($title, $msg, $sticky);
        } elseif ($last_ball->pre_text != '') {
            doGrowl($m->getSummary(), strip_tags($last_ball->pre_text), $sticky);
        }
        
        $status = $m->getSummary();    
    }
    
    flush();
    sleep(SLEEP_INTERVAL);
}

echo "I'm done, thank you very much!\n";
doGrowl("Completed", "Script Completed, match is not running!");
