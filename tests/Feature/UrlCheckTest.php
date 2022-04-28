<?php

namespace Tests\Feature;

use App\Models\Url;
use App\Models\UrlCheck;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
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
        $url = URL::first();
        $response = $this->get(route('urls.show', $url));
        $response->assertOk();
    }

    public function testStore()
    {
        $url = URL::first();
        $data = UrlCheck::factory()->for($url)->make()->toArray();
        dump($data);
        $response = $this->post(route('url_checks.store', $url), $data);
        $response->assertRedirect(route('urls.show', $url));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('url_checks', $data);
    }
}
