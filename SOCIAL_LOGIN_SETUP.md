# Social Login Setup Guide

## การตั้งค่า Google OAuth

### 1. สร้าง Google OAuth Credentials

1. ไปที่ [Google Cloud Console](https://console.cloud.google.com/)
2. สร้าง Project ใหม่หรือเลือก Project ที่มีอยู่
3. ไปที่ **APIs & Services** > **Credentials**
4. คลิก **Create Credentials** > **OAuth client ID**
5. เลือก Application type: **Web application**
6. ตั้งค่า:
   - **Authorized JavaScript origins**: `http://localhost:3000`, `http://localhost:1880`
   - **Authorized redirect URIs**: `http://localhost:1880/api/auth/google/callback`
7. บันทึก Client ID และ Client Secret

### 2. เพิ่ม Google Credentials ใน Backend (.env)

เปิดไฟล์ `elearning-backend/.env` และเพิ่ม:

```env
# Google OAuth
GOOGLE_CLIENT_ID=your-google-client-id
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT_URL=http://localhost:1880/api/auth/google/callback
```

---

## การตั้งค่า Facebook OAuth

### 1. สร้าง Facebook App

1. ไปที่ [Facebook Developers](https://developers.facebook.com/)
2. คลิก **My Apps** > **Create App**
3. เลือก **Consumer** เป็น app type
4. กรอกข้อมูล App และสร้าง App
5. ไปที่ **Settings** > **Basic** เพื่อดู App ID และ App Secret
6. ไปที่ **Facebook Login** > **Settings**
7. เพิ่ม **Valid OAuth Redirect URIs**: `http://localhost:1880/api/auth/facebook/callback`

### 2. เพิ่ม Facebook Credentials ใน Backend (.env)

เปิดไฟล์ `elearning-backend/.env` และเพิ่ม:

```env
# Facebook OAuth
FACEBOOK_CLIENT_ID=your-facebook-app-id
FACEBOOK_CLIENT_SECRET=your-facebook-app-secret
FACEBOOK_REDIRECT_URL=http://localhost:1880/api/auth/facebook/callback
```

---

## การทดสอบ

1. Restart Backend server:
   ```bash
   docker-compose restart app
   ```

2. เปิด Frontend: `http://localhost:3000/login`

3. คลิกปุ่ม "เข้าสู่ระบบด้วย Google" หรือ "เข้าสู่ระบบด้วย Facebook"

4. ระบบจะเปิด popup สำหรับ authentication

5. หลังจาก login สำเร็จ ระบบจะ redirect ไปที่ Dashboard

---

## หมายเหตุสำคัญ

### Production Setup

เมื่อ deploy production ต้องอัพเดต URLs:

1. **Google Cloud Console**:
   - Authorized JavaScript origins: `https://yourdomain.com`
   - Authorized redirect URIs: `https://yourdomain.com/api/auth/google/callback`

2. **Facebook App**:
   - Valid OAuth Redirect URIs: `https://yourdomain.com/api/auth/facebook/callback`

3. **Backend .env**:
   ```env
   GOOGLE_REDIRECT_URL=https://yourdomain.com/api/auth/google/callback
   FACEBOOK_REDIRECT_URL=https://yourdomain.com/api/auth/facebook/callback
   APP_URL=https://yourdomain.com
   ```

### CORS Configuration

ตรวจสอบว่า CORS ใน Backend อนุญาตให้ Frontend domain เข้าถึง API ได้

### HTTPS Requirement

Facebook และ Google ต้องใช้ HTTPS สำหรับ production environment

---

## Troubleshooting

### ปัญหา: Popup ถูกบล็อก
- ตรวจสอบการตั้งค่า browser ให้อนุญาต popup
- ลอง disable popup blocker สำหรับ localhost

### ปัญหา: Redirect URI mismatch
- ตรวจสอบว่า URL ใน OAuth config ตรงกับ URL ที่ตั้งไว้ใน Backend

### ปัญหา: Invalid credentials
- ตรวจสอบว่าคัดลอก Client ID และ Secret ถูกต้อง
- ตรวจสอบว่า restart backend server แล้ว

### ปัญหา: Database error
- ตรวจสอบว่ารัน migration แล้ว: `docker exec elearning-backend php artisan migrate`

---

## ข้อมูลเพิ่มเติม

- [Laravel Socialite Documentation](https://laravel.com/docs/socialite)
- [Google OAuth 2.0 Documentation](https://developers.google.com/identity/protocols/oauth2)
- [Facebook Login Documentation](https://developers.facebook.com/docs/facebook-login)
