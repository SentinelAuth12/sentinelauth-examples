<?php
/**
 * SentinelAuth Vanilla PHP 2FA / OTP Example
 */

$apiKey = getenv('SENTINELAUTH_API_KEY') ?: 'sk_test_demo';
$baseUrl = 'https://sentinelauth.com.au/wp-json/sentinelauth/v1';

function sentinelRequest($endpoint, $payload, $apiKey) {
    global $baseUrl;
    $ch = curl_init($baseUrl . $endpoint);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => json_encode($payload),
        CURLOPT_HTTPHEADER     => [
            "Authorization: Bearer $apiKey",
            "Content-Type: application/json",
            "Accept: application/json"
        ],
        CURLOPT_TIMEOUT        => 15
    ]);
    $res = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return [$httpCode, json_decode($res, true)];
}

// 1. Dispatch SMS OTP
echo "1. Dispatching SMS OTP...\n";
list($status, $sendResp) = sentinelRequest('/send-otp', [
    'to'       => '+61412345678',
    'channel'  => 'sms',
    'app_name' => 'PHP App'
], $apiKey);

echo "Status: $status\n";
print_r($sendResp);

if (!empty($sendResp['verification_id'])) {
    $verificationId = $sendResp['verification_id'];

    // 2. Verify Code
    echo "\n2. Verifying Code (simulated with 123456)...\n";
    list($vStatus, $vResp) = sentinelRequest('/verify-otp', [
        'verification_id' => $verificationId,
        'code'            => '123456'
    ], $apiKey);

    echo "Verification Status: $vStatus\n";
    print_r($vResp);
}
