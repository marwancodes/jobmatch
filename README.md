# ☁️ Resume Uploads with Laravel Cloud (S3 Integration)

To manage and process candidate resumes, **JobMatch** integrates **Laravel Cloud Storage** with an **S3-compatible bucket**.  
Uploaded resumes are securely stored and later processed by the **OpenAI API** to extract relevant information for job matching.

---

## 🧩 Installed Composer Packages
These packages enable Laravel to communicate with AWS-style cloud storage:

```bash
composer require aws/aws-sdk-php
composer require league/flysystem-aws-s3-v3
```

---

## ⚙️ Environment Configuration (`.env`)
Laravel normally uses these variables by default:
```env
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false
```

In **JobMatch**, I renamed and extended them for better clarity and flexibility 👇

```env
LARAVEL_CLOUD_ACCESS_KEY_ID=
LARAVEL_CLOUD_SECRET_ACCESS_KEY=
LARAVEL_CLOUD_DEFAULT_REGION=us-east-1
LARAVEL_CLOUD_BUCKET=
LARAVEL_CLOUD_ENDPOINT=
LARAVEL_CLOUD_URL=
LARAVEL_CLOUD_USE_PATH_STYLE_ENDPOINT=false
```

> 💡 *Tip:*  
> The extra variables `LARAVEL_CLOUD_ENDPOINT` and `LARAVEL_CLOUD_URL` make it easy to use **custom S3-compatible services** such as DigitalOcean Spaces, Wasabi, or MinIO.

---

## 🗂️ Configuration in `config/filesystems.php`
I also renamed the default `'s3'` disk to `'cloud'` and updated the keys accordingly:

```php
'disks' => [
    'cloud' => [
        'driver' => 's3',
        'key' => env('LARAVEL_CLOUD_ACCESS_KEY_ID'),
        'secret' => env('LARAVEL_CLOUD_SECRET_ACCESS_KEY'),
        'region' => env('LARAVEL_CLOUD_DEFAULT_REGION'),
        'bucket' => env('LARAVEL_CLOUD_BUCKET'),
        'endpoint' => env('LARAVEL_CLOUD_ENDPOINT'),
        'url' => env('LARAVEL_CLOUD_URL'),
        'use_path_style_endpoint' => env('LARAVEL_CLOUD_USE_PATH_STYLE_ENDPOINT', false),
    ],
],
```

---

## 🚀 How It Works
1. When a user uploads a resume, it’s stored in the configured **cloud storage**.  
2. Laravel’s filesystem handles the file upload and secure storage.  
3. The stored resume file is then **fetched by the OpenAI API** for parsing, keyword extraction, and smart job matching.  
4. Results are displayed directly in the JobMatch dashboard.

---

## 🔐 Security Notes
- Uploaded files are stored using **secure, signed URLs**.  
- Only authenticated users and server processes can access resumes.  
- `.env` credentials should **never** be committed to version control.

---

## 🧠 Summary

| Feature | Description |
|----------|--------------|
| Storage Driver | Laravel Cloud (S3-compatible) |
| Packages | `aws/aws-sdk-php`, `league/flysystem-aws-s3-v3` |
| Integration | OpenAI API for resume parsing |
| Custom Disk | `cloud` (renamed from `s3`) |
| Environment Prefix | `LARAVEL_CLOUD_` |
