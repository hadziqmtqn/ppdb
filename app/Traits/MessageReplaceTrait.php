<?php

namespace App\Traits;

trait MessageReplaceTrait
{
    /**
     * Replaces placeholders in a given message with corresponding values.
     *
     * @param string $message The message with placeholders.
     * @param array $placeholders An associative array of placeholders and their corresponding values.
     * @return string The message with placeholders replaced by their values.
     */
    protected function replacePlaceholders(string $message, array $placeholders): string
    {
        return str_replace(array_keys($placeholders), array_values($placeholders), $message);
    }
}
