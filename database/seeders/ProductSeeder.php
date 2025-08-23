<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // For a clean seed, it's best to disable foreign key checks, truncate, then re-enable.
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // DB::table('products')->truncate();
        // DB::table('product_variants')->truncate();
        // DB::table('product_images')->truncate();
        // DB::table('product_specifications')->truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $productsData = [
            [
                'ar_name' => 'حقيبة "أرتيزان" توت',
                'en_name' => 'The Artisan Tote',
                'ar_description' => 'مثالية للاستخدام اليومي، تجمع حقيبة "أرتيزان" بين الرحابة والأناقة. مصنوعة من جلد محبب بالكامل لتدوم طويلاً.',
                'en_description' => 'Perfect for daily use, the Artisan Tote combines spaciousness with elegance. Crafted from full-grain leather to last a lifetime.',
                'original_price' => 3800.00,
                'discount' => 300.00,
                'discount_type' => 'fixed',
                'image' => 'products/p1.png',
                'gallery' => [],
                'specifications' => [
                    ['spec_key' => 'الخامة', 'spec_value' => 'جلد بقري محبب بالكامل'],
                    ['spec_key' => 'الأبعاد', 'spec_value' => '40سم عرض × 30سم ارتفاع × 15سم عمق'],
                    ['spec_key' => 'البطانة', 'spec_value' => 'قماش قطني متين'],
                ],
            ],
            [
                'ar_name' => 'حقيبة "نوماد" كروس',
                'en_name' => 'The Nomad Crossbody',
                'ar_description' => 'رفيقتك المثالية للتجوال الحر. خفيفة الوزن وعملية، مع جيوب متعددة لتنظيم أغراضك الأساسية.',
                'en_description' => 'Your perfect companion for free-roaming. Lightweight and practical, with multiple pockets to organize your essentials.',
                'original_price' => 2500.00,
                'discount' => null,
                'discount_type' => null,
                'image' => 'products/p2.png',
                'gallery' => [],
                'specifications' => [
                    ['spec_key' => 'الخامة', 'spec_value' => 'جلد نابا إيطالي'],
                    ['spec_key' => 'الأبعاد', 'spec_value' => '25سم عرض × 18سم ارتفاع × 8سم عمق'],
                    ['spec_key' => 'الحزام', 'spec_value' => 'قابل للتعديل'],
                ],
            ],
            [
                'ar_name' => 'حقيبة "إكزكتيف" للأعمال',
                'en_name' => 'The Executive Briefcase',
                'ar_description' => 'صُممت للمحترفين. تتميز بمساحة مبطنة للابتوب وجيوب داخلية للمستندات والأقلام.',
                'en_description' => 'Designed for professionals. Features a padded laptop compartment and internal pockets for documents and pens.',
                'original_price' => 5200.00,
                'discount' => 10,
                'discount_type' => 'percentage',
                'image' => 'products/p3.png',
                'gallery' => [],
                'specifications' => [
                    ['spec_key' => 'الخامة', 'spec_value' => 'جلد مدبوغ نباتيًا'],
                    ['spec_key' => 'الأبعاد', 'spec_value' => '38سم عرض × 28سم ارتفاع × 10سم عمق'],
                    ['spec_key' => 'تناسب لابتوب', 'spec_value' => 'حتى 15 بوصة'],
                ],
            ],
            [
                'ar_name' => 'حقيبة ظهر "سيتي واندرر"',
                'en_name' => 'The City Wanderer Backpack',
                'ar_description' => 'تجمع بين التصميم العصري والراحة. مثالية للعمل أو عطلة نهاية الأسبوع.',
                'en_description' => 'Combines modern design with comfort. Perfect for work or a weekend getaway.',
                'original_price' => 4500.00,
                'discount' => null,
                'discount_type' => null,
                'image' => 'products/p4.png',
                'gallery' => [],
                'specifications' => [
                    ['spec_key' => 'الخامة', 'spec_value' => 'جلد بقرى أصلي'],
                    ['spec_key' => 'الأبعاد', 'spec_value' => '30سم عرض × 42سم ارتفاع × 14سم عمق'],
                    ['spec_key' => 'الإكسسوارات', 'spec_value' => 'نحاس صلب'],
                ],
            ],
            [
                'ar_name' => 'كلاتش "مينيماليست"',
                'en_name' => 'The Minimalist Clutch',
                'ar_description' => 'بسيط وأنيق. الإضافة المثالية لإطلالتك المسائية.',
                'en_description' => 'Simple and elegant. The perfect addition to your evening look.',
                'original_price' => 1500.00,
                'discount' => null,
                'discount_type' => null,
                'image' => 'products/p5.png',
                'gallery' => [],
                'specifications' => [
                    ['spec_key' => 'الخامة', 'spec_value' => 'جلد سافيانو'],
                    ['spec_key' => 'الأبعاد', 'spec_value' => '22سم عرض × 14سم ارتفاع'],
                    ['spec_key' => 'القفل', 'spec_value' => 'مغناطيسي'],
                ],
            ],
            [
                'ar_name' => 'حقيبة سفر "هيريتدج"',
                'en_name' => 'The Heritage Duffle',
                'ar_description' => 'حقيبة سفر قوية وأنيقة، مصنوعة لتدوم عبر الأجيال. تتسع لجميع احتياجات رحلتك القصيرة.',
                'en_description' => 'A robust and stylish travel bag, built to last for generations. Fits all your short trip essentials.',
                'original_price' => 6500.00,
                'discount' => null,
                'discount_type' => null,
                'image' => 'products/p6.png',
                'gallery' => [],
                'specifications' => [
                    ['spec_key' => 'الخامة', 'spec_value' => 'جلد كريزي هورس'],
                    ['spec_key' => 'الأبعاد', 'spec_value' => '50سم عرض × 28سم ارتفاع × 25سم عمق'],
                    ['spec_key' => 'الحجم', 'spec_value' => '40 لتر'],
                ],
            ],
            [
                'ar_name' => 'محفظة "إيسينشال"',
                'en_name' => 'The Essential Wallet',
                'ar_description' => 'تصميم نحيف وكلاسيكي يتسع لبطاقاتك ونقودك دون إضافة حجم زائد.',
                'en_description' => 'A slim and classic design that fits your cards and cash without adding bulk.',
                'original_price' => 850.00,
                'discount' => null,
                'discount_type' => null,
                'image' => 'products/p7.jpg',
                'gallery' => [],
                'specifications' => [
                    ['spec_key' => 'الخامة', 'spec_value' => 'جلد طبيعي'],
                    ['spec_key' => 'فتحات البطاقات', 'spec_value' => '6'],
                    ['spec_key' => 'جيب النقود', 'spec_value' => '1'],
                ],
            ],
            // Adding 10 more products to reach 17 total
            [
                'ar_name' => 'حقيبة "سكولار" للكتف',
                'en_name' => 'The Scholar Messenger Bag',
                'ar_description' => 'تصميم كلاسيكي للطلاب والمبدعين، مع مساحة كافية للكتب والجهاز اللوحي.',
                'en_description' => 'A classic design for students and creatives, with enough space for books and a tablet.',
                'original_price' => 3200.00,
                'discount' => 15,
                'discount_type' => 'percentage',
                'image' => 'products/p8.jpg',
                'gallery' => [],
                'specifications' => [
                    ['spec_key' => 'الخامة', 'spec_value' => 'جلد مدبوغ بالزيت'],
                    ['spec_key' => 'الأبعاد', 'spec_value' => '35سم عرض × 25سم ارتفاع × 9سم عمق'],
                ],
            ],
            [
                'ar_name' => 'حامل جواز سفر "فوييجر"',
                'en_name' => 'The Voyager Passport Holder',
                'ar_description' => 'حافظ على مستندات سفرك آمنة ومنظمة بأناقة.',
                'en_description' => 'Keep your travel documents safe and organized in style.',
                'original_price' => 950.00,
                'discount' => null,
                'discount_type' => null,
                'image' => 'products/p9.jpg',
                'gallery' => [],
                'specifications' => [
                    ['spec_key' => 'الخامة', 'spec_value' => 'جلد طبيعي فاخر'],
                    ['spec_key' => 'المميزات', 'spec_value' => 'فتحات لجواز السفر والبطاقات وتذكرة الطائرة'],
                ],
            ],
            [
                'ar_name' => 'حافظة لابتوب "كرييتور"',
                'en_name' => 'The Creator\'s Laptop Sleeve',
                'ar_description' => 'حماية أنيقة لجهازك. مبطنة من الداخل لحماية فائقة ضد الصدمات والخدوش.',
                'en_description' => 'Stylish protection for your device. Padded on the inside for superior shock and scratch protection.',
                'original_price' => 1800.00,
                'discount' => 200,
                'discount_type' => 'fixed',
                'image' => 'products/p10.jpg',
                'gallery' => [],
                'specifications' => [
                    ['spec_key' => 'الخامة', 'spec_value' => 'جلد وجلد شمواه'],
                    ['spec_key' => 'تناسب لابتوب', 'spec_value' => '13 بوصة'],
                ],
            ],
            [
                'ar_name' => 'حقيبة "سيجنتشر" توت',
                'en_name' => 'The Signature Tote',
                'ar_description' => 'تصميمنا الأيقوني. تتميز بتفاصيل دقيقة وشعار San Segal المحفور.',
                'en_description' => 'Our iconic design. Features meticulous detailing and the embossed San Segal logo.',
                'original_price' => 4200.00,
                'discount' => null,
                'discount_type' => null,
                'image' => 'products/p11.jpg',
                'gallery' => [],
                'specifications' => [
                    ['spec_key' => 'الخامة', 'spec_value' => 'جلد إيطالي محبب بالكامل'],
                    ['spec_key' => 'الأبعاد', 'spec_value' => '42سم عرض × 32سم ارتفاع × 16سم عمق'],
                ],
            ],
            [
                'ar_name' => 'كلاتش "ميدنايت جالا"',
                'en_name' => 'The Midnight Gala Clutch',
                'ar_description' => 'قطعة فنية لمناسباتك الخاصة. مزينة بإكسسوارات معدنية مصقولة.',
                'en_description' => 'A statement piece for your special occasions. Adorned with polished metal hardware.',
                'original_price' => 1950.00,
                'discount' => null,
                'discount_type' => null,
                'image' => 'products/p12.jpg',
                'gallery' => [],
                'specifications' => [
                    ['spec_key' => 'الخامة', 'spec_value' => 'جلد لامع'],
                    ['spec_key' => 'السلسلة', 'spec_value' => 'معدنية قابلة للإزالة'],
                ],
            ],
            [
                'ar_name' => 'حقيبة ظهر "باثفايندر"',
                'en_name' => 'The Pathfinder Backpack',
                'ar_description' => 'متينة وعملية للمغامرات اليومية. تتميز بجيوب خارجية لسهولة الوصول.',
                'en_description' => 'Durable and functional for daily adventures. Features external pockets for easy access.',
                'original_price' => 4800.00,
                'discount' => 500,
                'discount_type' => 'fixed',
                'image' => 'products/p13.jpg',
                'gallery' => [],
                'specifications' => [
                    ['spec_key' => 'الخامة', 'spec_value' => 'جلد وقماش كانفاس مشمع'],
                    ['spec_key' => 'الأبعاد', 'spec_value' => '32سم عرض × 45سم ارتفاع × 15سم عمق'],
                ],
            ],
            [
                'ar_name' => 'ملف "دبلوماسي"',
                'en_name' => 'The Diplomat Folio',
                'ar_description' => 'حافظ على مستنداتك منظمة بأناقة في الاجتماعات الهامة.',
                'en_description' => 'Keep your documents elegantly organized for important meetings.',
                'original_price' => 2200.00,
                'discount' => null,
                'discount_type' => null,
                'image' => 'products/p14.jpg',
                'gallery' => [],
                'specifications' => [
                    ['spec_key' => 'الخامة', 'spec_value' => 'جلد محبب'],
                    ['spec_key' => 'الحجم', 'spec_value' => 'يناسب ورق A4'],
                ],
            ],
            [
                'ar_name' => 'حقيبة "ويكندر" للسفر',
                'en_name' => 'The Weekender Duffle',
                'ar_description' => 'الحجم المثالي لرحلات نهاية الأسبوع. تصميم يجمع بين الخفة والمتانة.',
                'en_description' => 'The perfect size for weekend trips. A design that combines lightness and durability.',
                'original_price' => 5800.00,
                'discount' => 10,
                'discount_type' => 'percentage',
                'image' => 'products/p15.jpg',
                'gallery' => [],
                'specifications' => [
                    ['spec_key' => 'الخامة', 'spec_value' => 'جلد طبيعي مصقول'],
                    ['spec_key' => 'الأبعاد', 'spec_value' => '48سم عرض × 25سم ارتفاع × 22سم عمق'],
                ],
            ],
            [
                'ar_name' => 'حامل بطاقات "كومباكت"',
                'en_name' => 'The Compact Cardholder',
                'ar_description' => 'لأولئك الذين يفضلون البساطة. يتسع لـ 4-6 بطاقات بشكل مريح.',
                'en_description' => 'For those who prefer simplicity. Comfortably fits 4-6 cards.',
                'original_price' => 750.00,
                'discount' => null,
                'discount_type' => null,
                'image' => 'products/p16.jpg',
                'gallery' => [],
                'specifications' => [
                    ['spec_key' => 'الخامة', 'spec_value' => 'جلد عجل'],
                    ['spec_key' => 'فتحات البطاقات', 'spec_value' => '4'],
                ],
            ],
            [
                'ar_name' => 'حقيبة كروس "إيفريداي"',
                'en_name' => 'The Everyday Crossbody',
                'ar_description' => 'تصميم عملي وأنيق يناسب جميع إطلالاتك اليومية.',
                'en_description' => 'A practical and stylish design that complements all your daily outfits.',
                'original_price' => 2650.00,
                'discount' => null,
                'discount_type' => null,
                'image' => 'products/p17.jpg',
                'gallery' => [],
                'specifications' => [
                    ['spec_key' => 'الخامة', 'spec_value' => 'جلد سافيانو'],
                    ['spec_key' => 'الأبعاد', 'spec_value' => '24سم عرض × 16سم ارتفاع × 7سم عمق'],
                ],
            ],
        ];

        foreach ($productsData as $data) {
            // Create the main product record
            $product = Product::create(Arr::except($data, ['initial_color', 'gallery', 'specifications']));


            // Create the gallery images
            foreach ($data['gallery'] as $index => $galleryImagePath) {
                $product->images()->create([
                    'image_path' => $galleryImagePath,
                    'position' => $index,
                ]);
            }

            // Create the specifications
            foreach ($data['specifications'] as $spec) {
                $product->specifications()->create($spec);
            }
        }
    }
}
