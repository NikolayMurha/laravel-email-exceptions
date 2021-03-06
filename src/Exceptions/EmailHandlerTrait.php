<?php

namespace Abrigham\LaravelEmailExceptions\Exceptions;

use Abrigham\LaravelEmailExceptions\Mail\ExceptionMail;
use Exception;
use Illuminate\Support\Facades\Cache;
use Mail;

trait EmailHandlerTrait
{
    /**
     * @var string global throttle cache key
     */
    protected $globalThrottleCacheKey = "email_exception_global";

    /**
     * @var null|string throttle cache key
     */
    protected $throttleCacheKey = null;

    /**
     * Report or log an exception.
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param \Exception $exception
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        // check if we should mail this exception
        if ($this->shouldMail($exception)) {
            // if we passed our validation lets mail the exception
            $this->sendExceptionMail($exception);
        }
        // run the parent report (logs exception and all that good stuff)
        $this->callParentReport($exception);
    }

    /**
     * Wrapping the parent call to isolate for testing
     *
     * @param Exception $exception
     * @return void
     * @throws Exception
     */
    protected function callParentReport(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Determine if the exception should be mailed
     *
     * @param Exception $exception
     * @return boolean
     * @throws Exception
     */
    protected function shouldMail(Exception $exception)
    {
        if (!config('laravel-email-exceptions.enabled')) {
            return false;
        }

        if (config('app.debug') and config('laravel-email-exceptions.disable_on_debug')) {
            return false;
        }

        if (!config('laravel-email-exceptions.to_email_address') || !config('laravel-email-exceptions.from_email_address')) {
            return false;
        }

        if ($this->skipException($exception)) {
            return false;
        }

        if ($this->shouldntReport($exception)) {
            return false;
        }

        if ($this->isExcluded($exception)) {
            return false;
        }

        if ($this->throttle($exception) || $this->globalThrottle()) {
            return false;
        }

        // we made it past all the possible reasons to not email so we should mail this exception
        return true;
    }

    /**
     * App specific dont email logic should go in this function
     *
     * @param Exception $exception
     * @return boolean
     *
     */
    protected function skipException(Exception $exception)
    {
        // override this in app/Exceptions/Handler.php if you need more complicated logic
        // then checking instanceof with exception classes
        return false;
    }

    /**
     * Mail the exception
     *
     * @param Exception $exception
     * @return void
     *
     */
    protected function sendExceptionMail(Exception $exception)
    {
        Mail::send(new ExceptionMail($exception));
    }

    /**
     * Check if we need to globally throttle the exception
     *
     * @return boolean
     *
     */
    protected function globalThrottle()
    {
        // check if global throttling is turned on
        if (config('laravel-email-exceptions.global_throttle') == false) {
            // no need to throttle since global throttling has been disabled
            return false;
        } else {
            // if we have a cache key lets determine if we are over the limit or not
            if ($this->cache()->has($this->globalThrottleCacheKey)
            ) {
                // if we are over the limit return true since this should be throttled
                if ($this->cache()->get($this->globalThrottleCacheKey, 0) >= config('laravel-email-exceptions.global_throttle_limit')
                ) {
                    return true;
                } else {
                    // else lets increment the cache key and return false since its not time to throttle yet
                    $this->cache()->increment($this->globalThrottleCacheKey);
                    return false;
                }
            } else {
                // we didn't find an item in cache lets put it in the cache
                $this->cache()->put($this->globalThrottleCacheKey, 1, config('laravel-email-exceptions.global_throttle_duration_minutes')
                );
                // if we're just making the cache key now we are not global throttling yet
                return false;
            }
        }
    }

    /**
     * Check if we need to throttle the exception and do the throttling if required
     *
     * @param Exception $exception
     * @return boolean return true if we should throttle or false if we should not
     */
    protected function throttle(Exception $exception)
    {
        // if throttling is turned off or its in the dont throttle list we won't throttle this exception
        if (config('laravel-email-exceptions.throttle') == false ||
            $this->isThrottleExcluded($exception)
        ) {
            // report that we do not need to throttle
            return false;
        } else {
            // else lets check if its been reported within the last throttle period
            if ($this->cache()->has($this->getThrottleCacheKey($exception))
            ) {
                // if its in the cache we need to throttle
                return true;
            } else {
                // its not in the cache lets add it to the cache
                $this->cache()->put($this->getThrottleCacheKey($exception), true,
                    config('laravel-email-exceptions.throttle_duration_minutes')
                );
                // report that we do not need to throttle as its not been reported within the last throttle period
                return false;
            }
        }
    }

    /**
     * Get the throttle cache key
     *
     * @param Exception $exception
     * @return mixed
     */
    protected function getThrottleCacheKey(Exception $exception)
    {
        // if we haven't already set the cache key lets set it
        if ($this->throttleCacheKey == null) {
            // make up the cache key from a prefix, exception class, exception message, and exception code
            // with all special characters removed
            $this->throttleCacheKey = preg_replace(
                "/[^A-Za-z0-9]/",
                '',
                'laravel-email-exception' . get_class($exception) . $exception->getMessage() . $exception->getCode()
            );
        }
        // return the cache key
        return $this->throttleCacheKey;
    }

    /**
     * Check if a given exception matches the class of any in the list
     *
     * @param $list
     * @param Exception $exception
     * @return boolean
     */
    protected function isInList($list, Exception $exception)
    {
        // check if we actually have a list and its an array
        if ($list && is_array($list)) {
            // if we do lets loop through and check if our exception matches any of the classes
            foreach ($list as $type) {
                if ($exception instanceof $type) {
                    // if we match return true
                    return true;
                }
            }
        }
        // we got to the end there must be no match
        return false;
    }

    /**
     * Check if the exception is in the dont throttle list
     *
     * @param Exception $exception
     * @return boolean
     */
    protected function isThrottleExcluded(Exception $exception)
    {
        $dontThrottleList = config('laravel-email-exceptions.throttle_exclude');
        return $this->isInList($dontThrottleList, $exception);
    }

    /**
     * Check if the exception is in the dont email list
     *
     * @param Exception $exception
     * @return boolean
     */
    protected function isExcluded(Exception $exception)
    {
        $dontEmailList = config('laravel-email-exceptions.exclude');
        return $this->isInList($dontEmailList, $exception);
    }

    /**
     * @return \Illuminate\Contracts\Cache\Repository
     */
    protected function cache()
    {
        return Cache::store(config('laravel-email-exceptions.throttle_cache_driver'));
    }
}
