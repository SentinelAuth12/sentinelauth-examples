# SentinelAuth Integration Examples

Official repository containing ready-to-run examples and starter projects for **[SentinelAuth](https://sentinelauth.com.au)** — Developer-first Two-Factor Authentication (2FA), Multi-Factor Authentication (MFA), SMS OTP, Email Verification, and TOTP Authenticator.

[![Website](https://img.shields.io/badge/website-sentinelauth.com.au-blue)](https://sentinelauth.com.au)
[![Documentation](https://img.shields.io/badge/docs-sentinelauth.com.au%2Fdocs-purple)](https://sentinelauth.com.au/docs/)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

---

## Available Examples

| Directory | Technology | Description |
| :--- | :--- | :--- |
| **[`nodejs-express/`](./nodejs-express)** | Node.js + Express.js | Complete backend server with SMS OTP dispatch, session management, and verification endpoints. |
| **[`python-fastapi/`](./python-fastapi)** | Python + FastAPI | REST API endpoints for dispatching and verifying SMS/Email OTP codes. |
| **[`php-vanilla/`](./php-vanilla)** | Vanilla PHP | Simple procedural script sending and verifying OTP via cURL with zero framework dependencies. |
| **[`curl/`](./curl)** | Bash / cURL | Pure command-line cURL snippets for all primary API endpoints (`/send-otp`, `/verify-otp`, `/totp/enroll`, `/quota`). |

---

## Getting Your API Key

1. Create a free account at **[SentinelAuth](https://sentinelauth.com.au/register/?plan=sandbox)**.
2. Go to **[Dashboard > API Keys](https://sentinelauth.com.au/dashboard/api-keys/)** to copy your secret key (`sk_live_...` or `sk_test_...`).
3. Set your environment variable:
   ```bash
   export SENTINELAUTH_API_KEY="sk_live_your_key_here"
   ```

---

## Official SDKs

- **Node.js:** [`github.com/SentinelAuth12/sentinelauth-node-sdk`](https://github.com/SentinelAuth12/sentinelauth-node-sdk)
- **Python:** [`github.com/SentinelAuth12/sentinelauth-python-sdk`](https://github.com/SentinelAuth12/sentinelauth-python-sdk)

---

## Documentation

Full interactive documentation, rate limit guidelines, and error codes:  
👉 **[https://sentinelauth.com.au/docs/](https://sentinelauth.com.au/docs/)**

---

## License

MIT License © 2026 SentinelAuth.
