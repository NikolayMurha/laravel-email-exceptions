<?php

namespace Abrigham\LaravelEmailExceptions\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Mail;

class EmailHandler extends ExceptionHandler
{
    use EmailHandlerTrait;
}
