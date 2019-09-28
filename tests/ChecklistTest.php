<?php

use Faker\Factory;

class ChecklistTest extends TestCase
{
    protected $faker;

    public function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
    }

    /**
     * Test List All Checklists
     *
     * @return void
     */
    public function testListAllChecklists()
    {
        /* get user */
        $user = \App\User::find(1);

        /* send request */
        $this->actingAs($user)->get('/api/checklists');

        /* check status code */
        $this->seeStatusCode(200);

        /* check response structure */
        $this->seeJsonStructure([
            'current_page',
            'data' => [
                '*' => [
                    'id',
                    'description',
                    'due',
                    'urgency',
                    'task_id',
                    'object_id',
                    'object_domain',
                    'is_completed',
                    'completed_at',
                    'updated_by',
                    'created_at',
                    'updated_at',
                ],
            ],
            'first_page_url',
            'last_page_url',
            'next_page_url',
            'prev_page_url',
            'total',
        ]);
    }

    /**
     * Test Get Single Checklist
     *
     * @return void
     */
    public function testGetChecklist()
    {
        /* get user */
        $user = \App\User::find(1);

        /* get checklist */
        $checklist = \App\Checklist::orderBy('created_at', 'desc')->first();

        /* send request */
        $this->actingAs($user)->get('/api/checklists/' . $checklist->id);

        /* check status code */
        $this->seeStatusCode(200);

        /* check response structure */
        $this->seeJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
                'description',
                'due',
                'urgency',
                'task_id',
                'object_id',
                'object_domain',
                'is_completed',
                'completed_at',
                'updated_by',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    /**
     * Test Create a New Checklist
     *
     * @return void
     */
    public function testCreateChecklist()
    {
        /* get user */
        $user = \App\User::find(1);

        /* send request */
        $this->actingAs($user)->json('post', '/api/checklists', [
            'data' => [
                'description' => $this->faker->sentence(6),
                'object_domain' => $this->faker->word,
                'object_id' => rand(1, 10),
                'due' => \Carbon\Carbon::now(),
                'urgency' => rand(1, 5),
                'items' => [
                    $this->faker->sentence(rand(3, 6)),
                    $this->faker->sentence(rand(3, 6)),
                    $this->faker->sentence(rand(3, 6)),
                ],
                'task_id' => rand(1, 100),
            ],
        ]);

        /* check status code */
        $this->seeStatusCode(201);

        /* check response structure */
        $this->seeJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
                'description',
                'object_domain',
                'object_id',
                'task_id',
                'due',
                'urgency',
                'is_completed',
                'completed_at',
                'created_by',
                'updated_by',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    /**
     * Test Update Checklist
     *
     * @return void
     */
    public function testUpdateChecklist()
    {
        /* get user */
        $user = \App\User::find(1);

        /* get checklist */
        $checklist = \App\Checklist::orderBy('created_at', 'desc')->first();

        /* send request */
        $is_complete = rand(0, 1);
        $this->actingAs($user)->json('patch', '/api/checklists/' . $checklist->id, [
            'data' => [
                'description' => $this->faker->sentence(6),
                'object_domain' => $this->faker->word,
                'object_id' => rand(1, 10),
                'is_completed' => $is_complete,
                'completed_at' => $is_complete ? \Carbon\Carbon::now() : null,
            ],
        ]);

        /* check status code */
        $this->seeStatusCode(201);

        /* check response structure */
        $this->seeJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
                'description',
                'object_domain',
                'object_id',
                'task_id',
                'due',
                'urgency',
                'is_completed',
                'completed_at',
                'created_by',
                'updated_by',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    /**
     * Test Delete Checklist
     *
     * @return void
     */
    public function testDeleteChecklist()
    {
        /* get user */
        $user = \App\User::find(1);

        /* get checklist */
        $checklist = \App\Checklist::orderBy('created_at', 'desc')->first();

        /* send request */
        $this->actingAs($user)->json('delete', '/api/checklists/' . $checklist->id);

        /* check status code */
        $this->seeStatusCode(204);
    }
}
