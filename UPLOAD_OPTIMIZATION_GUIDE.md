# การแก้ปัญหาการอัปโหลดและเผยแพร่ช้า

## สาเหตุของปัญหา
การอัปโหลดไฟล์วิดีโอใช้เวลานานเพราะระบบรอให้การประมวลผล (transcoding) วิดีโอเสร็จก่อน ซึ่งทำให้ผู้ใช้ต้องรอนานมาก

## การแก้ไขที่ทำ

### 1. Frontend Improvements (Nuxt.js)

#### เพิ่ม Progress Bar
- แสดงความคืบหน้าการอัปโหลดแบบเรียลไทม์
- แสดงขนาดไฟล์ที่อัปโหลดแล้ว/ทั้งหมด
- แสดงเปอร์เซ็นต์ความคืบหน้า

#### ปรับปรุง UX
- ตอบสนองทันทีเมื่อเริ่มอัปโหลด
- ลดเวลารอหน้าเปลี่ยนหน้าจาก 2 วินาที เหลือ 1.5 วินาที
- แสดงข้อความว่าระบบกำลังประมวลผลในเบื้องหลัง

### 2. Backend Improvements (Laravel)

#### เปลี่ยน Queue System
- เปลี่ยนจาก `sync` (ประมวลผลทันที) เป็น `database` (ประมวลผลแยกต่างหาก)
- การประมวลผลวิดีโอจะทำงานในเบื้องหลัง ไม่บล็อกการอัปโหลด

## ขั้นตอนการติดตั้ง

### 1. Run Migration สำหรับ Jobs Table

```bash
cd elearning-backend
php artisan migrate
```

หรือถ้าใช้ Docker:

```bash
docker-compose exec app php artisan migrate
```

### 2. เริ่ม Queue Worker

เปิด Terminal แยกต่างหากและรันคำสั่ง:

```bash
# แบบปกติ
php artisan queue:work

# หรือใช้ Docker
docker-compose exec app php artisan queue:work

# หรือรันในพื้นหลัง (Linux/Mac)
nohup php artisan queue:work > storage/logs/queue.log 2>&1 &

# หรือใช้ Supervisor (แนะนำสำหรับ Production)
```

### 3. ตรวจสอบการทำงาน

#### ดู Logs
```bash
# Laravel logs
tail -f elearning-backend/storage/logs/laravel.log

# Queue logs (ถ้าใช้ nohup)
tail -f elearning-backend/storage/logs/queue.log
```

#### ดู Jobs ใน Database
```sql
SELECT * FROM jobs;
SELECT * FROM failed_jobs;
```

## Configuration Files ที่เปลี่ยนแปลง

### 1. `elearning-backend/.env`
```env
QUEUE_CONNECTION=database  # เปลี่ยนจาก sync
```

### 2. `elearning-frontend/app/composables/useMedia.ts`
- เพิ่มฟังก์ชัน `uploadMediaWithProgress()` ที่ใช้ XMLHttpRequest
- รองรับ progress callback

### 3. `elearning-frontend/app/components/MediaUploadForm.vue`
- เพิ่ม progress bar UI
- เพิ่ม progress tracking state
- ปรับปรุง UX messages

### 4. `elearning-backend/database/migrations/2026_02_23_000001_create_jobs_table.php`
- สร้างตาราง `jobs`, `job_batches`, `failed_jobs`

## การทำงานของระบบหลังแก้ไข

### ก่อนแก้ไข:
```
1. User อัปโหลดไฟล์
2. Server รับไฟล์
3. Server บันทึกไฟล์
4. Server ประมวลผลวิดีโอ (ใช้เวลานาน!) ⏳
5. Server ตอบกลับ
6. Redirect ไปหน้าอื่น
```

### หลังแก้ไข:
```
1. User อัปโหลดไฟล์ (เห็น progress bar) 📊
2. Server รับไฟล์
3. Server บันทึกไฟล์
4. Server ใส่งานประมวลผลเข้า Queue ✅
5. Server ตอบกลับทันที (เร็ว!) ⚡
6. Redirect ไปหน้าอื่น
7. Queue Worker ประมวลผลวิดีโอในพื้นหลัง 🔄
```

## Production Setup

### สำหรับ Production ควรใช้ Supervisor

#### ติดตั้ง Supervisor
```bash
sudo apt-get install supervisor
```

#### สร้างไฟล์ Configuration
`/etc/supervisor/conf.d/laravel-worker.conf`:

```ini
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/elearning-backend/artisan queue:work database --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/path/to/elearning-backend/storage/logs/worker.log
stopwaitsecs=3600
```

#### เริ่ม Supervisor
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-worker:*
```

## Monitoring

### ตรวจสอบ Jobs
```bash
# ดู pending jobs
php artisan queue:monitor

# ดู failed jobs
php artisan queue:failed

# Retry failed จobs
php artisan queue:retry all

# Clear failed jobs
php artisan queue:flush
```

### ตรวจสอบ Queue Worker
```bash
# ใช้ Supervisor
sudo supervisorctl status laravel-worker:*

# หรือตรวจสอบ process
ps aux | grep "queue:work"
```

## Troubleshooting

### ปัญหา: Queue Worker หยุดทำงาน
```bash
# Restart worker
sudo supervisorctl restart laravel-worker:*
```

### ปัญหา: Jobs ไม่ทำงาน
1. ตรวจสอบว่า QUEUE_CONNECTION=database ใน .env
2. ตรวจสอบว่า queue worker กำลังทำงานอยู่
3. ตรวจสอบ logs: `storage/logs/laravel.log`

### ปัญหา: Progress Bar ไม่แสดง
1. ตรวจสอบ Console ใน Browser (F12)
2. ตรวจสอบว่าฟังก์ชัน `uploadMediaWithProgress` ถูกเรียกใช้
3. ตรวจสอบ Network tab ว่ามีการอัปโหลดหรือไม่

## Performance Tips

1. **เพิ่มจำนวน Worker**: แก้ `numprocs` ใน supervisor config
2. **ใช้ Redis Queue**: เร็วกว่า database queue
3. **เพิ่ม Timeout**: แก้ `max_execution_time` ใน php.ini
4. **Chunked Upload**: สำหรับไฟล์ขนาดใหญ่มาก (>1GB)

## Redis Queue (Optional - แนะนำ)

### ติดตั้ง Redis Extension
```bash
pecl install redis
```

### แก้ไข .env
```env
QUEUE_CONNECTION=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### ปรับ Queue Config
`config/queue.php`:
```php
'default' => env('QUEUE_CONNECTION', 'redis'),
```

## Test Upload

1. เปิด Browser ไปที่ `/teacher/upload-media`
2. เลือกไฟล์วิดีโอขนาดใหญ่ (เช่น 100MB+)
3. กรอกข้อมูลและกดเผยแพร่
4. สังเกต:
   - Progress bar แสดงความคืบหน้า
   - หน้าเปลี่ยนเร็วหลังอัปโหลดเสร็จ
   - ไม่ต้องรอการประมวลผลวิดีโอ
5. ตรวจสอบ `/teacher/media` ว่าไฟล์ถูกสร้างแล้ว
6. รอสักครู่และ refresh เพื่อดูคุณภาพวิดีโอที่ประมวลผลแล้ว

## สรุป

การแก้ไขนี้จะทำให้:
- ✅ อัปโหลดเร็วขึ้น (ไม่รอการประมวลผล)
- ✅ UX ดีขึ้น (มี progress bar)
- ✅ Server responsive (ไม่ค้างตอน transcode)
- ✅ Scale ได้ดีขึ้น (เพิ่ม worker ได้)
