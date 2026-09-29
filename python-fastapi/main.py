from fastapi import FastAPI, HTTPException
from pydantic import BaseModel
import os
from sentinelauth import SentinelAuth, SentinelAuthError

app = FastAPI(title="SentinelAuth FastAPI Example")
client = SentinelAuth(os.environ.get("SENTINELAUTH_API_KEY", "sk_test_demo"))

# In-memory store (use Redis in production)
verifications = {}

class SendRequest(BaseModel):
    destination: str
    channel: str = "sms" # "sms" or "email"

class VerifyRequest(BaseModel):
    destination: str
    code: str

@app.post("/auth/send")
def send_code(req: SendRequest):
    try:
        res = client.send_otp(req.destination, channel=req.channel, app_name="FastAPI App")
        verifications[req.destination] = res.get("verification_id")
        return {"success": True, "message": "Code sent successfully"}
    except SentinelAuthError as e:
        raise HTTPException(status_code=e.status_code, detail=e.message)

@app.post("/auth/verify")
def verify_code(req: VerifyRequest):
    vid = verifications.get(req.destination)
    if not vid:
        raise HTTPException(status_code=400, detail="No pending verification found")
    try:
        res = client.verify_otp(vid, req.code)
        if res.get("verified"):
            del verifications[req.destination]
            return {"success": True, "message": "Verified! Access token granted."}
        raise HTTPException(status_code=400, detail="Invalid verification code")
    except SentinelAuthError as e:
        raise HTTPException(status_code=e.status_code, detail=e.message)
