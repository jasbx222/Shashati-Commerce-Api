<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\WorkTime;

class CheckWorkTimeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_allows_access_within_work_time()
    {
        // وقت الدوام من 8 صباحاً إلى 11 مساءً
        WorkTime::create([
            'start_time' => '08:00:00',
            'end_time'   => '23:00:00',
        ]);

        $this->travelTo(now()->setTime(10, 0, 0)); // الساعة 10 الصبح

        $response = $this->getJson('/api/v1/order/products/1');

        $response->assertStatus(200); // يمر
    }

    /** @test */
    public function it_blocks_access_after_work_time()
    {
        WorkTime::create([
            'start_time' => '08:00:00',
            'end_time'   => '17:00:00',
        ]);

        $this->travelTo(now()->setTime(18, 0, 0)); // الساعة 6 المغرب

        $response = $this->getJson('/api/v1/order/products/1');

        $response->assertStatus(403) // ممنوع
                 ->assertJson([
                     'message' => 'لقد انتهى وقت الدوام الآن..'
                 ]);
    }
}
