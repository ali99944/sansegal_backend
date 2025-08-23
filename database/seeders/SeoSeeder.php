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
            'key' => 'contact',
            'title' => 'تواصل معنا | San Segal',
            'description' => 'هل لديك أي استفسارات؟ تواصل مع فريق خدمة عملاء San Segal. نحن هنا لمساعدتك.',
        ]);

        Seo::create([
            'key' => 'about',
            'title' => 'عن San Segal | San Segal',
            'description' => 'تعرف علىSan Segal وكيف يمكننا مساعدتك في اختيار الحقيبة المناسبة لك.',
        ]);

        Seo::create([
            'key' => 'cart',
            'title' => 'عربة التسوق | San Segal',
            'description' => 'مشاهدة تفاصيل عربة التسوق الخاصة بك.',
        ]);


        Seo::create([
            'key' => 'checkout',
            'title' => 'إتمام الطلب | San Segal',
            'description' => 'أكمل عملية الشراء بسهولة وأمان مع San Segal.',
        ]);

        Seo::create([
            'key' => 'faq',
            'title' => 'الأسئلة الشائعة | San Segal',
            'description' => 'اعثر على إجابات لأكثر الأسئلة شيوعًا حول منتجات وخدمات San Segal.',
        ]);

        Seo::create([
            'key' => 'track-order',
            'title' => 'تتبع طلبك | San Segal',
            'description' => 'تتبع حالة طلبك بسهولة مع San Segal. ادخل رقم طلبك للحصول على آخر التحديثات.',
        ]);
    }
}
