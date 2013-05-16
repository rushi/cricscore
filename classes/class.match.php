<?php

class Match {
    
    private $matchInfo = array();
    private $batting = array();
    private $bowling = array();
    private $comms = array();
        
    function __construct($j) {
        $this->matchInfo = $j;
        $this->batting = $j->batting;
        $this->bowling = $j->bowling;
        $this->comms = $j->comms;
    }
    
    function isRunning() {
        if ($this->matchInfo->isStarted == 1)
            return true;
            
        return false;    
    }
    
    function getSummary() {
        return $this->matchInfo->current_summary;
    }
    
    function lastBall() {
        $lb = $this->comms[0];
        if (isset($lb->pre_text)) {
            $lb->pre_text = trim($lb->pre_text);
        } else {
            $lb->pre_text = NULL;
        }

        return $lb;
    }
    
    function lastRuns() {
        $lastBall = $this->lastBall();
        $runs = 0;
        if ($lastBall->event != 'no run') {
            if (preg_match("/(\d{1,}|four|six)/i", $lastBall->event, $matches)) {
                $runs = $matches[1];
                //print_r($matches);
            }
        }

        return $runs;
    }
}