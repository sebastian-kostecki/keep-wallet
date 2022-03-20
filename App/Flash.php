<?php

namespace App;

class Flash
{
    const SUCCESS = 'success';
    const INFO = 'info';
    const DANGER = 'danger';

    public static function addMessage($message, $type = 'success')
    {
        if (!isset($_SESSION['flash_notifications'])) {
            $_SESSION['flash_notifications'] = [];
        }

        $_SESSION['flash_notifications'][] = [
            'body' => $message,
            'type' => $type
        ];
    }

    public static function getMessage()
    {
        if (isset($_SESSION['flash_notifications'])) {
            $messages = $_SESSION['flash_notifications'];
            unset($_SESSION['flash_notifications']);

            return $messages;
        }
    }
}
