<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Transformers\Json;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($data  = NULL, $message = NULL, $code = 200)
    {
        // $response = [
        //     'success' => true
        // ];

        $response = $data;

        // if ($data) {
        //     $response['data'] = $data;
        // }
        if ($message) {
            $response['message'] = $message;
        }

        return response()->json($response, $code);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $code = 404) // , $errorMessages = []
    {
        $response = [
            // 'success' => false,
            'message' => $error
        ];

      // if(!empty($errorMessages)){
      //   $response['data'] = $errorMessages;
      // }
      // $response = Json::response($data, $message)

      return response()->json($response, $code);
    }
}
