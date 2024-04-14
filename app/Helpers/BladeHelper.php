<?php

if (!function_exists('example_func')) {
    function say_hello(string $yourName): string
    {
        return 'Guten Tag, ' . $yourName . '!!';
    }
}
