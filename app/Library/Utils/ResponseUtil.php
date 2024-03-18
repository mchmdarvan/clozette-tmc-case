<?php

namespace App\Library\Utils;

class ResponseUtil
{
    /**
     * Make success response
     *
     * @param string $message
     * @param mixed  $data
     *
     * @return array
     */
    public static function makeResponse($message, $data)
    {
        return [
            'message' => $message,
            'success' => true,
            'data'    => $data,
        ];
    }

    /**
     * Make success paginate response
     *
     * @param string $message
     * @param mixed  $data
     *
     * @return array
     */
    public static function makePaginateResponse($message, $response)
    {
        $pageData = [
            'total' => $response['total'],
            'per_page' => $response['per_page'],
            'current_page' => $response['current_page'],
        ];
        return [
            'message' => $message,
            'success' => true,
            'data'    => $response['data'],
            'page' => $pageData
        ];
    }

    /**
     * Make error response
     *
     * @param string $message
     * @param mixed  $data
     *
     * @return array
     */
    public static function makeError($message, $data = [])
    {
        $res = [
            'success' => false,
            'message' => $message,
        ];

        if (!empty($data)) {
            $res['data'] = $data;
        }

        return $res;
    }
}
