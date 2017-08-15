<?php

if (! function_exists('dd')) {
    /**
     * Dump arguments and die.
     *
     * Useful for quick debugging.
     */
    function dd()
    {
        var_dump(...func_get_args());
        die();
    }
}
