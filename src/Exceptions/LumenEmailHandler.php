<?php

namespace Abrigham\LaravelEmailExceptions\Exceptions;

use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Mail;

class LumenEmailHandler extends ExceptionHandler
{
    use EmailHandlerTrait;
}
