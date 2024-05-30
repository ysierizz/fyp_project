<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Question;
use App\Models\Assessment;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssessmentQuestionsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_assessment_questions()
    {
        $assessment = Assessment::factory()->create();
        $question = Question::factory()->create();

        $assessment->questions()->attach($question);

        $response = $this->getJson(
            route('api.assessments.questions.index', $assessment)
        );

        $response->assertOk()->assertSee($question->question_text);
    }

    /**
     * @test
     */
    public function it_can_attach_questions_to_assessment()
    {
        $assessment = Assessment::factory()->create();
        $question = Question::factory()->create();

        $response = $this->postJson(
            route('api.assessments.questions.store', [$assessment, $question])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $assessment
                ->questions()
                ->where('questions.id', $question->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_questions_from_assessment()
    {
        $assessment = Assessment::factory()->create();
        $question = Question::factory()->create();

        $response = $this->deleteJson(
            route('api.assessments.questions.store', [$assessment, $question])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $assessment
                ->questions()
                ->where('questions.id', $question->id)
                ->exists()
        );
    }
}
