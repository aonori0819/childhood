<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Family;

class FamilyControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function create_家族設定（ファミリー名）の新規登録画面の表示に成功する()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('families.create',['user' => $this->user]));

        $response->assertStatus(200)
                 ->assertViewIs('families.create');
    }

    /** @test */
    public function store_家族設定（ファミリー名）の新規登録に成功する()
    {
        $this->actingAs($this->user);
        UserDetail::factory()->create([
            'user_id' => $this->user->id,
            'relation_to_child' => null,
            'icon_path' => null,
        ]);

        $data = [ 'name' => 'テストファミリー'];
        $response = $this->post(route('families.store'), $data);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('users.show',['user' => $this->user]));
        $this->assertDatabaseHas('families',  [
            'name' => 'テストファミリー'
            ]);
        $this->assertDatabaseHas('user_details',  [
            'family_id' => $this->user->user_detail->family_id,
            ]);
    }

    /** @test */
    public function edit_家族設定（ファミリー名）編集画面の表示に成功する()
    {
        $this->actingAs($this->user);
        $this->user->user_detail = UserDetail::factory()->create(['user_id' => $this->user->id]);
        $family = Family::factory()->create();
        $this->user->user_detail->family_id = $family->id;

        $response = $this->get(route('families.edit',['family' => $family]));

        $response->assertStatus(200)
                 ->assertViewIs('families.edit');
    }

    /** @test */
    public function update_家族設定（ファミリー名）の更新に成功する()
    {
        $this->actingAs($this->user);
        $this->user->user_detail = UserDetail::factory()->create(['user_id' => $this->user->id]);
        $family = Family::factory()->create();
        $this->user->user_detail->family_id = $family->id;

        $data = ['name' => '更新テストファミリー',];
        $response = $this->patch(route('families.update',['family' => $family]), $data);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('users.show',['user' => $this->user]));
        $this->assertDatabaseHas('families',  [
            'name' => '更新テストファミリー'
            ]);
    }
}
