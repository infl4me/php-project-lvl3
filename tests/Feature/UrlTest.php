<?php

namespace Tests\Feature;

use App\Models\Url;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\CreatesApplication;
use Tests\TestCase;

class UrlTest extends TestCase
{
    use DatabaseTransactions;
    use DatabaseMigrations;

    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        Url::factory()->count(2)->create();
    }

    public function testIndex()
    {
        $response = $this->get(route('urls.index'));
        $response->assertOk();
    }

    public function testStore()
    {
        $data = Url::factory()->make()->only('name');
        $response = $this->post(route('urls.store'), ['url' => ['name' => $data['name']]]);
        $url = Url::latest('id')->first();
        $response->assertRedirect(route('urls.show', $url));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('urls', $data);
    }
}
