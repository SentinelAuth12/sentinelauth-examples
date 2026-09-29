const express = require('express');
const SentinelAuth = require('sentinelauth');

const app = express();
app.use(express.json());

const client = new SentinelAuth(process.env.SENTINELAUTH_API_KEY || 'sk_test_demo');

// In-memory session store (use Redis in production)
const sessions = new Map();

/**
 * Step 1: Send OTP to User's phone
 */
app.post('/api/auth/send-code', async (req, res) => {
  const { phone } = req.body;
  if (!phone) return res.status(400).json({ error: 'Phone number required' });

  try {
    const result = await client.sendSMS(phone, 'MyApp');
    sessions.set(phone, { verificationId: result.verification_id });
    return res.json({ success: true, message: 'OTP dispatched via SMS' });
  } catch (err) {
    return res.status(err.statusCode || 500).json({ error: err.message });
  }
});

/**
 * Step 2: Verify Submitted OTP Code
 */
app.post('/api/auth/verify-code', async (req, res) => {
  const { phone, code } = req.body;
  const session = sessions.get(phone);
  if (!session) return res.status(400).json({ error: 'No active session for this phone' });

  try {
    const result = await client.verifyOTP({
      verificationId: session.verificationId,
      code
    });

    if (result.verified) {
      sessions.delete(phone);
      return res.json({ success: true, message: 'Authentication successful! Session granted.' });
    }
    return res.status(400).json({ success: false, error: 'Invalid verification code' });
  } catch (err) {
    return res.status(err.statusCode || 500).json({ error: err.message });
  }
});

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => console.log(`SentinelAuth Express server running on port ${PORT}`));
