<?php

return [
    /**
     * Configure the ErrorEmail service
     *
     * - enabled (bool) - Enable or disable emailing of errors/exceptions
     *
     * - exclude (array) - An array of classes that should never be emailed
     *   even if they are thrown Ex: ['']
     *
     * - throttle (bool) - Enable or disable throttling of errors/exceptions
     *
     * - throttle_cache_driver (string) - The cache driver to use for throttling emails,
     *   uses cache driver from your env file labeled 'CACHE_DRIVER' by default
     *
     * - throttle_duration_minutes (int) - The duration of the throttle in minutes
     *   ex if you want to be emailed only once every 5 minutes about each unique
     *   exception type enter 5
     *
     * - dont_throttle (array) - An array of classes that should never be throttled
     *   even if they are thrown more than once within the normal throttling window
     *
     * - global_throttle (bool) - whether you want to globally throttle the number of emails
     *   you can receive of all exception types by this application
     *
     * - global_throttle_limit (int) - the maximum number of emails you would like to receive
     *   for a given duration
     *
     * - global_throttle_duration_minutes (int) - The duration of the global throttle in minutes
     *   ex if you want to receive a maximum of 20 emails in a given 30 minute time period
     *   enter 20 for the globalThrottleLimit and 30 for globalThrottleDurationMinutes
     *
     * - to_email_address (string|array) - The email address(es) to send these error emails to,
     *   typically the dev team for the website
     *
     * - from_email_address (string) - The email address these emails should be sent from
     *
     * - email_subject (string) - The subject of email, leave NULL to use default
     *   Default Subject: An Exception has been thrown on APP_URL APP_ENV
     *
     */
    'enabled' => env('EMAIL_EXCEPTIONS_ENABLED', true),
    'exclude' => [],
    'throttle' => env('EMAIL_EXCEPTIONS_THROTTLE', true),
    'throttle_cache_driver' => env('EMAIL_EXCEPTIONS_CACHE_DRIVER', env('CACHE_DRIVER', 'file')),
    'throttle_duration_minutes' => 5,
    'throttle_exclude' => [],
    'global_throttle' => env('EMAIL_EXCEPTIONS_GLOBAL_THROTTLE', true),
    'global_throttle_limit' => 20,
    'global_throttle_duration_minutes' => 30,
    'to_email_address' => env('EMAIL_EXCEPTIONS_TO', null),
    'from_email_address' => env('EMAIL_EXCEPTIONS_FROM', env('MAIL_FROM_ADDRESS', null)),
    'from_name' => env('EMAIL_EXCEPTIONS_FROM_NAME', env('MAIL_FROM_NAME', null)),
    'email_subject' => null,
    'show_environment' => true,
    'show_request' => true,
    'show_previous_exceptions' => true,
    'disable_on_debug' => true,
];
