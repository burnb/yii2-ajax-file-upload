<?php

namespace app\components;

use yii\behaviors\TimestampBehavior as YiiTimestampBehavior;
use yii\db\Expression;

class TimestampBehavior extends YiiTimestampBehavior
{
    /**
     * Reload method for using mysql NOW() expression instead of time() php function for getting column value.
     *
     * @inheritdoc
     */
    protected function getValue($event)
    {
        if ($this->value instanceof Expression) {
            return $this->value;
        } else {
            return $this->value !== null ? call_user_func($this->value, $event) : new Expression("NOW()");
        }
    }
}