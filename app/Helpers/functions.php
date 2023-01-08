<?php


if (! function_exists('ajax_error_message')) {
    function ajax_error_message($message = ''):string
    {
        return config('app.debug')?$message:__('common.errors.something_wrong');
    }
}
