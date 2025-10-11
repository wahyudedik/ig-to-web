<?php

use App\Helpers\NotificationHelper;
use App\Models\User;

if (!function_exists('notify')) {
    /**
     * Send notification to user(s)
     * 
     * @param User|array $users
     * @param string $title
     * @param string $message
     * @param string $type
     * @return void
     */
    function notify($users, string $title, string $message, string $type = 'info', array $metadata = [])
    {
        NotificationHelper::send($users, $title, $message, $type, $metadata);
    }
}
