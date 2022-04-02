<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Memory;
use App\Models\Child;
use App\Models\Family;

class FilterControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function index_思い出ふりかえり一覧の表示に成功する()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('filters.index'));

        $response->assertStatus(200)
                 ->assertViewIs('filters.index');
    }

    /** @test */
    public function showByChild_お子さまごとの思い出一覧の表示に成功する()
    {
        $this->actingAs($this->user);
        $this->user->userDetail = UserDetail::factory()->for($this->user)->create();
        $family = Family::factory()->create();
        $this->user->userDetail->family_id = $family->id;
        $child = Child::factory()->for($family)->create();

        $response = $this->get(route('filters.showByChild',['child_id' => $child->id]));

        $response->assertStatus(200)
                    ->assertViewIs('filters.show_child');
    }

    /** @test */
    public function showByMonth_年月ごとの思い出一覧の表示に成功する()
    {
        $this->actingAs($this->user);
        $this->user->userDetail = UserDetail::factory()->for($this->user)->create();
        $family = Family::factory()->create();
        $this->user->userDetail->family_id = $family->id;
        $memory = Memory::factory()->for($family->)->create();

        $month_year = $memory->created_at->format('Y-m');

        $response = $this->get(route('filters.showByMonth',['month_year' => $month_year]));

        $response->assertStatus(200)
                    ->assertViewIs('filters.show_month');
    }

}
