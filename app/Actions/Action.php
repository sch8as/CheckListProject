<?php

namespace App\Actions;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class Action
{
    protected function checkModel($model, $failMessage = "Model not found")
    {
        if(!$model) {
            throw new ModelNotFoundException($failMessage, 404);
        }
    }

}