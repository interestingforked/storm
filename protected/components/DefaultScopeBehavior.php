<?php

class DefaultScopeBehavior extends CActiveRecordBehavior {

    private $_disabled = false; // Flag - whether defaultScope is disabled or not

    public function disableDefaultScope() {
        $this->_disabled = true;
        return $this->Owner;
    }

    public function isDefaultScopeDisabled() {
        return $this->_disabled;
    }

}