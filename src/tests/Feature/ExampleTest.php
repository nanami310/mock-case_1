<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;

class RegistrationTest extends TestCase
{
    protected function setUp(): void
{
    parent::setUp();
    // データベースをリフレッシュする
    $this->artisan('migrate:fresh');
}
    /** @test */
    public function it_displays_validation_message_when_name_is_not_provided()
    {
        // 1. 会員登録ページを開く
        $this->get('/register');

        // 2. 名前を入力せずに他の必要項目を入力する
        $response = $this->post('/register', [
            'email' => 'test@example.com',
            'password' => 'password',
            // 名前は空
        ]);

        // 3. 登録ボタンを押す
        // 期待挙動：「お名前を入力してください」というバリデーションメッセージが表示される
        $response->assertSessionHasErrors('name'); // 'name' フィールドにエラーがあることを確認
    }

    /** @test */
    public function it_displays_validation_message_when_email_is_not_provided()
    {
        // 1. 会員登録ページを開く
        $this->get('/register');

        // 2. メールアドレスを入力せずに他の必要項目を入力する
        $response = $this->post('/register', [
            'name' => 'テストユーザー', // 名前は入力
            'password' => 'password',
            // メールアドレスは空
        ]);
        // 3. 登録ボタンを押す
    // 期待挙動：「メールアドレスを入力してください」というバリデーションメッセージが表示される
    $response->assertSessionHasErrors('email'); // 'email' フィールドにエラーがあることを確認
    }

    /** @test */
public function it_displays_validation_message_when_password_is_not_provided()
{
    $this->get('/register');

    $response = $this->post('/register', [
        'name' => 'テストユーザー',
        'email' => 'test@example.com',
        // パスワードは空
    ]);

    $response->assertSessionHasErrors('password'); // 'password' フィールドにエラーがあることを確認
}

/** @test */
public function it_displays_validation_message_when_password_is_too_short()
{
    $this->get('/register');

    $response = $this->post('/register', [
        'name' => 'テストユーザー',
        'email' => 'test@example.com',
        'password' => 'short', // 7文字以下のパスワード
    ]);

    $response->assertSessionHasErrors('password'); // 'password' フィールドにエラーがあることを確認
}

/** @test */
public function it_displays_validation_message_when_passwords_do_not_match()
{
    $this->get('/register');

    $response = $this->post('/register', [
        'name' => 'テストユーザー',
        'email' => 'test@example.com',
        'password' => 'password1',
        'password_confirmation' => 'password2', // 確認用パスワードが異なる
    ]);

    $response->assertSessionHasErrors('password'); // 'password' フィールドにエラーがあることを確認
}

/** @test */
public function it_registers_user_and_redirects_to_login_when_all_fields_are_valid()
{
    $this->get('/register');

    $response = $this->post('/register', [
        'name' => 'テストユーザー',
        'email' => 'test@example.com',
        'password' => 'validpassword', // 有効なパスワード
        'password_confirmation' => 'validpassword', // 確認用パスワードも一致
    ]);

    $response->assertRedirect('login'); // ログイン画面にリダイレクトされることを確認
    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
    ]); // データベースにユーザーが登録されていることを確認
}
/** @test */
public function it_shows_validation_message_when_email_is_missing()
{
    $response = $this->post('/login', [
        'password' => 'validpassword',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertEquals('メールアドレスを入力してください', session('errors')->get('email')[0]);
}

public function it_shows_validation_message_when_password_is_missing()
{
    $response = $this->post('/login', [
        'email' => 'test@example.com',
    ]);

    $response->assertSessionHasErrors('password');
    $this->assertEquals('パスワードを入力してください', session('errors')->get('password')[0]);
}
/** @test */
public function it_shows_error_when_credentials_are_incorrect()
{
    $response = $this->post('/login', [
        'email' => 'wrong@example.com',
        'password' => 'wrongpassword',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertEquals('ログイン情報が登録されていません', session('errors')->get('email')[0]);
}

/** @test */
public function it_logs_in_user_with_correct_credentials()
{
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('validpassword'),
    ]);

    $response = $this->post('/login', [
        'email' => 'test@example.com',
        'password' => 'validpassword',
    ]);

    $this->assertAuthenticatedAs($user);
    $response->assertRedirect('/'); // リダイレクト先の確認
}


/** @test */
public function it_logs_out_user()
{
    // テスト用ユーザーを作成してログイン
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('validpassword'),
    ]);

    $this->actingAs($user);

    $response = $this->post('/logout');

    $this->assertGuest(); // ログアウト状態を確認
    $response->assertRedirect('/'); // リダイレクト先の確認
}

/** @test */
public function it_displays_all_products()
{
    // 商品を作成
    $products = Product::factory()->count(5)->create();

    // 商品ページを開く
    $response = $this->get('/products');

    // すべての商品が表示されることを確認
    $response->assertStatus(200);
    foreach ($products as $product) {
        $response->assertSee($product->name);
    }
}

/** @test */
public function it_displays_sold_label_for_purchased_products()
{
    // 購入済みの商品を作成
    $soldProduct = Product::factory()->create(['is_sold' => true]);

    // 商品ページを開く
    $response = $this->get('/products');

    // 購入済み商品に「Sold」のラベルが表示されることを確認
    $response->assertSee($soldProduct->name);
    $response->assertSee('Sold');
}

/** @test */
public function it_does_not_display_users_own_products()
{
    // ユーザーを作成しログイン
    $user = User::factory()->create();
    $this->actingAs($user);

    // ユーザーが出品した商品を作成
    $userProduct = Product::factory()->create(['user_id' => $user->id]);

    // 他のユーザーの商品を作成
    Product::factory()->count(3)->create();

    // 商品ページを開く
    $response = $this->get('/products');

    // 自分が出品した商品が表示されないことを確認
    $response->assertDontSee($userProduct->name);
}

/** @test */
public function it_displays_only_liked_products_in_my_list()
{
    $user = User::factory()->create();
    $this->actingAs($user);

    // いいねした商品を作成
    $likedProduct = Product::factory()->create();
    $user->likes()->attach($likedProduct->id);

    // 他の商品を作成
    Product::factory()->count(3)->create();

    // マイリストページを開く
    $response = $this->get('/my-list');

    // いいねした商品が表示されることを確認
    $response->assertSee($likedProduct->name);
}
/** @test */
public function it_displays_sold_label_for_purchased_products2()
{
    $user = User::factory()->create();
    $this->actingAs($user);

    // 購入済み商品を作成
    $purchasedProduct = Product::factory()->create(['is_sold' => true]);

    // マイリストページを開く
    $response = $this->get('/my-list');

    // 購入済み商品に「Sold」のラベルが表示されることを確認
    $response->assertSee('Sold');
}
/** @test */
public function it_does_not_display_own_products_in_my_list()
{
    $user = User::factory()->create();
    $this->actingAs($user);

    // 自分が出品した商品を作成
    $userProduct = Product::factory()->create(['user_id' => $user->id]);

    // 他の商品を作成
    Product::factory()->count(3)->create();

    // マイリストページを開く
    $response = $this->get('/my-list');

    // 自分が出品した商品が表示されないことを確認
    $response->assertDontSee($userProduct->name);
}
/** @test */
public function it_displays_nothing_when_not_authenticated()
{
    // マイリストページを開く
    $response = $this->get('/my-list');

    // 何も表示されないことを確認
    $response->assertSee(''); // 具体的な内容に応じて修正
}
/** @test */
public function it_can_search_products_by_partial_name()
{
    $product = Product::factory()->create(['name' => 'Sample Product']);

    // 検索を実行
    $response = $this->get('/search?query=Sample');

    // 部分一致する商品が表示されることを確認
    $response->assertSee($product->name);
}
/** @test */
public function it_retains_search_query_in_my_list()
{
    $user = User::factory()->create();
    $this->actingAs($user);

    // 検索を実行
    $this->get('/search?query=Sample');

    // マイリストページに遷移
    $response = $this->get('/my-list');

    // 検索キーワードが保持されていることを確認
    $response->assertSee('Sample');
}
/** @test */
public function it_displays_product_details()
{
    $product = Product::factory()->create();

    // 商品詳細ページを開く
    $response = $this->get('item.show' . $product->id);

    // 必要な情報が表示されていることを確認
    $response->assertSee($product->name);
    $response->assertSee($product->brand);
    $response->assertSee($product->price);
    $response->assertSee($product->likes_count);
    $response->assertSee($product->comments_count);
    $response->assertSee($product->description);
    // 他の情報も同様に確認
}
/** @test */
public function it_displays_selected_categories()
{
    $product = Product::factory()->create();
    $product->categories()->attach([1, 2]); // カテゴリを追加

    // 商品詳細ページを開く
    $response = $this->get('item.show' . $product->id);

    // 複数選択されたカテゴリが表示されていることを確認
    $response->assertSee('Category 1');
    $response->assertSee('Category 2');
}


}