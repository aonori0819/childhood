<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Memory;

class MemoryControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }


    /** @test */
    public function index_思い出一覧画面の表示に成功する()
    {
        $this->artisan('db:seed', ['--class' => 'MemoryTableSeeder']);

        $response = $this->actingAs($this->user)
                         ->get('/');

        $response->assertStatus(200)
                 ->assertViewIs('memories.index')
                 ->assertViewHas('memories');
    }

    /** @test */
    public function index_ログインしていない場合は思い出一覧のURLにアクセスしてもログイン画面が表示される()
    {
        $response = $this->get('/');
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function show_思い出詳細画面の表示に成功する()
    {
        $this->actingAs($this->user);
        $memory = Memory::factory()->create([
            'user_id' => $this->user->id,
        ]);


        $response = $this->get(route('memories.show', ['memory' => $memory]));

        $response->assertStatus(200)
                 ->assertViewIs('memories.show')
                 ->assertViewHas('memory');
    }

    /** @test */
    public function create_思い出新規作成画面の表示に成功する()
    {
        $this->artisan('db:seed', ['--class' => 'MemoryTableSeeder']);
        $this->actingAs($this->user);

        $response = $this->get(route('memories.create'));

        $response->assertStatus(200)
                    ->assertViewIs('memories.create');
    }

    /** @test */
    public function store_思い出の新規登録に成功する()
    {
        $this->actingAs($this->user);

        $data = ['body' => '新規登録テスト'];
        $response = $this->post(route('memories.store'), $data);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect('/');
        $this->assertDatabaseHas('memories',  [
            'body' => '新規登録テスト'
            ]);
    }

    /** @test */
    public function edit_思い出編集画面の表示に成功する()
    {
        $this->actingAs($this->user);
        $memory = Memory::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->get(route('memories.edit', ['memory' => $memory]));

        $response->assertStatus(200)
                    ->assertViewIs('memories.edit')
                    ->assertViewHas('memory');
    }

    /** @test */
    public function update_思い出の更新に成功する()
    {
        $this->actingAs($this->user);
        $memory = Memory::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $data = ['body'=>'思い出編集テスト'];
        $response = $this->put(route('memories.update', $memory), $data);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect('/');
        $this->assertDatabaseHas('memories', $data);
    }

    /** @test */
    public function destroy_思い出の削除に成功する()
    {
        $this->actingAs($this->user);
        $memory = Memory::factory()->create([
            'user_id' => $this->user->id,
            'body' => '思い出削除テスト'
        ]);

        $response = $this->delete(route('memories.destroy', $memory));

        $response->assertSessionHasNoErrors();
        $response->assertRedirect('/');
        $this->assertDatabaseMissing('memories', [
            'user_id' => $this->user->id,
            'body' => '思い出削除テスト'
        ]);
    }

}
