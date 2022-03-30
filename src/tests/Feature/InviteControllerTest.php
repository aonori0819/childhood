<?php

namespace Tests\Feature;

use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class InviteControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function index_家族招待メール送信ページの表示に成功する()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('invite.index'));

        $response->assertStatus(200)
                 ->assertViewIs('invite.index');
    }

    public function sendMail_家族招待メールの送信に成功する()
    {
        $this->actingAs($this->user);
        $request = new Request(['email' => $this->faker->safeEmail()]);

        $response = $this->post(route('invite.send'), compact('request'));

        $response->assertStatus(200)
                 ->assertViewIs('users.show');
        $this->assertDatabaseHas('invite', compact('email'));
    }
}
