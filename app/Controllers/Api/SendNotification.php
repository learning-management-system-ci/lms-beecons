<?php

use App\Models\Notification;
use App\Models\UserNotification;

function SendNotification($public, $userId, $message)
{
    $notificationModel = new Notification();
    $userNotif = new UserNotification();

    if ($public == 1) {
        $notificationModel->insert([
            'public' => $public,
            'message' => $message,
        ]);

        $response = [
            'status'   => 201,
            'success'    => 201,
            'messages' => [
                'success' => 'Notification public berhasil dibuat'
            ]
        ];

        return $response;
    } else {
        $notificationModel->insert([
            'public' => $public,
            'message' => $message,
        ]);

        $userNotif->insert([
            'user_id' => $userId,
            'notification_id' => $notificationModel->getInsertID(),
            'read' => 1,
        ]);

        $response = [
            'status'   => 201,
            'success'    => 201,
            'messages' => [
                'success' => 'Notification berhasil dibuat'
            ]
        ];

        return $response;
    }
};
