<?php

namespace App\Exceptions\Custom;

use Exception;
use App\Exceptions\Custom\Responses\Messages;

class InvalidDataException extends Exception
{
    public function report()
    {
       
    }

    public function render($request)
    {
        return Messages::InvalidData();
    }
}