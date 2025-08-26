# حملة ال1000 سفينة - نظام استطلاع الرأي

## نظرة عامة
تم إنشاء نظام حملة ال1000 سفينة كجزء من منصة Walls Must لدعم القضية الفلسطينية. يتيح النظام للمستخدمين المشاركة في استطلاع رأي حول القضية الفلسطينية.

## الميزات الرئيسية

### للمستخدمين:
- نموذج استطلاع رأي شامل
- 5 أسئلة مخصصة حول القضية الفلسطينية
- حقول اختيارية للواتساب والبريد الإلكتروني
- تصميم متجاوب يعمل على جميع الأجهزة
- دعم اللغتين العربية والإنجليزية

### للأدمن:
- لوحة تحكم لإدارة الاستطلاعات
- عرض تفاصيل كل مشارك
- تصدير البيانات إلى ملف Excel
- حذف متعدد للاستطلاعات
- إحصائيات شاملة

## الأسئلة المطروحة

1. **ما رأيك في أهمية دعم القضية الفلسطينية؟**
2. **كيف يمكن للعالم العربي والإسلامي المساهمة في دعم أهل غزة؟**
3. **ما هي أفضل الطرق لنشر الوعي حول القضية الفلسطينية؟**
4. **كيف يمكن تحسين الوضع الإنساني في غزة؟**
5. **ما هي رسالتك للعالم حول القضية الفلسطينية؟**

## الملفات المطلوبة

### النماذج (Models):
- `app/Models/ShipCampaignSurvey.php`

### الكونترولرز (Controllers):
- `app/Http/Controllers/ShipCampaignController.php`
- `app/Http/Controllers/Admin/AdminShipCampaignController.php`

### ملفات الهجرة (Migrations):
- `database/migrations/2025_08_25_180127_create_ship_campaign_surveys_table.php`

### الصفحات (Views):
- `resources/views/ship-campaign/show.blade.php`
- `resources/views/admin/ship-campaign/index.blade.php`
- `resources/views/admin/ship-campaign/show.blade.php`

### ملفات اللغة:
- `resources/lang/ar/app.php` (العربية)
- `resources/lang/en/app.php` (الإنجليزية)

## المسارات (Routes)

### للمستخدمين:
- `GET /en/ship-campaign` - صفحة الحملة باللغة الإنجليزية
- `GET /ar/ship-campaign` - صفحة الحملة باللغة العربية
- `POST /en/ship-campaign` - إرسال الاستطلاع باللغة الإنجليزية
- `POST /ar/ship-campaign` - إرسال الاستطلاع باللغة العربية

### للأدمن:
- `GET /admin-portal-walls-must/ship-campaign` - قائمة الاستطلاعات
- `GET /admin-portal-walls-must/ship-campaign/{id}` - عرض تفاصيل الاستطلاع
- `DELETE /admin-portal-walls-must/ship-campaign/{id}` - حذف الاستطلاع
- `GET /admin-portal-walls-must/ship-campaign/export/excel` - تصدير إلى Excel
- `POST /admin-portal-walls-must/ship-campaign/bulk-delete` - حذف متعدد

## قاعدة البيانات

### جدول `ship_campaign_surveys`:
- `id` - المعرف الفريد
- `first_name` - الاسم الأول
- `last_name` - الاسم الأخير
- `whatsapp_number` - رقم الواتساب (اختياري)
- `email` - البريد الإلكتروني (اختياري)
- `age` - العمر
- `question1_answer` - إجابة السؤال الأول
- `question2_answer` - إجابة السؤال الثاني
- `question3_answer` - إجابة السؤال الثالث
- `question4_answer` - إجابة السؤال الرابع
- `question5_answer` - إجابة السؤال الخامس
- `created_at` - تاريخ الإنشاء
- `updated_at` - تاريخ التحديث

## التثبيت والإعداد

### 1. تثبيت المكتبات المطلوبة:
```bash
composer require phpoffice/phpspreadsheet
```

### 2. تشغيل الهجرة:
```bash
php artisan migrate
```

### 3. التأكد من إعداد قاعدة البيانات في ملف `.env`

## الاستخدام

### للمستخدمين:
1. زيارة صفحة الحملة `/en/ship-campaign` أو `/ar/ship-campaign`
2. ملء النموذج بالمعلومات المطلوبة
3. الإجابة على الأسئلة الخمسة
4. إرسال الاستطلاع

### للأدمن:
1. تسجيل الدخول إلى لوحة التحكم
2. الانتقال إلى "حملة ال1000 سفينة"
3. عرض وإدارة الاستطلاعات
4. تصدير البيانات إلى Excel

## الأمان
- التحقق من صحة البيانات المدخلة
- حماية من CSRF
- مصادقة الأدمن
- تشفير البيانات الحساسة

## الدعم التقني
- النظام مبني على Laravel 10
- يستخدم Bootstrap للتصميم
- متوافق مع جميع المتصفحات الحديثة
- تصميم متجاوب يعمل على الموبايل

## التطوير المستقبلي
- إضافة رسوم بيانية للإحصائيات
- نظام تنبيهات للمشاركين الجدد
- تكامل مع وسائل التواصل الاجتماعي
- نظام نقاط للمشاركين النشطين
