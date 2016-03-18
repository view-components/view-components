<?php

namespace ViewComponents\ViewComponents\Common;

use RuntimeException;

class UriFunctions
{
    /**
     * Modifies query string and returns updated request part of the URI.
     *
     * @param string|null $uri
     * @param array $newQueryParams
     * @return string
     */
    public static function modifyQuery($uri, array $newQueryParams)
    {
        if ($uri === null) {
            $uri = static::getCurrentRequestUri();
        }

        $query = parse_url($uri, PHP_URL_QUERY);

        $queryParams = [];
        parse_str($query, $queryParams);

        $newQuery = http_build_query(array_merge($queryParams, $newQueryParams));

        $fragment = parse_url($uri, PHP_URL_FRAGMENT);
        return parse_url($uri, PHP_URL_PATH)
        . ($newQuery ? '?' . $newQuery : '')
        . ($fragment ? '#' . $fragment : '');
    }

    /**
     * Replaces fragment part and return updated request part of the URI.
     *
     * @param string|null $uri
     * @param string $newFragment
     * @return string
     */
    public static function replaceFragment($uri, $newFragment = '')
    {
        if ($uri === null) {
            $uri = static::getCurrentRequestUri();
        }
        $oldFragment = parse_url($uri, PHP_URL_FRAGMENT);
        return $oldFragment
            ? str_replace('#' . $oldFragment, '#' . $newFragment, $uri)
            : ($newFragment ? $uri . '#' . $newFragment : $uri);
    }

    /**
     * Returns current request URI.
     *
     * @return string
     */
    public static function getCurrentRequestUri()
    {
        if (empty($_SERVER['REQUEST_URI'])) {
            throw new RuntimeException('Can\'t resolve current URI');
        }
        return $_SERVER['REQUEST_URI'];
    }
}
