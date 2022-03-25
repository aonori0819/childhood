<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\UserDetail;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();

    }

    /** @test */
    public function show_ユーザー詳細情報画面の表示に成功する()
    {
        $this->actingAs($this->user);

        $data = [
            'user' => $this->user,
            'family' => null,
            'user_details' => null,
            'children' => null,
        ];
        $response = $this->get(route('users.show', ['user' => $this->user]), $data);

        $response->assertStatus(200)
                 ->assertViewIs('users.show')
                 ->assertViewHas('data');
    }


    /** @test */
    public function create_ユーザー詳細情報の新規登録画面の表示に成功する()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('users.create',['user' => $this->user]));

        $response->assertStatus(200)
                 ->assertViewIs('users.create');
    }

    /** @test */
    public function store_ユーザー詳細情報の新規登録に成功する()
    {
        $this->actingAs($this->user);
        UserDetail::factory()->create([
            'user_id' => $this->user->id,
            'relation_to_child' => null,
            'icon_path' => null,
        ]);

        $data = ['user_id' => $this->user->id,
                 'name' => 'テストユーザー',
                 'relation_to_child' => '母'];
        $response = $this->post(route('users.store',['user' => $this->user]), $data);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('users.show',['user' => $this->user]));
        $this->assertDatabaseHas('users',  [
            'name' => 'テストユーザー'
            ]);
        $this->assertDatabaseHas('user_details',  [
            'relation_to_child' => '母'
            ]);
    }

    /** @test */
    public function edit_ユーザー詳細情報編集画面の表示に成功する()
    {
        $this->actingAs($this->user);
        $this->user->user_detail = UserDetail::factory()->for($this->user)->create();

        $response = $this->get(route('users.edit',['user' => $this->user]));

        $response->assertStatus(200)
                 ->assertViewIs('users.edit');
    }

    /** @test */
    public function update_ユーザー詳細情報の更新に成功する()
    {
        $this->actingAs($this->user);
        $this->user->user_detail = UserDetail::factory()->for($this->user)->create();

        $data = ['user_id' => $this->user->id,
                 'name' => '更新テストユーザー',
                 'relation_to_child' => '父'];
        $response = $this->patch(route('users.update',['user' => $this->user]), $data);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('users.show',['user' => $this->user]));
        $this->assertDatabaseHas('users',  [
            'name' => '更新テストユーザー'
            ]);
        $this->assertDatabaseHas('user_details',  [
            'relation_to_child' => '父'
            ]);
    }
}
