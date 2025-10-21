<?php
// Ensure variables are always defined with fallback values
$pusherAppId       = env('PUSHER_APP_ID') ?: '--------------------';
$pusherAppKey      = env('PUSHER_APP_KEY') ?: '--------------------';
$pusherAppSecret   = env('PUSHER_APP_SECRET') ?: '--------------------';
$pusherAppCluster  = env('PUSHER_APP_CLUSTER') ?: 'mt1';

// Double check - set to empty string if still undefined
if (!isset($pusherAppId)) $pusherAppId = '';
if (!isset($pusherAppKey)) $pusherAppKey = '';
if (!isset($pusherAppSecret)) $pusherAppSecret = '';
if (!isset($pusherAppCluster)) $pusherAppCluster = 'mt1';
?>