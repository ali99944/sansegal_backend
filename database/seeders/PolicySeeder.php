<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Policy;

class PolicySeeder extends Seeder
{
    public function run(): void
    {
        Policy::updateOrCreate(['slug' => 'privacy-policy'], [
            'title' => 'سياسة الخصوصية',
            'content' => "# سياسة الخصوصية\n\n## 1. البيانات التي نجمعها\n\nنحن نجمع البيانات التي تقدمها مباشرة عند إنشاء طلب...\n\n*   الاسم الكامل\n*   البريد الإلكتروني\n*   رقم الهاتف\n\n## 2. كيف نستخدم بياناتك\n\nنستخدم بياناتك لتوصيل الطلبات والتواصل معك بشأنها."
        ]);

        Policy::updateOrCreate(['slug' => 'terms-of-service'], [
            'title' => 'شروط الخدمة',
            'content' => "# شروط وأحكام الخدمة\n\nمرحبًا بك في San Segal. باستخدام موقعنا، فإنك توافق على الالتزام بالشروط التالية..."
        ]);

        Policy::updateOrCreate(['slug' => 'shipping-policy'], [
            'title' => 'سياسة الشحن',
            'content' => "# سياسة الشحن والتوصيل\n\n## مدة التوصيل\n\nتتراوح مدة التوصيل من 3 إلى 7 أيام عمل داخل مصر."
        ]);
    }
}
