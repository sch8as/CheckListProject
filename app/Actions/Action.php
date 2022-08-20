<?php

namespace App\Actions;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class Action
{
    protected function CheckModel($model, $failMessage = "Model not found")
    {
        if(!$model) {
            throw new ModelNotFoundException($failMessage, 404);
        }
    }

}