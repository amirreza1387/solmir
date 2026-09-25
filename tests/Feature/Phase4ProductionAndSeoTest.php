<?php

namespace Tests\Feature;

use App\Models\Portfolio;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class Phase4ProductionAndSeoTest extends TestCase
{
    use RefreshDatabase;

    public function test_health_check_endpoint_returns_healthy_and_safe_response(): void
    {
        $response = $this->get('/health');

        $response->assertOk();
        $response->assertJson([
            'status' => 'healthy',
            'application' => 'Solmir',
            'database' => 'ok',
        ]);
        $response->assertJsonStructure([
            'status',
            'application',
            'database',
            'timestamp',
        ]);

        // Ensure no sensitive credentials or debug traces are leaked
        $content = $response->getContent();
        $this->assertStringNotContainsString('password', strtolower($content));
        $this->assertStringNotContainsString('trace', strtolower($content));
        $this->assertStringNotContainsString('sqlite', strtolower($content));
        $this->assertStringNotContainsString('app_key', strtolower($content));
    }

    public function test_health_check_endpoint_returns_503_when_database_fails(): void
    {
        DB::shouldReceive('connection->getPdo')
            ->andThrow(new \PDOException('Database connection lost'));

        $response = $this->get('/health');

        $response->assertStatus(503);
        $response->assertJson([
            'status' => 'degraded',
            'application' => 'Solmir',
            'database' => 'unavailable',
        ]);
        $response->assertJsonStructure([
            'status',
            'application',
            'database',
            'timestamp',
        ]);

        $content = $response->getContent();
        $this->assertStringNotContainsString('password', strtolower($content));
        $this->assertStringNotContainsString('trace', strtolower($content));
        $this->assertStringNotContainsString('exception', strtolower($content));
    }

    public function test_sitemap_xml_contains_public_routes_and_excludes_private_routes(): void
    {
        $service = Service::create([
            'title' => 'طراحی وب اختصاصی',
            'slug' => 'custom-web-design',
            'description' => 'توضیحات تست خدمت',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $portfolio = Portfolio::create([
            'title' => 'پروژه شاخص نمونه',
            'slug' => 'sample-featured-project',
            'description' => 'توضیحات نمونه کار',
            'category' => 'Web Design',
            'is_featured' => true,
        ]);

        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/xml; charset=UTF-8');

        $content = $response->getContent();
        $this->assertStringContainsString('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', $content);
        $this->assertStringContainsString('/services', $content);
        $this->assertStringContainsString('/portfolio', $content);
        $this->assertStringContainsString('/about', $content);
        $this->assertStringContainsString('/contact', $content);
        $this->assertStringContainsString('/services/custom-web-design', $content);
        $this->assertStringContainsString('/portfolio/sample-featured-project', $content);

        // Crucial: Must NEVER contain private/admin routes or auth links
        $this->assertStringNotContainsString('/admin', $content);
        $this->assertStringNotContainsString('/dashboard', $content);
        $this->assertStringNotContainsString('/api', $content);
        $this->assertStringNotContainsString('/login', $content);
        $this->assertStringNotContainsString('/register', $content);
        $this->assertStringNotContainsString('/reset-password', $content);
    }

    public function test_robots_txt_exists_and_blocks_private_areas(): void
    {
        $robotsPath = public_path('robots.txt');
        $this->assertFileExists($robotsPath);

        $content = file_get_contents($robotsPath);
        $this->assertStringContainsString('Allow: /', $content);
        $this->assertStringContainsString('Disallow: /admin', $content);
        $this->assertStringContainsString('Disallow: /dashboard', $content);
        $this->assertStringContainsString('Disallow: /api', $content);
        $this->assertStringContainsString('Disallow: /login', $content);
        $this->assertStringContainsString('Disallow: /register', $content);
        $this->assertStringContainsString('Sitemap: https://solmir.ir/sitemap.xml', $content);
    }

    public function test_favicons_and_manifest_exist_in_public(): void
    {
        $this->assertFileExists(public_path('favicon.ico'));
        $this->assertFileExists(public_path('favicon.png'));
        $this->assertFileExists(public_path('favicon-32x32.png'));
        $this->assertFileExists(public_path('favicon-16x16.png'));
        $this->assertFileExists(public_path('apple-touch-icon.png'));
        $this->assertFileExists(public_path('site.webmanifest'));

        $this->assertGreaterThan(0, filesize(public_path('favicon.ico')));
        $this->assertGreaterThan(0, filesize(public_path('favicon-32x32.png')));
    }

    public function test_web_manifest_is_valid_and_contains_required_fields(): void
    {
        $manifestPath = public_path('site.webmanifest');
        $this->assertFileExists($manifestPath);

        $json = json_decode(file_get_contents($manifestPath), true);
        $this->assertIsArray($json, 'site.webmanifest must be valid JSON');
        $this->assertArrayHasKey('name', $json);
        $this->assertArrayHasKey('short_name', $json);
        $this->assertArrayHasKey('start_url', $json);
        $this->assertEquals('/', $json['start_url']);
        $this->assertArrayHasKey('display', $json);
        $this->assertEquals('standalone', $json['display']);
        $this->assertArrayHasKey('theme_color', $json);
        $this->assertEquals('#2563eb', $json['theme_color']);
        $this->assertArrayHasKey('icons', $json);
        $this->assertNotEmpty($json['icons']);

        foreach ($json['icons'] as $icon) {
            $this->assertFileExists(public_path(ltrim($icon['src'], '/')));
        }
    }

    public function test_app_blade_loads_no_external_font_cdns(): void
    {
        $appBladePath = resource_path('views/app.blade.php');
        $this->assertFileExists($appBladePath);

        $content = file_get_contents($appBladePath);
        $this->assertStringNotContainsString('cdn.jsdelivr.net', $content);
        $this->assertStringNotContainsString('fonts.googleapis.com', $content);
        $this->assertStringNotContainsString('fonts.gstatic.com', $content);
    }

    public function test_shared_seo_props_are_provided_by_inertia_middleware(): void
    {
        $response = $this->get('/');
        $response->assertOk();

        $response->assertInertia(fn ($page) => $page
            ->has('seo')
            ->where('seo.appName', 'Solmir')
            ->where('seo.brandName', 'Solmir')
            ->where('seo.email', 'solmirofc@gmail.com')
            ->where('seo.phone', '09179278747')
        );
    }

    public function test_service_caching_and_cache_invalidation(): void
    {
        Cache::flush();

        $service1 = Service::create([
            'title' => 'خدمت اولیه',
            'slug' => 'initial-service',
            'description' => 'توضیحات اولیه',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $this->get('/services')->assertOk();
        $this->assertTrue(Cache::has('public.services.all'));

        // Creating or updating a service must invalidate the cache
        $service1->update(['title' => 'خدمت بروزرسانی شده']);
        $this->assertFalse(Cache::has('public.services.all'));

        // Querying services again repopulates the cache
        $this->get('/services')->assertOk();
        $this->assertTrue(Cache::has('public.services.all'));

        // Deleting the service invalidates the cache
        $service1->delete();
        $this->assertFalse(Cache::has('public.services.all'));
    }

    public function test_portfolio_caching_and_cache_invalidation(): void
    {
        Cache::flush();

        $portfolio = Portfolio::create([
            'title' => 'پروژه نمونه',
            'slug' => 'sample-project',
            'description' => 'توضیحات پروژه',
            'category' => 'Web Design',
            'is_featured' => true,
        ]);

        $this->get('/')->assertOk();
        $this->assertTrue(Cache::has('public.portfolios.featured'));

        // Update portfolio should clear cache
        $portfolio->update(['title' => 'پروژه تغییر یافته']);
        $this->assertFalse(Cache::has('public.portfolios.featured'));

        // Home request repopulates cache
        $this->get('/')->assertOk();
        $this->assertTrue(Cache::has('public.portfolios.featured'));

        // Delete clears cache
        $portfolio->delete();
        $this->assertFalse(Cache::has('public.portfolios.featured'));
    }

    public function test_security_regression_admin_routes_strictly_forbidden_for_regular_user(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($user)->get('/admin')->assertForbidden();
        $this->actingAs($user)->get('/admin/users')->assertForbidden();
        $this->actingAs($user)->get('/admin/orders')->assertForbidden();
        $this->actingAs($user)->get('/admin/tickets')->assertForbidden();
    }
}
