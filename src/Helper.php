<?php

namespace Matteomeloni\LaravelRestQl;

class Helper
{
    /**
     * @param mixed $data
     * @param string $parameter
     * @return array|null
     */
    public static function retrieveData($data, string $parameter): ?array
    {
        $data = empty($data)
            ? Helper::getParameter($parameter)
            : $data;

        if (Helper::isBase64($data)) {
            $data = base64_decode($data);
        }

        if (Helper::isJson($data)) {
            $data = json_decode($data);
        }

        return $data;
    }

    /**
     * @param string $parameter
     * @return array|mixed|string|null
     */
    public static function getParameter(string $parameter)
    {
        return request()->$parameter ?? request()->header($parameter);
    }

    /**
     * Check if string is a json.
     *
     * @param $string
     * @return bool
     */
    public static function isJson($string): bool
    {
        return is_string($string) &&
            is_array(json_decode($string, true)) &&
            (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * Check if string is a base64.
     *
     * @param $string
     * @return bool
     */
    public static function isBase64($string): bool
    {
        if (!is_string($string)) {
            return false;
        }

        return (bool)preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $string);
    }
}
