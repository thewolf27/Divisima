<?php

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Seeder;

class OptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $options = [
            'footer_about' => $faker->realText(100),
            
            // company info
            'company_name' => $faker->company,
            'company_address' => $faker->address,
            'company_phone' => $faker->phoneNumber,
            'company_email' => $faker->email,

            // social
            'instagram_link' => 'https://instagram.com',
            'google_link' => 'https://google.com',
            'pinterest_link' => 'https://pinterest.com',
            'facebook_link' => 'https://facebook.com',
            'twitter_link' => 'https://twitter.com',
            'youtube_link' => 'https://youtube.com',
            'tumblr_link' => 'https://tumblr.com',

            // delivery 
            'order_delivery' => [
                          'Courier delivery', 
                          'Post delivery', 
                          'Post-express delivery',  
                        ],
            'order_status' => [
                          'In progress',
                          'On hold', 
                          'Completed', 
                          'Declined',  
                        ],
            'stock_status' => [
                          'Out of stock',
                          'Pre-order', 
                          'In stock', 
                        ],

            'products_per_page' => '12',

            'shipping_return_info' => '<h4>7 Days Returns</h4>
            <p>Cash on Delivery Available<br>Home Delivery <span>3 - 4 days</span></p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin pharetra tempor so dales. Phasellus sagittis auctor gravida. Integer bibendum sodales arcu id te mpus. Ut consectetur lacus leo, non scelerisque nulla euismod nec.</p>',
            
        ];
        foreach($options as $key => $value){
            
            Option::create([
                'key' => $key,
                'value' => $value,
            ]);
        }
    }
}