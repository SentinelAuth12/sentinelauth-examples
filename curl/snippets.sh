#!/usr/bin/env bash

# SentinelAuth cURL Reference Snippets

API_KEY="sk_live_your_api_key_here"
BASE_URL="https://sentinelauth.com.au/wp-json/sentinelauth/v1"

echo "=== 1. Send SMS OTP ==="
curl -X POST "$BASE_URL/send-otp" \
  -H "Authorization: Bearer $API_KEY" \
  -H "Content-Type: application/json" \
  -d '{
    "to": "+61412345678",
    "channel": "sms",
    "app_name": "Terminal Test"
  }'

echo -e "\n\n=== 2. Verify OTP ==="
curl -X POST "$BASE_URL/verify-otp" \
  -H "Authorization: Bearer $API_KEY" \
  -H "Content-Type: application/json" \
  -d '{
    "verification_id": "ver_sms_example_id",
    "code": "123456"
  }'

echo -e "\n\n=== 3. Enroll TOTP Factor (2FA Authenticator) ==="
curl -X POST "$BASE_URL/totp/enroll" \
  -H "Authorization: Bearer $API_KEY" \
  -H "Content-Type: application/json" \
  -d '{
    "user_identifier": "usr_terminal_99",
    "account_name": "developer@company.com",
    "issuer": "SentinelAuth cURL"
  }'

echo -e "\n\n=== 4. Check API Quota ==="
curl -X GET "$BASE_URL/quota" \
  -H "Authorization: Bearer $API_KEY"
