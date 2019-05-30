<?php

namespace Abrigham\LaravelEmailExceptions\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

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
        $this->subject(config('laravel_email_exceptions.error_email.email_subject', $default));

        $this->from(
            config('laravel_email_exceptions.error_email.from_email_address'),
            config('laravel_email_exceptions.error_email.fromName')
        );
        $this->to(config('laravel_email_exceptions.error_email.to_email_address'));

        return $this->markdown('laravel-email-exceptions::email-exception');
    }

    /**
     * @return array
     */
    public function getPreviousExceptions()
    {
        $previousExceptions = [];
        $prev = $this->exception->getPrevious();
        while ($prev !== null) {
            $previousExceptions[] = $prev;
            $prev = $prev->getPrevious();
        }

        return $previousExceptions;
    }
}
