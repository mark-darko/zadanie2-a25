<?php

namespace Tests\Feature\Feedback;

use App\UseCases\AcceptFeedbackData;
use App\UseCases\FeedbackUseCases;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AcceptFeedbackTest extends TestCase
{
    use DatabaseTransactions;

    public function test_accept()
    {
        $feedback = app(FeedbackUseCases::class)->acceptFeedback(new AcceptFeedbackData(
            title: 'Test title',
            description: 'Test description',
            datetime: new \DateTime(),
            service_name: 'Магазин',
            rating: 3
        ));

        $this->assertEquals('Test title', $feedback->title);
        $this->assertEquals('Test description', $feedback->description);
    }

    public function test_accept_fromApi()
    {
        $response = $this->postJson(route('api.feedbacks.store'), [
            'title' => 'Test title',
            'description' => 'Test description',
            'datetime' => time(),
            'service_name' => 'Магазин',
            'rating' => 3,
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure(['id']);

        $id = $response->json('id');
        $responseFeedback = $this->getJson(route('api.feedbacks.show', ['feedback' => $id]));
        $responseFeedback->assertStatus(200);
        $responseFeedback->assertJson([
            'title' => 'Test title',
            'description' => 'Test description',
            'service_name' => 'Магазин',
            'rating' => 3,
        ]);
    }
}
