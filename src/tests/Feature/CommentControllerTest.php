<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Memory;
use App\Models\Comment;
use App\Models\Family;


class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }


    /** @test */
    public function store_familyid設定前にコメントの新規登録に成功する() //自分が投稿した思い出に対してのみコメント
    {
        $this->actingAs($this->user);
        $memory = Memory::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $data = ['body' => 'コメント新規登録テスト'];
        $response = $this->post(route('comments.store', ['memory_id' => $memory->id]), $data);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('memories.show', ['memory' => $memory]));
        $this->assertDatabaseHas('comments',  [
            'memory_id' => $memory->id,
            'body' => 'コメント新規登録テスト'
            ]);
    }

    /** @test */
    public function store_familyid設定後にコメントの新規登録に成功する() //同じfamily_idに紐づく思い出に対してコメント
    {
        $this->actingAs($this->user);
        $this->user->userDetail = UserDetail::factory()->create(['user_id' => $this->user->id]);
        $family = Family::factory()->create();
        $this->user->userDetail->family_id = $family->id;
        $memory = Memory::factory()->for($family)->create();

        $data = ['body' => '家族からのコメント新規登録テスト'];
        $response = $this->post(route('comments.store', ['memory_id' => $memory->id]), $data);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('memories.show', ['memory' => $memory]));
        $this->assertDatabaseHas('comments',  [
            'memory_id' => $memory->id,
            'body' => '家族からのコメント新規登録テスト'
            ]);
    }



    /** @test */
    public function destroy_コメントの削除に成功する()
    {
        $this->actingAs($this->user);
        $memory = Memory::factory()->create();
        $comment = Comment::factory()->create([
            'user_id' => $this->user->id,
            'memory_id' => $memory->id,
            'body' => 'コメント削除テスト'
        ]);

        $response = $this->delete(route('comments.destroy', $comment));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('memories.show', ['memory' => $memory]));
        $this->assertDatabaseMissing('memories', [
            'user_id' => $this->user->id,
            'memory_id' => $memory->id,
            'body' => 'コメント削除テスト'
        ]);
    }
}
