<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Memory;
use App\Models\Child;
use App\Models\Family;



class ChildControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function create_お子さま情報の新規登録画面の表示に成功する()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('children.create'));

        $response->assertStatus(200)
                 ->assertViewIs('children.create');
    }

    /** @test */
    public function store_お子さま情報の新規登録に成功する()
    {
        $this->actingAs($this->user);
        $this->user->user_detail = UserDetail::factory()->create(['user_id' => $this->user->id]);

        $data = ['name' => '花子',
                 'birthday' => '20170123'];
        $response = $this->post(route('children.store'), $data);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('users.show',['user' => $this->user]));
        $this->assertDatabaseHas('children',  [
            'name' => '花子',
            'birthday' => '20170123'
            ]);
    }

    /** @test */
    public function edit_お子さま情報編集画面の表示に成功する()
    {
        $this->actingAs($this->user);
        $this->user->user_detail = UserDetail::factory()->create(['user_id' => $this->user->id]);
        $family = Family::factory()->create();
        $this->user->user_detail->family_id = $family->id;
        $child = Child::factory()->create(['family_id' => $this->user->user_detail->family_id]);

        $response = $this->get(route('children.edit',['child' => $child]));

        $response->assertStatus(200)
                 ->assertViewIs('children.edit');
    }

    /** @test */
    public function update_お子さま情報の更新に成功する()
    {
        $this->actingAs($this->user);
        $this->user->user_detail = UserDetail::factory()->create(['user_id' => $this->user->id]);
        $family = Family::factory()->create();
        $this->user->user_detail->family_id = $family->id;
        $child = Child::factory()->create(['family_id' => $this->user->user_detail->family_id]);

        $data = ['name' => '太郎',
                 'birthday' => '20180101'];
        $response = $this->patch(route('children.update',['child' => $child]), $data);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('users.show',['user' => $this->user]));
        $this->assertDatabaseHas('children',  [
            'name' => '太郎',
            'birthday' => '20180101'
            ]);
    }

    /** @test */
    public function destroy_お子さま情報の削除に成功する()
    {
        $this->actingAs($this->user);
        $this->user->user_detail = UserDetail::factory()->create(['user_id' => $this->user->id]);
        $family = Family::factory()->create();
        $this->user->user_detail->family_id = $family->id;
        $child = Child::factory()->create([
            'family_id' => $this->user->user_detail->family_id,
            'name' => '二郎',
            'birthday' => '20191231'
        ]);

        $response = $this->delete(route('children.destroy', $child));

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('users.show',['user' => $this->user]));
        $this->assertDatabaseMissing('children', [
            'name' => '二郎',
            'birthday' => '20191231'
        ]);
    }
}