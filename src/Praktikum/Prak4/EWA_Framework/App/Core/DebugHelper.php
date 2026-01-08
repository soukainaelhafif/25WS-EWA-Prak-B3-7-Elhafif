<?php

class DebugHelper
{

    public function __construct()
    {
        // Enable reporting of all PHP errors, warnings, and notices — useful during development for debugging.
        error_reporting(E_ALL);
    }
    
    /**
     * Debug helper method to nicely output variables.
     * Usage: dump($var) — outputs a formatted var_dump() for easier reading.
     * Require: require_once 'App/Core/DebugHelper.php';
     *
     * @param mixed $var Variable to dump
     * @return void
     */
    public static function dump(mixed $var): void
    {
        echo '<pre style="background:#1e1e1e; color:#00ff00; padding:10px; font-family:monospace; font-size:14px;">';
        var_dump($var);
        echo '</pre>';
    }
}

// Shortcut: allows calling dump($var) instead of DebugHelper::dump($var)
if (!function_exists('dump')) {
    function dump(...$vars): void {
        foreach ($vars as $var) {
            DebugHelper::dump($var);
        }
    }
}