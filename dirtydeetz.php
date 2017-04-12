<?php

/*
 * $username: instagram username
 * $password: instagram password
 * $image: path to the image. If the image is in the same directory as this script, just use the image file name
 * $caption: Caption for the post
 * $timezone: See https://en.wikipedia.org/wiki/List_of_tz_database_time_zones for comprehensive list of all time zones
 *
 * */

$username = '';
$password = '';
$image = 'deetz.jpg';
$caption = '';
$timezone = 'America/Los_Angeles';

/***************************/


$url = 'https://www.instagram.com/' . $username . '/media';
$account_data = json_decode(file_get_contents($url), true);

$current_time = new DateTime();
$current_time->setTimestamp(time());
date_timezone_set($current_time, timezone_open($timezone));

$creation_time = new DateTime();
$creation_time->setTimestamp($account_data['items'][0]['created_time']);
date_timezone_set($creation_time, timezone_open($timezone));

$current_day = $current_time->format('d');
$creation_day = $creation_time->format('d');

if ($current_day !== $creation_day) {
    PostPicture($username, $password, $image, $caption);
}

function SendRequest($url, $post, $data, $userAgent, $cookies)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://i.instagram.com/api/v1/' . $url);
    curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    
    if ($post) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    
    if ($cookies) {
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt');
    } else {
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
    }
    
    $response = curl_exec($ch);
    $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return [
        'code' => $http,
        'response' => $response,
    ];
}

function GenerateGuid()
{
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 65535),
        mt_rand(0, 65535),
        mt_rand(0, 65535),
        mt_rand(16384, 20479),
        mt_rand(32768, 49151),
        mt_rand(0, 65535),
        mt_rand(0, 65535),
        mt_rand(0, 65535));
}

function GenerateUserAgent()
{
    $resolutions = ['720x1280', '320x480', '480x800', '1024x768', '1280x720', '768x1024', '480x320'];
    $versions = ['GT-N7000', 'SM-N9000', 'GT-I9220', 'GT-I9100'];
    $dpis = ['120', '160', '320', '240'];
    
    $ver = $versions[array_rand($versions)];
    $dpi = $dpis[array_rand($dpis)];
    $res = $resolutions[array_rand($resolutions)];
    
    return 'Instagram 4.' . mt_rand(1, 2) . '.' . mt_rand(0, 2) . ' Android (' . mt_rand(10, 11) . '/' . mt_rand(1, 3) . '.' . mt_rand(3, 5) . '.' . mt_rand(0, 5) . '; ' . $dpi . '; ' . $res . '; samsung; ' . $ver . '; ' . $ver . '; smdkc210; en_US)';
}

function GenerateSignature($data)
{
    return hash_hmac('sha256', $data, 'b4a23f5e39b5929e0666ac5de94c89d1618a2916');
}

function GetPostData($filename)
{
    if (!$filename) {
        echo "The image doesn't exist " . $filename;
    } else {
        $data = [
            'device_timestamp' => time(),
            'photo' => new CURLFile($filename)
        ];
        return $data;
    }
}

function PostPicture($username, $password, $image, $caption)
{
    $agent = GenerateUserAgent();
    $guid = GenerateGuid();
    $device_id = "android-" . $guid;
    $data = '{"device_id":"' . $device_id . '","guid":"' . $guid . '","username":"' . $username . '","password":"' . $password . '","Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"}';
    $sig = GenerateSignature($data);
    $data = 'signed_body=' . $sig . '.' . urlencode($data) . '&ig_sig_key_version=4';
    SendRequest('accounts/login/', true, $data, $agent, false);
    $data = GetPostData($image);
    $post = SendRequest('media/upload/', true, $data, $agent, true);
    $obj = @json_decode($post['response'], true);
    $caption = preg_replace("/\r|\n/", "", $caption);
    $media_id = $obj['media_id'];
    $device_id = "android-" . $guid;
    $data = '{"device_id":"' . $device_id . '","guid":"' . $guid . '","media_id":"' . $media_id . '","caption":"' . trim($caption) . '","device_timestamp":"' . time() . '","source_type":"5","filter_type":"0","extra":"{}","Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"}';
    $sig = GenerateSignature($data);
    $new_data = 'signed_body=' . $sig . '.' . urlencode($data) . '&ig_sig_key_version=4';
    SendRequest('media/configure/', true, $new_data, $agent, true);
}
