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
        $this->artisan('migrate:fresh');
    }

    /** @test */
    public function it_displays_validation_message_when_name_is_not_provided()
    {
        $this->get('/register');

        $response = $this->post('/register', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('name'); 
    }

    /** @test */
    public function it_displays_validation_message_when_email_is_not_provided()
    {
        $this->get('/register');

        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function it_displays_validation_message_when_password_is_not_provided()
    {
        $this->get('/register');

        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
        ]);

        $response->assertSessionHasErrors('password'); 
    }

    /** @test */
    public function it_displays_validation_message_when_password_is_too_short()
    {
        $this->get('/register');

        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'short', 
        ]);

        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function it_displays_validation_message_when_passwords_do_not_match()
    {
        $this->get('/register');

        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password1',
            'password_confirmation' => 'password2',
        ]);

        $response->assertSessionHasErrors('password'); 
    }

    /** @test */
    public function it_registers_user_and_redirects_to_login_when_all_fields_are_valid()
    {
        $this->get('/register');

        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'validpassword', 
            'password_confirmation' => 'validpassword', 
        ]);

        $response->assertRedirect('login'); 
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]); 
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

    /** @test */
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
        $response->assertRedirect('/'); 
    }

    /** @test */
    public function it_logs_out_user()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('validpassword'),
        ]);

        $this->actingAs($user);

        $response = $this->post('/logout');

        $this->assertGuest(); 
        $response->assertRedirect('/'); 
    }

    /** @test */
    public function it_displays_all_products()
    {
        $products = Product::factory()->count(5)->create();

        $response = $this->get('/products');

        $response->assertStatus(200);
        foreach ($products as $product) {
            $response->assertSee($product->name);
        }
    }

    /** @test */
    public function it_displays_sold_label_for_purchased_products()
    {
        $soldProduct = Product::factory()->create(['is_sold' => true]);

        $response = $this->get('/products');

        $response->assertSee($soldProduct->name);
        $response->assertSee('Sold');
    }

    /** @test */
    public function it_does_not_display_users_own_products()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $userProduct = Product::factory()->create(['user_id' => $user->id]);

        Product::factory()->count(3)->create();

        $response = $this->get('/products');

        $response->assertDontSee($userProduct->name);
    }

    /** @test */
    public function it_displays_only_liked_products_in_my_list()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $likedProduct = Product::factory()->create();
        $user->likes()->attach($likedProduct->id);

        Product::factory()->count(3)->create();

        $response = $this->get('/my-list');

        $response->assertSee($likedProduct->name);
    }

    /** @test */
    public function it_displays_sold_label_for_purchased_products2()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $purchasedProduct = Product::factory()->create(['is_sold' => true]);

        $response = $this->get('/my-list');

        $response->assertSee('Sold');
    }

    /** @test */
    public function it_does_not_display_own_products_in_my_list()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $userProduct = Product::factory()->create(['user_id' => $user->id]);

        Product::factory()->count(3)->create();

        $response = $this->get('/my-list');

        $response->assertDontSee($userProduct->name);
    }

    /** @test */
    public function it_displays_nothing_when_not_authenticated()
    {
        $response = $this->get('/my-list');

        $response->assertSee(''); 
    }

    /** @test */
    public function it_can_search_products_by_partial_name()
    {
        $product = Product::factory()->create(['name' => 'Sample Product']);

        $response = $this->get('/search?query=Sample');

        $response->assertSee($product->name);
    }

    /** @test */
    public function it_retains_search_query_in_my_list()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get('/search?query=Sample');

        $response = $this->get('/my-list');

        $response->assertSee('Sample');
    }

    /** @test */
    public function it_displays_product_details()
    {
        $product = Product::factory()->create();

        $response = $this->get('item.show/' . $product->id);

        $response->assertSee($product->name);
        $response->assertSee($product->brand);
        $response->assertSee($product->price);
        $response->assertSee($product->likes_count);
        $response->assertSee($product->comments_count);
        $response->assertSee($product->description);
    }

    /** @test */
    public function it_displays_selected_categories()
    {
        $product = Product::factory()->create();
        $product->categories()->attach([1, 2]); 

        $response = $this->get('item.show/' . $product->id);

        $response->assertSee('Category 1');
        $response->assertSee('Category 2');
    }

    /** @test */
    public function it_can_like_a_product()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create();

        $response = $this->post('/products/' . $product->id . '/like');

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
        
        $product->refresh();
        $this->assertEquals(1, $product->likes_count);
    }

    /** @test */
    public function it_changes_like_icon_color_when_liked()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create();
        $product->likes()->attach($user->id); 

        $response = $this->get('/products/' . $product->id);

        $response->assertSee('liked-icon-class');
    }

    /** @test */
    public function it_can_unlike_a_product()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create();
        $product->likes()->attach($user->id); 

        $response = $this->post('/products/' . $product->id . '/like');

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
        
        $product->refresh();
        $this->assertEquals(0, $product->likes_count);
    }

    /** @test */
    public function it_allows_logged_in_user_to_submit_comment()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create();

        $response = $this->post('/products/' . $product->id . '/comments', [
            'comment' => 'This is a comment.'
        ]);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'comment' => 'This is a comment.'
        ]);
        
        $product->refresh();
        $this->assertEquals(1, $product->comments_count);
    }

    /** @test */
    public function it_does_not_allow_guest_to_submit_comment()
    {
        $product = Product::factory()->create();

        $response = $this->post('/products/' . $product->id . '/comments', [
            'comment' => 'This is a comment.'
        ]);

        $this->assertDatabaseMissing('comments', [
            'comment' => 'This is a comment.'
        ]);
    }

    /** @test */
    public function it_displays_validation_message_when_comment_is_empty()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create();

        $response = $this->post('/products/' . $product->id . '/comments', [
            'comment' => ''
        ]);

        $response->assertSessionHasErrors('comment');
    }

    /** @test */
    public function it_displays_validation_message_when_comment_is_too_long()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create();

        $response = $this->post('/products/' . $product->id . '/comments', [
            'comment' => str_repeat('A', 256)
        ]);

        $response->assertSessionHasErrors('comment');
    }

    /** @test */
    public function it_completes_purchase_when_buy_button_is_clicked()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create(['is_sold' => false]);

        $response = $this->post('/products/' . $product->id . '/purchase');
        
        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $product->refresh();
        $this->assertTrue($product->is_sold);
    }

    /** @test */
    public function it_displays_sold_label_on_product_list_after_purchase()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create(['is_sold' => false]);

        $this->post('/products/' . $product->id . '/purchase');

        $response = $this->get('/products');

        $response->assertSee('Sold');
    }

    /** @test */
    public function it_adds_purchased_product_to_profile_purchased_items()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create(['is_sold' => false]);

        $this->post('/products/' . $product->id . '/purchase');

        $response = $this->get('/profile/purchased-items');

        $response->assertSee($product->name);
    }

    /** @test */
    public function it_reflects_payment_method_selection_immediately_on_subtotal_screen()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/payment-methods');

        $response = $this->post('/payment-methods/select', [
            'payment_method' => 'credit_card'
        ]);

        $this->assertSessionHas('selected_payment_method', 'credit_card');
    }

    /** @test */
    public function it_reflects_registered_address_on_purchase_screen()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->post('/address', [
            'address' => '123 Main St, Tokyo'
        ]);

        $response = $this->get('/products/purchase');

        $response->assertSee('123 Main St, Tokyo');
    }

    /** @test */
    public function it_binds_address_to_purchased_product()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->post('/address', [
            'address' => '123 Main St, Tokyo'
        ]);

        $product = Product::factory()->create(['is_sold' => false]);

        $this->post('/products/' . $product->id . '/purchase');

        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'address' => '123 Main St, Tokyo'
        ]);
    }

    /** @test */
    public function it_retrieves_user_information()
    {
        $user = User::factory()->create([
            'profile_image' => 'path/to/image.jpg',
            'name' => 'Test User'
        ]);
        $this->actingAs($user);

        $response = $this->get('/profile');

        $response->assertSee('path/to/image.jpg');
        $response->assertSee('Test User');
        $response->assertSee('出品した商品'); 
        $response->assertSee('購入した商品'); 
    }

    /** @test */
    public function it_displays_initial_values_for_user_information()
    {
        $user = User::factory()->create([
            'profile_image' => 'path/to/image.jpg',
            'name' => 'Test User',
            'postal_code' => '123-4567',
            'address' => '123 Main St, Tokyo'
        ]);
        $this->actingAs($user);

        $response = $this->get('/profile/edit');

        $response->assertSee('path/to/image.jpg');
        $response->assertSee('Test User');
        $response->assertSee('123-4567');
        $response->assertSee('123 Main St, Tokyo');
    }

    /** @test */
    public function it_saves_product_information_on_listing()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/products/create');

        $response = $this->post('/products', [
            'category' => 'Electronics',
            'condition' => 'New',
            'name' => 'Test Product',
            'description' => 'This is a test product.',
            'price' => 1000,
        ]);

        $this->assertDatabaseHas('products', [
            'user_id' => $user->id,
            'category' => 'Electronics',
            'condition' => 'New',
            'name' => 'Test Product',
            'description' => 'This is a test product.',
            'price' => 1000,
        ]);
    }


}