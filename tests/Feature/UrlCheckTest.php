<?php

namespace Tests\Feature;

use App\Models\Url;
use App\Models\UrlCheck;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Http;
use Tests\CreatesApplication;
use Tests\TestCase;

class UrlCheckTest extends TestCase
{
    use DatabaseTransactions;
    use DatabaseMigrations;

    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        UrlCheck::factory()->forUrl()->count(2)->create();
    }

    public function testIndex()
    {
        $url = Url::first();
        $response = $this->get(route('urls.show', $url));
        $response->assertOk();
    }

    public function testStore()
    {
        $url = Url::first();
        $data = UrlCheck::factory()->for($url)->make()->toArray();

        $html = file_get_contents(__DIR__ . '/../fixtures/laravel.html');
        Http::fake([
            '*' => Http::response($html, 200, ['Headers']),
        ]);
        $response = $this->post(route('url_checks.store', $url), $data);
        $response->assertRedirect(route('urls.show', $url));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('url_checks', [
            'h1' => 'The PHP Framework for Web Artisans',
            'title' => 'Laravel - The PHP Framework For Web Artisans',
            'description' => 'Laravel is a PHP web application framework with expressive, elegant syntax. We’ve already laid the foundation — freeing you to create without sweating the small things.',
        ]);
    }

    public function testStoreEmpty()
    {
        $url = Url::first();
        $data = UrlCheck::factory()->for($url)->make()->toArray();

        $html = file_get_contents(__DIR__ . '/../fixtures/empty.html');
        Http::fake([
            '*' => Http::response($html, 200, ['Headers']),
        ]);
        $response = $this->post(route('url_checks.store', $url), $data);
        $response->assertRedirect(route('urls.show', $url));
        $response->assertSessionHasNoErrors();
    }
}
