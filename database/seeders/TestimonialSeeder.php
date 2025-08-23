<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear the table for a clean seed
        DB::table('testimonials')->truncate();

        // Fetch some existing products to link testimonials to them
        $artisanTote = Product::where('en_name', 'The Artisan Tote')->first();
        $nomadCrossbody = Product::where('en_name', 'The Nomad Crossbody')->first();
        $executiveBriefcase = Product::where('en_name', 'The Executive Briefcase')->first();
        $essentialWallet = Product::where('en_name', 'The Essential Wallet')->first();

        $testimonials = [
            [
                'name' => 'Nourhan Ali',
                'location' => 'Cairo, Egypt',
                'review' => 'Amazing quality and unique design. The Artisan Tote has become an integral part of my daily look. Thank you San Segal!',
                'product_id' => $artisanTote->id ?? null,
                'product_name' => $artisanTote->en_name ?? 'The Artisan Tote',
                'is_visible' => true,
            ],
            [
                'name' => 'Ahmed Mahmoud',
                'location' => 'Alexandria, Egypt',
                'review' => 'I bought the Essential Wallet and it was the best decision. Perfect size and unmatched leather quality. Very practical and elegant.',
                'product_id' => $essentialWallet->id ?? null,
                'product_name' => $essentialWallet->en_name ?? 'The Essential Wallet',
                'is_visible' => true,
            ],
            [
                'name' => 'Sarah Karim',
                'location' => 'Dubai, UAE',
                'review' => 'Customer service was excellent, and I received the Nomad bag in record time. The bag itself is a work of art, light and practical for travel.',
                'product_id' => $nomadCrossbody->id ?? null,
                'product_name' => $nomadCrossbody->en_name ?? 'The Nomad Crossbody',
                'is_visible' => true,
            ],
            [
                'name' => 'Khaled Ibrahim',
                'location' => 'Giza, Egypt',
                'review' => 'The Executive Briefcase is exactly what I was looking for. It adds a professional touch to my appearance and fits all my essentials.',
                'product_id' => $executiveBriefcase->id ?? null,
                'product_name' => $executiveBriefcase->en_name ?? 'The Executive Briefcase',
                'is_visible' => true,
            ],
            [
                'name' => 'Fatima Al-Zahra',
                'location' => 'Riyadh, Saudi Arabia',
                'review' => 'I\'m very impressed with the attention to detail in San Segal products. The quality is evident in every stitch. Excellent shopping experience from start to finish.',
                'product_id' => null, // General review, not linked to a specific product
                'product_name' => 'General Experience',
                'is_visible' => true,
            ],
            [
                'name' => 'Omar Al-Sharif',
                'location' => 'Kuwait',
                'review' => 'This is an invisible testimonial for testing purposes. The quality is simply outstanding.',
                'product_id' => null,
                'product_name' => 'General Feedback',
                'is_visible' => false, // This testimonial will not be visible on the frontend
            ],
            [
                'name' => 'Mariam Hassan',
                'location' => 'Mansoura, Egypt',
                'review' => 'The details of the Artisan Tote are incredible. Everyone who sees it asks about it. Proud to have an Egyptian product of such global quality.',
                'product_id' => $artisanTote->id ?? null,
                'product_name' => $artisanTote->en_name ?? 'The Artisan Tote',
                'is_visible' => true,
            ],
        ];

        // Insert the data into the database
        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
