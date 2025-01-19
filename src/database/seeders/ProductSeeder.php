<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => '腕時計',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'price' => 15000,
                'image' => 'images/Armani+Mens+Clock.jpg',
                'condition' => '良好',
                'category' => json_encode(['アクセサリー']),
                'user_id' => 1,
            ],
            [
                'name' => 'HDD',
                'description' => '高速で信頼性の高いハードディスク',
                'price' => 5000,
                'image' => 'images/HDD+Hard+Disk.jpg',
                'condition' => '目立った傷や汚れなし',
                'category' => json_encode(['家電']),
                'user_id' => 1,
            ],
            [
                'name' => '玉ねぎ3束',
                'description' => '新鮮な玉ねぎ3束のセット',
                'price' => 300,
                'image' => 'images/iLoveIMG+d.jpg',
                'condition' => 'やや傷や汚れあり',
                'category' => json_encode(['ハンドメイド']),
                'user_id' => 1,
            ],
            [
                'name' => '革靴',
                'description' => 'クラシックなデザインの革靴',
                'price' => 4000,
                'image' => 'images/Leather+Shoes+Product+Photo.jpg',
                'condition' => '状態が悪い',
                'category' => json_encode(['メンズ']),
                'user_id' => 1,
            ],
            [
                'name' => 'ノートPC',
                'description' => '高性能なノートパソコン',
                'price' => 45000,
                'image' => 'images/Living+Room+Laptop.jpg',
                'condition' => '良好',
                'category' => json_encode(['家電']),
                'user_id' => 1,
            ],
            [
                'name' => 'マイク',
                'description' => '高音質のレコーディング用マイク',
                'price' => 8000,
                'image' => 'images/Music+Mic+4632231.jpg',
                'condition' => '目立った傷や汚れなし',
                'category' => json_encode(['ゲーム']),
                'user_id' => 1,
            ],
            [
                'name' => 'ショルダーバッグ',
                'description' => 'おしゃれなショルダーバッグ',
                'price' => 3500,
                'image' => 'images/Purse+fashion+pocket.jpg',
                'condition' => 'やや傷や汚れあり',
                'category' => json_encode(['ファッション']),
                'user_id' => 1,
            ],
            [
                'name' => 'タンブラー',
                'description' => '使いやすいタンブラー',
                'price' => 500,
                'image' => 'images/Tumbler+souvenir.jpg',
                'condition' => '状態が悪い',
                'category' => json_encode(['キッチン']),
                'user_id' => 1,
            ],
            [
                'name' => 'コーヒーミル',
                'description' => '手動のコーヒーミル',
                'price' => 4000,
                'image' => 'images/Waitress+with+Coffee+Grinder.jpg',
                'condition' => '良好',
                'category' => json_encode(['キッチン']),
                'user_id' => 1,
            ],
            [
                'name' => 'メイクセット',
                'description' => '便利なメイクアップセット',
                'price' => 2500,
                'image' => 'images/外出メイクアップセット.jpg',
                'condition' => '目立った傷や汚れなし',
                'category' => json_encode(['コスメ']),
                'user_id' => 1,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}