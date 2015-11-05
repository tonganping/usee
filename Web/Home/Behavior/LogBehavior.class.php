<?php
/**
 * Created by PhpStorm.
 * User: very80
 * Date: 2015-07-31
 * Time: 14:16
 */

namespace Home\Behavior;

class LogBehavior {
    public function run() {
        LOGFILE('Trigger: ', $_GET, $_POST );
    }
}

