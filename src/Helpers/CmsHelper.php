<?php

namespace Sinevia\Cms\Helpers;

class CmsHelper {

    public static function auth($message = '', $data = []) {
        return json_encode(['status' => 'authenticate', 'message' => $message]);
    }

    public static function error($message = '', $data = []) {
        return json_encode(['status' => 'error', 'message' => $message, 'data' => $data]);
    }

    public static function success($message = '', $data = []) {
        return json_encode(['status' => 'success', 'message' => $message, 'data' => $data]);
    }

}
