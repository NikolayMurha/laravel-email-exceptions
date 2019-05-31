<?php

namespace Abrigham\LaravelEmailExceptions\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Container\Container;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Request;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class ExceptionMail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * * @var \Throwable
     */
    private $exception;

    /**
     * @var string
     */
    public $theme;

    /**
     * Create a new message instance.
     *
     * @param \Throwable $exception
     * @param string $theme
     */
    public function __construct($exception, $theme = 'default')
    {
        $this->exception = $exception;
        $this->theme = $theme;
    }

    /**
     * Build the message.
     *
     * @return $this
     * @throws \ReflectionException
     */
    public function build()
    {
        $default = sprintf("An Exception has been thrown on %s (%s)", config('app.name', 'unknown'), config('app.env', 'unknown'));
        $this->subject(config('laravel_email_exceptions.email_subject', $default));

        $this->from(
            config('laravel_email_exceptions.from_email_address'),
            config('laravel_email_exceptions.from_name')
        );
        $this->to(config('laravel_email_exceptions.to_email_address'));

        $this->view('laravel-email-exceptions::mail')->with([
            'appName' => config('app.name'),
            'appEnv' => config('app.env'),
            'appUrl' => Request::fullUrl(),
            'allExceptions' => array_merge([$this->exception], $this->getPreviousExceptions()),
            'exception' => $this->exception,
            'environment' => config('laravel_email_exceptions.show_environment'),
            'request' => config('laravel_email_exceptions.show_request'),
            'previousExceptions' => $this->getPreviousExceptions()
        ]);

        $contents = $this->withLocale($this->locale, function () {
            $mailer = Container::getInstance()->make('mailer');
            $contents = $mailer->render($this->buildView(), $this->buildViewData());
            return (new CssToInlineStyles)->convert($contents,
                $mailer->getViewFactory()
                    ->make('laravel-email-exceptions::themes.' . $this->theme)
                    ->render()
            );
        });
        $this->html($contents);
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
        return array_merge(Request::all(), (array)Request::header());
    }

    protected function getEnv()
    {
        if (!config('laravel_email_exceptions.show_environment')) {
            return [];
        }
        return getenv();
    }
}
