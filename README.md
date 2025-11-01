## ☁️ Resume Uploads with Laravel Cloud (S3 Integration)

To manage and process candidate resumes, **JobMatch** integrates **Laravel Cloud Storage** with an **S3-compatible bucket**.  
Uploaded resumes are securely stored and later processed by the **OpenAI API** to extract relevant information for job matching.

---

### 🧩 Installed Composer Packages
These packages enable Laravel to communicate with AWS-style cloud storage:

```bash
composer require aws/aws-sdk-php
composer require league/flysystem-aws-s3-v3
