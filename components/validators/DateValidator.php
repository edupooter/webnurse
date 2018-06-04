<?php

namespace app\components;

use yii\validators\Validator;

class DateValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        if (!in_array($model->$attribute, ['USA', 'Indonesia'])) {
            $this->addError($model, $attribute, 'The country must be either "{country1}" or "{country2}".', ['country1' => 'USA', 'country2' => 'Indonesia']);
        }
    }
}
