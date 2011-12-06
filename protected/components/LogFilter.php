<?php

class LogFilter extends CLogFilter {

    public $ignoreCategories; // =array('category','category.*','some.category.tree.*');

    public function filter(&$logs) {
        // unset categories marked as "ignored"
        if ($logs)
            foreach ($logs as $logKey => $log) {
                $logCategory = $log[2]; //log category
                foreach ($this->ignoreCategories as $nocat) {
                    // Exact match
                    if ($logCategory === $nocat) {
                        unset($logs[$logKey]);
                        continue;
                    }
                    // Wildcard match
                    else if (strpos($nocat, '.*') !== false) {
                        $nocat = str_replace('.*', '', $nocat) . '.'; //remove asterix item from array and add dot at the and
                        if (strpos($logCategory . '.', $nocat) !== false) {
                            unset($logs[$logKey]);
                        }
                    }
                }
            }

        $this->format($logs);
        return $logs;
    }

}