<?php

namespace Abrigham\LaravelEmailExceptions\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Request;

class ExceptionMail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * * @var \Throwable
     */
    private $exception;

    /**
     * Create a new message instance.
     *
     * @param \Throwable $exception
     */
    public function __construct($exception)
    {
        $this->exception = $exception;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $default = sprintf("An Exception has been thrown on %s (%s)", config('app.name', 'unknown'), config('app.env', 'unknown'));
        $this->subject(config('laravel_email_exceptions.email_subject', $default));

        $this->from(
            config('laravel_email_exceptions.from_email_address'),
            config('laravel_email_exceptions.fromName')
        );
        $this->to(config('laravel_email_exceptions.to_email_address'));

        return $this->markdown('laravel-email-exceptions::mail')->with([
            'appName' => config('app.name'),
            'appEnv' => config('app.env'),
            'appUrl' => Request::fullUrl(),
            'allExceptions' => array_merge([$this->exception], $this->getPreviousExceptions()),
            'exception' => $this->exception,
            'environment' => $this->getEnv(),
            'request' => $this->getRequest(),
            'previousExceptions' => $this->getPreviousExceptions()
        ]);
    }

    /**
     * @return array
     */
    protected function getPreviousExceptions()
    {
        if (!config('laravel_email_exceptions.show_previous_exceptions')) {
            return [];
        }
        $previousExceptions = [];
        $prev = $this->exception->getPrevious();
        while ($prev !== null) {
            $previousExceptions[] = $prev;
            $prev = $prev->getPrevious();
        }

        return $previousExceptions;
    }

    protected function getRequest()
    {
        if (!config('laravel_email_exceptions.show_request')) {
            return [];
        }
        return Request::all();
    }

    protected function getEnv()
    {
        if (!config('laravel_email_exceptions.show_environment')) {
            return [];
        }
        return getenv();
    }

}
