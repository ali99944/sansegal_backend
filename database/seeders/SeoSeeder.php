<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Seo;
use Illuminate\Support\Facades\DB;

class SeoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('seos')->truncate(); // Clear the table before seeding

        Seo::create([
            'key' => 'home',
            'title' => 'San Segal | حقائب جلدية يدوية فاخرة',
            'description' => 'اكتشف مجموعتنا الحصرية من الحقائب الجلدية المصنوعة يدويًا بحرفية عالية. تصميمات فريدة تجمع بين الأصالة والأناقة العصرية.',
            'keywords' => 'حقائب جلدية, صناعة يدوية, San Segal, حقائب نسائية, حقائب رجالية',
        ]);

        Seo::create([
            'key' => 'products',
            'title' => 'مجموعة المنتجات | San Segal',
            'description' => 'تصفح جميع حقائبنا الجلدية المصنوعة يدويًا. ابحث عن الحقيبة المثالية التي تناسب أسلوبك الفريد.',
        ]);

        Seo::create([
            'key' => 'contact',
            'title' => 'تواصل معنا | San Segal',
            'description' => 'هل لديك أي استفسارات؟ تواصل مع فريق خدمة عملاء San Segal. نحن هنا لمساعدتك.',
        ]);

        // Add more pages as needed...
    }
}
