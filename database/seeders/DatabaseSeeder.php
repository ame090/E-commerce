<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Seller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@ecommerce.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'phone' => '0123456789',
            'address' => 'Admin Address, Kuala Lumpur',
            'email_verified_at' => now(),
        ]);

        // Create Seller Users
        $seller1 = User::create([
            'name' => 'John Seller',
            'email' => 'seller1@example.com',
            'password' => bcrypt('password'),
            'role' => 'seller',
            'phone' => '0123456780',
            'address' => 'Seller 1 Address, Petaling Jaya',
            'email_verified_at' => now(),
        ]);

        $seller2 = User::create([
            'name' => 'Jane Merchant',
            'email' => 'seller2@example.com',
            'password' => bcrypt('password'),
            'role' => 'seller',
            'phone' => '0123456781',
            'address' => 'Seller 2 Address, Shah Alam',
            'email_verified_at' => now(),
        ]);

        $seller3 = User::create([
            'name' => 'Mike Store',
            'email' => 'seller3@example.com',
            'password' => bcrypt('password'),
            'role' => 'seller',
            'phone' => '0123456782',
            'address' => 'Seller 3 Address, Subang Jaya',
            'email_verified_at' => now(),
        ]);

        // Create Customer Users
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => "Customer {$i}",
                'email' => "customer{$i}@example.com",
                'password' => bcrypt('password'),
                'role' => 'customer',
                'phone' => '012345678' . $i,
                'address' => "Customer {$i} Address, Kuala Lumpur",
                'email_verified_at' => now(),
            ]);
        }

        // Create Seller Profiles
        $sellerProfile1 = Seller::create([
            'user_id' => $seller1->id,
            'shop_name' => 'Tech Haven',
            'slug' => Str::slug('Tech Haven'),
            'description' => 'Your one-stop shop for all tech gadgets and accessories',
            'status' => 'approved',
            'commission_rate' => 10.00,
            'balance' => 0,
        ]);

        $sellerProfile2 = Seller::create([
            'user_id' => $seller2->id,
            'shop_name' => 'Fashion World',
            'slug' => Str::slug('Fashion World'),
            'description' => 'Latest fashion trends and clothing for everyone',
            'status' => 'approved',
            'commission_rate' => 12.00,
            'balance' => 0,
        ]);

        $sellerProfile3 = Seller::create([
            'user_id' => $seller3->id,
            'shop_name' => 'Home & Living',
            'slug' => Str::slug('Home & Living'),
            'description' => 'Quality home decor and living essentials',
            'status' => 'approved',
            'commission_rate' => 10.00,
            'balance' => 0,
        ]);

        // Create Categories
        $electronics = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'description' => 'Electronic devices and gadgets',
            'is_active' => true,
        ]);

        $fashion = Category::create([
            'name' => 'Fashion',
            'slug' => 'fashion',
            'description' => 'Clothing and accessories',
            'is_active' => true,
        ]);

        $homeGarden = Category::create([
            'name' => 'Home & Garden',
            'slug' => 'home-garden',
            'description' => 'Home improvement and garden supplies',
            'is_active' => true,
        ]);

        $books = Category::create([
            'name' => 'Books',
            'slug' => 'books',
            'description' => 'Books and magazines',
            'is_active' => true,
        ]);

        $sports = Category::create([
            'name' => 'Sports & Outdoors',
            'slug' => 'sports-outdoors',
            'description' => 'Sports equipment and outdoor gear',
            'is_active' => true,
        ]);

        // Create Products for Seller 1 (Electronics)
        $products1 = [
            ['name' => 'Wireless Bluetooth Headphones', 'price' => 89.99, 'compare_price' => 129.99, 'stock' => 50],
            ['name' => 'Smart Watch Pro', 'price' => 199.99, 'compare_price' => 299.99, 'stock' => 30],
            ['name' => 'USB-C Hub 7-in-1', 'price' => 45.00, 'compare_price' => 69.99, 'stock' => 100],
            ['name' => 'Portable Power Bank 20000mAh', 'price' => 39.99, 'compare_price' => 59.99, 'stock' => 75],
            ['name' => 'Wireless Charging Pad', 'price' => 29.99, 'compare_price' => 49.99, 'stock' => 60],
        ];

        foreach ($products1 as $index => $productData) {
            Product::create([
                'seller_id' => $sellerProfile1->id,
                'category_id' => $electronics->id,
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']),
                'description' => 'High quality ' . strtolower($productData['name']) . ' with excellent features and durability.',
                'price' => $productData['price'],
                'compare_price' => $productData['compare_price'],
                'stock' => $productData['stock'],
                'sku' => 'SKU-' . strtoupper(Str::random(6)),
                'is_featured' => $index < 2,
                'is_active' => true,
                'status' => 'approved',
            ]);
        }

        // Create Products for Seller 2 (Fashion)
        $products2 = [
            ['name' => 'Cotton T-Shirt Unisex', 'price' => 19.99, 'compare_price' => 29.99, 'stock' => 200],
            ['name' => 'Denim Jeans Premium', 'price' => 49.99, 'compare_price' => 79.99, 'stock' => 150],
            ['name' => 'Leather Wallet', 'price' => 35.00, 'compare_price' => 55.00, 'stock' => 80],
            ['name' => 'Sunglasses UV Protection', 'price' => 25.99, 'compare_price' => 39.99, 'stock' => 100],
            ['name' => 'Canvas Backpack', 'price' => 42.00, 'compare_price' => 65.00, 'stock' => 70],
        ];

        foreach ($products2 as $index => $productData) {
            Product::create([
                'seller_id' => $sellerProfile2->id,
                'category_id' => $fashion->id,
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']),
                'description' => 'Stylish and comfortable ' . strtolower($productData['name']) . ' perfect for everyday wear.',
                'price' => $productData['price'],
                'compare_price' => $productData['compare_price'],
                'stock' => $productData['stock'],
                'sku' => 'SKU-' . strtoupper(Str::random(6)),
                'is_featured' => $index < 2,
                'is_active' => true,
                'status' => 'approved',
            ]);
        }

        // Create Products for Seller 3 (Home & Garden)
        $products3 = [
            ['name' => 'LED Desk Lamp', 'price' => 32.99, 'compare_price' => 49.99, 'stock' => 90],
            ['name' => 'Kitchen Knife Set', 'price' => 55.00, 'compare_price' => 85.00, 'stock' => 50],
            ['name' => 'Ceramic Flower Pot', 'price' => 15.99, 'compare_price' => 25.99, 'stock' => 120],
            ['name' => 'Wall Clock Modern', 'price' => 28.00, 'compare_price' => 45.00, 'stock' => 60],
            ['name' => 'Throw Pillow Set', 'price' => 22.99, 'compare_price' => 35.99, 'stock' => 100],
        ];

        foreach ($products3 as $index => $productData) {
            Product::create([
                'seller_id' => $sellerProfile3->id,
                'category_id' => $homeGarden->id,
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']),
                'description' => 'Beautiful and functional ' . strtolower($productData['name']) . ' for your home.',
                'price' => $productData['price'],
                'compare_price' => $productData['compare_price'],
                'stock' => $productData['stock'],
                'sku' => 'SKU-' . strtoupper(Str::random(6)),
                'is_featured' => $index < 1,
                'is_active' => true,
                'status' => 'approved',
            ]);
        }

        // Create Promotions
        Promotion::create([
            'code' => 'WELCOME10',
            'description' => '10% off for new customers',
            'type' => 'percentage',
            'discount_value' => 10,
            'min_purchase' => 50.00,
            'usage_limit' => 100,
            'used_count' => 0,
            'start_date' => now(),
            'end_date' => now()->addDays(30),
            'is_active' => true,
        ]);

        Promotion::create([
            'code' => 'SAVE20',
            'description' => 'RM 20 off on orders above RM 200',
            'type' => 'fixed',
            'discount_value' => 20,
            'min_purchase' => 200.00,
            'usage_limit' => 50,
            'used_count' => 0,
            'start_date' => now(),
            'end_date' => now()->addDays(60),
            'is_active' => true,
        ]);

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin: admin@ecommerce.com / password');
        $this->command->info('Seller1: seller1@example.com / password');
        $this->command->info('Seller2: seller2@example.com / password');
        $this->command->info('Customer1: customer1@example.com / password');
    }
}
