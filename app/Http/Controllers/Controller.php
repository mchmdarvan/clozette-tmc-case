<?php

namespace App\Http\Controllers;

use App\Library\Utils\ResponseUtil;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Send success response
     *
     * @param string $message
     * @param mixed $data
     * @param integer $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function response($responseData, string $message = '', $code = 200)
    {
        // array_key_exists untuk check key data apakah ada atau tidak untuk menentukan apakah pake paginate response atau tidak
        if ($responseData == null) {
            $res = ResponseUtil::makeResponse($message, $responseData);
        } else {
            $res = array_key_exists('data', $responseData) ?  ResponseUtil::makePaginateResponse($message, $responseData) :  ResponseUtil::makeResponse($message, $responseData);
        }
        return response()->json($res, $code);
    }


    /**
     * Send paginated response
     *
     * @param string $message
     * @param mixed $data
     * @param integer $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function paginate($data, string $message = '', $code = 200)
    {
        $data = $data->toArray();
        $data['success'] = true;
        $data['message'] = $message;

        return response()->json($data, 200);
    }

    /**
     * Create token response
     *
     * @param string $token
     * @return array
     */
    public function token($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL()
        ];
    }

    /**
     * Send error response
     *
     * @param string $message
     * @param integer $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function error($responseData, string $message = '', $code = 400)
    {
        $res = ResponseUtil::makeError($message, $responseData);

        return response()->json($res, $code);
    }
}
