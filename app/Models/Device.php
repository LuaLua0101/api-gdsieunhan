<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class Device extends Model
{
    protected $table = "devices";

    public static function getToken($userId)
    {
        $device = DB::table('devices')
            ->where('user_id', $userId)->first();
        return $device ? $device->fcm : null;
    }

    public static function updateFcm($user_id, $fcm)
    {
        if (DB::table('devices')
            ->where('user_id', $user_id)->first()) {
            return DB::table('devices')
                ->where('user_id', $user_id)
                ->update(['fcm' => $fcm]);
        } else {
            return DB::table('devices')->insertGetId(
                ['user_id' => $user_id, 'fcm' => $fcm]
            );
        }

    }

    public static function sendMsgToDevice($token, $title, $body, $data = [])
    {
        try {
            $optionBuilder = new OptionsBuilder();
            $optionBuilder->setTimeToLive(60 * 20);

            $notificationBuilder = new PayloadNotificationBuilder($title);
            $notificationBuilder->setBody($body)
                ->setSound('default');

            $dataBuilder = new PayloadDataBuilder();
            $dataBuilder->addData(['payload' => $data]);

            $option = $optionBuilder->build();
            $notification = $notificationBuilder->build();
            $data = $dataBuilder->build();
            $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

            $downstreamResponse->numberSuccess();
            $downstreamResponse->numberFailure();
            $downstreamResponse->numberModification();

            //return Array - you must remove all this tokens in your database
            $downstreamResponse->tokensToDelete();

            //return Array (key : oldToken, value : new token - you must change the token in your database )
            $downstreamResponse->tokensToModify();

            //return Array - you should try to resend the message to the tokens in the array
            $downstreamResponse->tokensToRetry();
            return true;

            // return Array (key:token, value:errror) - in production you should remove from your database the tokens
        } catch (\Exception $exception) {
            dd($exception);
            logger(['service' => 'FCM Notification', 'content' => $exception->getMessage()]);
            return false;
        }

    }
}
