<?php

namespace App\Shared;

use App\Models\Otp as ModelsOtp;
use Symfony\Component\HttpFoundation\Response;

class messageTransform
{
    public function __construct()
    {
        //
    }

    public function SqlParseError($message)
    {
        if (!is_array($message)) {
            $newMessage = [];
            if (strpos($message, 'SQLSTATE[23505]') !== false) {
                $newMessage['error'] = 'Duplicate key value violates unique constraint';
                $newMessage['code'] = Response::HTTP_FORBIDDEN;
                $newMessage['message'] = Response::$statusTexts[$newMessage['code']];
            }
            if (strpos($message, 'SQLSTATE[22007]') !== false) {
                $newMessage['error'] = 'Invalid datetime format';
                $newMessage['code'] = Response::HTTP_FORBIDDEN;
                $newMessage['message'] = Response::$statusTexts[$newMessage['code']];
            }
            if (strpos($message, 'SQLSTATE[22P02]') !== false) {
                $newMessage['error'] = 'Invalid text representation, integer cannot input text';
                $newMessage['code'] = Response::HTTP_FORBIDDEN;
                $newMessage['message'] = Response::$statusTexts[$newMessage['code']];
            }
            if (strpos($message, 'SQLSTATE[42601]') !== false) {
                $newMessage['error'] = 'Internal server error';
                $newMessage['code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
                $newMessage['message'] = Response::$statusTexts[$newMessage['code']];
            }
            if (strpos($message, 'SQLSTATE[23503]') !== false) {
                $newMessage['error'] = 'Internal server error';
                $newMessage['code'] = Response::HTTP_INTERNAL_SERVER_ERROR;
                $newMessage['message'] = Response::$statusTexts[$newMessage['code']];
            }

            if (count($newMessage) === 0) {
                return null;
            }

            return $newMessage;
        }

        return null;
    }
}
