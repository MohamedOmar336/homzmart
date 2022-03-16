<?php

use Illuminate\Support\Facades\File;

if (!function_exists('uploadImage')) {
    function uploadImage($upload, $path, $resize_width = null, $resize_height = null)
    {
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        $filename = rand() . time() . '.' . $upload->getClientOriginalExtension();
        // $filePath = 'dashboard/images/' . $path . '/' . $filename;
        $filePath = 'dashboard/images/newimgs/' . $filename;
        if ($resize_width && $resize_height) {
            $thumb = Image::make($upload)->resize($resize_width, $resize_height)->encode($upload->getClientOriginalExtension(), 100);
            $upload->move(public_path('images' . '/' . $path), '/' . $filename);
        } else {
            $upload->move(public_path('images' . '/' . $path), '/' . $filename);
        }
        curlImage(public_path('images' . '/' . $path) . '/' . $filename, '');
        return $filePath;
    }
}
if (!function_exists('ResponseJson')) {
    function ResponseJson($status, $message = "", $data = [], $error = [])
    {
        $response = [
            'code' => $status,
            'msg' => $message,
            'data' => (object)$data,
            'error' => (object)$error,
        ];
        if ($error) {
            $response['error'] = (object)$error;
        }
        return response()->json($response, $status);
    }
}