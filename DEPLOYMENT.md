# راهنمای جامع استقرار در محیط پروداکشن (DirectAdmin Shared Hosting)
## Solmir — Production Deployment & Release Engineering Guide

این مستند راهنمای مرحله‌به‌مرحله و استاندارد برای استقرار وب‌سایت **سلمیر (Solmir)** بر پایه **Laravel 12 + Inertia.js + Vue 3 + Tailwind CSS v4** روی **هاست اشتراکی با کنترل‌پنل DirectAdmin** است.

---

## 📋 نیازمندی‌های هاست اشتراکی (System Requirements)

* **کنترل‌پنل:** DirectAdmin (با یا بدون دسترسی SSH)
* **وب‌سرور:** Apache یا LiteSpeed
* **نسخه PHP:** نسخه PHP 8.3 یا PHP 8.4 (توصیه‌شده: PHP 8.4)
* **پایگاه‌داده:** MySQL 8.0+ یا MariaDB 10.5+
* **گواهی امنیتی:** SSL رایگان (Let's Encrypt) فعال
* **اکستنشن‌های ضروری PHP:**
  `pdo_mysql` ، `mbstring` ، `openssl` ، `tokenizer` ، `xml` ، `ctype` ، `json` ، `bcmath` ، `curl` ، `fileinfo`
* **منابع حداقلی پیشنهادی:** ۱ گیگابایت رم، ۲ گیگابایت فضای دیسک

---

## 🏗️ معماری استقرار در DirectAdmin (Document Root Architecture)

> [!CAUTION]
> **قانون حیاتی امنیت:** به هیچ عنوان نباید کل پوشه پروژه لاراول داخل `public_html` قرار داده شود! دسترسی مستقیم مرورگر به فایل‌های `.env`، `storage/`، `vendor/` یا `database/` می‌تواند اطلاعات محرمانه دیتابیس را افشا کند.

### روش اول (روش پیشنهادی و استاندارد — Symbolic Link):
در این روش، کل سورس پروژه در یک پوشه امن خارج از وب‌روت (مثلاً `/home/USERNAME/solmir`) قرار می‌گیرد و پوشه `public_html` به پوشه `public` پروژه لینک می‌شود:

```text
/home/USERNAME/
├── solmir/                    <-- پوشه امن خارج از وب‌روت
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── public/                <-- محتویات عمومی و استاتیک
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   ├── vendor/
│   └── .env
└── domains/solmir.ir/
    └── public_html -> /home/USERNAME/solmir/public  (Symbolic Link)
```

### روش دوم (در صورت عدم امکان تغییر داکیومنت روت یا ایجاد Symlink):
اگر هاست اجازه Symlink دایرکتوری ندهد:
1. فایل‌ها و پوشه‌های اصلی لاراول را در `/home/USERNAME/solmir/` آپلود کنید.
2. محتویات داخل پوشه `public/` لاراول را مستقیماً داخل `/home/USERNAME/domains/solmir.ir/public_html/` قرار دهید.
3. در فایل `public_html/index.php`، مسیرهای زیر را به‌روزرسانی کنید:
   ```php
   // Register the Composer autoloader...
   require __DIR__.'/../../solmir/vendor/autoload.php';

   // Bootstrap Laravel and handle the request...
   /** @var Application $app */
   $app = require_once __DIR__.'/../../solmir/bootstrap/app.php';
   ```

---

## 🚀 مراحل ۱۵ گانه استقرار در پروداکشن (Step-by-Step Deployment)

### گام ۱: ساخت دیتابیس و کاربر در DirectAdmin
1. وارد DirectAdmin شده و به بخش **MySQL Management** بروید.
2. بر روی **Create New Database** کلیک کنید.
3. نام دیتابیس و نام کاربر (مثلاً `solmir_db` و `solmir_user`) را وارد کرده و یک رمز عبور فوق‌العاده قوی تعیین کنید.
4. انکودینگ دیتابیس باید به صورت پیش‌فرض `utf8mb4` با collation `utf8mb4_unicode_ci` باشد.

---

### گام ۲: تنظیم نسخه و اکستنشن‌های PHP
1. در DirectAdmin به بخش **Select PHP Version** بروید.
2. نسخه را روی **PHP 8.3** یا **8.4** تنظیم فرمایید.
3. در تب **Extensions**، فعال بودن اکستنشن‌های `pdo_mysql`، `mbstring`، `fileinfo`، `openssl`، `curl` و `bcmath` را بررسی کنید.
4. در تب **Options**، مقادیر زیر را در صورت نیاز ارتقا دهید:
   * `upload_max_filesize = 32M`
   * `post_max_size = 32M`
   * `memory_limit = 256M`
   * `max_execution_time = 120`

---

### گام ۳: کامپایل فرانت‌اند و دارایی‌های وب (Frontend Build)
چون روی هاست اشتراکی محیط Node.js و حافظه کافی برای اجرای Vite وجود ندارد، بیلد فرانت‌اند را روی سیستم لوکال یا پایپلاین CI/CD انجام دهید:
```bash
# در سیستم لوکال پروژه:
npm ci
npm run build
```
پوشه `public/build/` حاوی تمام کدهای کامپایل‌شده Vue، فایل‌های CSS و فونت‌های لوکال وزیرمتن (بدون هیچ وابستگی خارجی به CDN) خواهد بود.

---

### گام ۴: آپلود پروژه به سرور
1. پروژه را فشرده (ZIP) کنید (به جز پوشه‌های `node_modules`، `.git`، `tests`).
   * مطمئن شوید پوشه `public/build` و `vendor` در فایل فشرده موجود هستند یا از طریق Composer روی سرور نصب می‌شوند.
2. فایل فشرده را در دایرکتوری `/home/USERNAME/solmir/` آپلود کرده و اکسترکت نمایید.

---

### گام ۵: ایجاد و پیکربندی فایل `.env`
1. از فایل `.env.example` یک نسخه به نام `.env` در ریشه پروژه بسازید:
   ```bash
   cp .env.example .env
   ```
2. مقادیر اصلی را به شرح زیر تنظیم کنید:
   ```env
   APP_NAME="Solmir"
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://solmir.ir

   LOG_CHANNEL=stack
   LOG_LEVEL=warning

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=USERNAME_solmir_db
   DB_USERNAME=USERNAME_solmir_user
   DB_PASSWORD="your-strong-password-here"

   SESSION_DRIVER=database
   SESSION_LIFETIME=120

   CACHE_STORE=file
   QUEUE_CONNECTION=database

   FILESYSTEM_DISK=public

   MAIL_MAILER=smtp
   MAIL_HOST=mail.solmir.ir
   MAIL_PORT=587
   MAIL_USERNAME=solmirofc@gmail.com
   MAIL_PASSWORD="your-mail-password"
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS="solmirofc@gmail.com"
   MAIL_FROM_NAME="Solmir"

   APP_OG_IMAGE=
   ```
3. تولید کلید اختصاصی برنامه:
   ```bash
   php artisan key:generate --force
   ```

---

### گام ۶: نصب وابستگی‌های Composer (در صورت دسترسی به SSH)
اگر به ترمینال SSH هاست دسترسی دارید:
```bash
composer install --no-dev --optimize-autoloader
```
> *اگر به SSH دسترسی ندارید، کافیست پوشه `vendor` کامپایل‌شده لوکال با دستور بالا را همراه پروژه آپلود فرمایید.*

---

### گام ۷: اجرای مایگریشن‌های پایگاه‌داده
برای ساخت جداول سیستم بدون داده‌های آزمایشی:
```bash
php artisan migrate --force
```

> [!NOTE]
> برای ساخت اولین کاربر ادمین در محیط Production، یا از پنل سایت ثبت‌نام نموده و در جدول `users` مقدار فیلد `role` را به `admin` تغییر دهید، یا از طریق Tinker اجرا کنید:
> ```bash
> php artisan tinker --execute 'App\Models\User::create(["name" => "مدیر سیستم", "email" => "admin@solmir.ir", "password" => Hash::make("YourSecurePassword123!"), "role" => "admin"]);'
> ```

---

### گام ۸: ایجاد پیوند فضای ذخیره‌سازی (Storage Link)
برای در دسترس قرار گرفتن فایل‌های عمومی (کاور نمونه‌کارها):
```bash
php artisan storage:link
```
> *اگر دسترسی SSH ندارید، یک فایل اسکریپت موقت `symlink.php` در وب‌روت ایجاد کرده و پس از اجرا حذف کنید:*
> ```php
> <?php
> symlink('/home/USERNAME/solmir/storage/app/public', '/home/USERNAME/domains/solmir.ir/public_html/storage');
> echo "Storage link created successfully.";
> ```

---

### گام ۹: تنظیم سطوح دسترسی (Permissions)
سطوح دسترسی استاندارد لینوکس را بررسی کنید تا وب‌سرور اجازه نوشتن در کش و لاگ‌ها را داشته باشد:
* دایرکتوری‌ها: `755`
* فایل‌ها: `644`
* دایرکتوری‌های قابل نوشتن:
  ```bash
  chmod -R 775 storage bootstrap/cache
  ```
  *(هرگز از سطح دسترسی خطرناک 777 استفاده نکنید).*

---

### گام ۱۰: کش کردن کانفیگ‌ها و روت‌ها (Optimization)
برای به حداکثر رساندن سرعت پاسخگویی سرور:
```bash
php artisan optimize
```
این دستور کانفیگ‌ها، روت‌ها و ویوها را کش می‌کند.
> *جهت پاکسازی کش‌ها در زمان انتشار آپدیت‌های بعدی:*
> ```bash
> php artisan optimize:clear
> ```

---

### گام ۱۱: تنظیم وظایف زمان‌بندی‌شده (Cron Job)
در کنترل‌پنل DirectAdmin به بخش **Cron Jobs** رفته و جاب زیر را برای اجرای هر دقیقه تنظیم کنید:
```bash
* * * * * cd /home/USERNAME/solmir && php artisan schedule:run >> /dev/null 2>&1
```
*این تسک به طور خودکار جاب‌های صف دیتابیس (`queue:work --stop-when-empty`) را بدون نیاز به دیمن یا Supervisor پردازش می‌کند.*

---

### گام ۱۲: فعال‌سازی SSL (HTTPS اجباری)
1. در DirectAdmin به بخش **SSL Certificates** بروید.
2. گزینه **Free & automatic certificate from Let's Encrypt** را انتخاب و دامنه `solmir.ir` و `www.solmir.ir` را تیک بزنید.
3. در بخش **Domain Setup** گزینه **Force SSL with https redirect** را فعال کنید.

---

### گام ۱۳: بررسی وضعیت سلامت (Health Check)
آدرس زیر را در مرورگر فراخوانی کنید:
```text
https://solmir.ir/health
```
باید پاسخ JSON با کد وضعیت HTTP 200 دریافت شود:
```json
{
  "status": "healthy",
  "application": "Solmir",
  "database": "ok",
  "timestamp": "2026-09-25T15:00:00+00:00"
}
```

---

### گام ۱۴: چک‌لیست تست نهایی در Production (Smoke Test)

پس از بالا آمدن سایت، موارد زیر را یک‌به‌یک بررسی کنید:

- [ ] صفحه اصلی بدون خطای کنسول و با فونت وزیرمتن لوکال بارگذاری می‌شود (`https://solmir.ir/`).
- [ ] اتصال کاملاً روی پروتکل امن HTTPS است و خطای Mixed Content وجود ندارد.
- [ ] صفحه ورود (`/login`) و ثبت‌نام کاربر جدید (`/register`) با موفقیت عمل می‌کنند.
- [ ] فرایند بازیابی رمز عبور (`/forgot-password`) ایمیل حاوی توکن ارسال می‌کند.
- [ ] پنل کاربری مشتری (`/dashboard`) و ویرایش مشخصات پروفایل (`/dashboard/profile`) بدون باگ باز می‌شوند.
- [ ] ثبت سفارش پروژه جدید همراه با آپلود فایل پیوست با موفقیت انجام می‌شود.
- [ ] دانلود فایل‌های پیوست سفارش دارای Authorization است (کاربر دیگر دسترسی ندارد).
- [ ] ایجاد تیکت پشتیبانی و ارسال پاسخ در تیکت فعال تست شد.
- [ ] ورود به پنل ادمین (`/admin`) و عملیات‌های CRUD خدمات و نمونه‌کارها بررسی شد.
- [ ] یادداشت‌های محرمانه ادمین (`admin_notes`) برای مشتری فاش نمی‌شوند.
- [ ] فرم تماس با ما (`/contact`) با اعمال Rate Limiting پیام‌ها را ثبت می‌کند.
- [ ] نقشه سایت (`https://solmir.ir/sitemap.xml`) خروجی معتبر XML دارد و صفحات ادمین/خصوصی در آن نیستند.
- [ ] فایل `https://solmir.ir/robots.txt` بخش‌های خصوصی را بلاک کرده است.
- [ ] صفحه خطای اختصاصی ۴۰۴ برای صفحات ناموجود نمایش داده می‌شود.
- [ ] اندپوینت سلامت سیستم وضعیت `healthy` با کد 200 بازمی‌گرداند.

---

### گام ۱۵: استراتژی پشتیبان‌گیری و بازیابی (Backup & Disaster Recovery)

#### ۱. پشتیبان‌گیری پایگاه‌داده (Database Backup):
* در DirectAdmin از ابزار **Create/Restore Backups** استفاده نمایید تا به صورت هفتگی از کل اکانت و دیتابیس بکاپ گرفته شود.
* همچنین می‌توانید دستور زیر را در یک Cron هفتگی قرار دهید:
  ```bash
  mysqldump -u USERNAME_solmir_user -p'PASSWORD' USERNAME_solmir_db > /home/USERNAME/backups/db_$(date +\%F).sql
  ```

#### ۲. پشتیبان‌گیری از فایل‌های آپلودی کاربران:
* از مسیر `/home/USERNAME/solmir/storage/app/public` و `/home/USERNAME/solmir/storage/app/order_attachments` به صورت دوره‌ای نسخه پشتیبان تهیه کنید.

#### ۳. نگهداری امن فایل `.env`:
* یک نسخه امن از فایل `.env` را در مخزن رمزگذاری‌شده خارج از هاست نگهداری فرمایید.

#### ۴. روش بازیابی سریع (Recovery Procedure):
1. دیتابیس جدید ساخته و فایل SQL را ایمپورت کنید:
   ```bash
   mysql -u USERNAME_solmir_user -p USERNAME_solmir_db < backup.sql
   ```
2. فایل‌های آپلود شده را به مسیر `storage/` بازگردانید.
3. فایل `.env` را بازیابی کرده و دستور `php artisan optimize` را اجرا کنید.

---

## 🔒 مدیریت لاگ‌ها (Logging in Production)

* لاگ‌های سیستم در فایل `storage/logs/laravel.log` ذخیره می‌شوند.
* در فایل `.env` تنظیم `LOG_LEVEL=warning` قرار داده شده تا تنها خطاها و هشدارهای مهم ثبت شوند و دیسک هاست پر نشود.
* اطلاعات حساس نظیر رمزهای عبور کاربران، اطلاعات کارت‌ها یا Secretها به هیچ عنوان لاگ نمی‌شوند.
* در صورت نیاز به بررسی لحظه‌ای خطاهای سرور، فایل `storage/logs/laravel.log` را از طریق File Manager کنترل‌پنل بررسی نمایید.
