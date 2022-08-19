<?php

namespace App\Actions;

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

}