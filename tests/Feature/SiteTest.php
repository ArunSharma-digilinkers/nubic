<?php

namespace Tests\Feature;

use App\Models\Enquiry;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\CatalogueSeeder;
use Tests\TestCase;

class SiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(CatalogueSeeder::class);
    }

    public function test_public_pages_render(): void
    {
        $product = Product::first();

        foreach (['/', '/products', '/contact', '/page/about-us', '/product/'.$product->slug, '/products/category/'.$product->category->slug, '/products?q=NES-0010'] as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_catalogue_is_seeded(): void
    {
        $this->assertSame(191, \App\Models\Variant::count());
        $this->assertDatabaseHas('variants', ['code' => 'NES-0191', 'mrp' => 2256.00]);
    }

    public function test_enquiry_can_be_submitted(): void
    {
        $this->post('/contact', ['name' => 'Test', 'phone' => '9999999999', 'message' => 'Need quote'])->assertSessionHasNoErrors();
        $this->assertSame(1, Enquiry::count());
    }

    public function test_admin_requires_login(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_admin_pages_render_and_crud_works(): void
    {
        $this->actingAs(User::factory()->create());
        $product = Product::first();

        foreach (['/admin', '/admin/products', '/admin/products/create', "/admin/products/{$product->id}/edit", '/admin/categories', '/admin/sliders',
            '/admin/sliders/create', '/admin/pages', '/admin/certifications', '/admin/enquiries', '/admin/settings', '/admin/account'] as $url) {
            $this->get($url)->assertOk();
        }

        $this->post('/admin/sliders', ['title' => 'Hello', 'is_active' => 1])->assertRedirect('/admin/sliders');
        $this->assertDatabaseHas('sliders', ['title' => 'Hello']);

        $this->put("/admin/products/{$product->id}", [
            'category_id' => $product->category_id, 'name' => 'Renamed', 'is_active' => 1,
            'variants' => [['code' => 'X-1', 'rating' => '10A', 'mrp' => '99']],
        ])->assertRedirect('/admin/products');
        $this->assertSame(1, $product->fresh()->variants()->count());

        $this->post('/admin/settings', ['site_name' => 'Nubic Test'])->assertRedirect();
        $this->assertSame('Nubic Test', \App\Models\Setting::get('site_name'));
    }
}
