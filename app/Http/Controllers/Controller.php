<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public static function json($json = [], $status_code = 200) {
        return response()->json($json, $status_code);
    }

    public static function message(string $message, $status_code = 200) {
        return response()->json([
            "message" => $message
        ], $status_code);
    }
}
