<?php

namespace App\Http\Controllers;

use Image;

class ImageController extends Controller
{
    public static function uploadImageOrder($request, $id)
    {
        try {
            if ($request->hasFile('image_order')) {
                //filename to store
                $filenametostore = $id . '_order.png';
                //Upload File
                $request->file('image_order')->storeAs('public/order', $filenametostore);
                $request->file('image_order')->storeAs('public/order/thumbnail', $filenametostore);
                //Resize image here
                $thumbnailpath = public_path('storage/order/thumbnail/' . $filenametostore);
                $img = Image::make($thumbnailpath)->resize(400, 150, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($thumbnailpath);
            }
            return 200;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
