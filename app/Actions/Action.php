<?php

namespace App\Actions;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class Action
{
    protected $failed;
    protected $message;

    public function __construct()
    {
        $this->failed = false;
        $this->message = "";
    }

    public function IsFailed()
    {
        return $this->failed;
    }

    public function getMessage()
    {
        return $this->message;
    }

    protected function CheckModel($model, $failMessage = "Model not found")
    {
        if(!$model) {
            throw new ModelNotFoundException($failMessage, 404);
        }
    }

}