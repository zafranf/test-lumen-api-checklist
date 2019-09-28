<?php

use Faker\Factory;

class TemplateTest extends TestCase
{
    protected $faker;

    public function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();
    }

    /**
     * Test List All Templates
     *
     * @return void
     */
    public function testListAllTemplates()
    {
        /* get user */
        $user = \App\User::find(1);

        /* send request */
        $this->actingAs($user)->get('/api/templates');

        /* check status code */
        $this->seeStatusCode(200);

        /* check response structure */
        $this->seeJsonStructure([
            'current_page',
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'checklist' => [
                        'description',
                        'due_interval',
                        'due_unit',
                        'items' => [
                            '*' => [
                                'description',
                                'urgency',
                                'due_interval',
                                'due_unit',
                            ],
                        ],
                    ],
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
     * Test Get Single Template
     *
     * @return void
     */
    public function testGetTemplate()
    {
        /* get user */
        $user = \App\User::find(1);

        /* send request */
        $this->actingAs($user)->get('/api/templates/1');

        /* check status code */
        $this->seeStatusCode(200);

        /* check response structure */
        $this->seeJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
                'name',
                'checklist' => [
                    'description',
                    'due_interval',
                    'due_unit',
                    'items' => [
                        '*' => [
                            'description',
                            'urgency',
                            'due_interval',
                            'due_unit',
                        ],
                    ],
                ],
            ],
        ]);
    }

    /**
     * Test Create a New Template
     *
     * @return void
     */
    public function testCreateTemplate()
    {
        /* get user */
        $user = \App\User::find(1);

        /* send request */
        $this->actingAs($user)->json('post', '/api/templates', [
            'data' => [
                'name' => $this->faker->name,
                'checklist' => [
                    'description' => $this->faker->sentence(6),
                    'due_interval' => rand(1, 2),
                    'due_unit' => 'hour',
                ],
                'items' => [
                    [
                        'description' => $this->faker->sentence(rand(3, 5)),
                        'urgency' => rand(0, 3),
                        'due_interval' => rand(1, 60),
                        'due_unit' => 'minute',
                    ],
                    [
                        'description' => $this->faker->sentence(rand(3, 5)),
                        'urgency' => rand(0, 3),
                        'due_interval' => rand(1, 60),
                        'due_unit' => 'minute',
                    ],
                ],
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
                'name',
                'checklist' => [
                    'description',
                    'due_interval',
                    'due_unit',
                    'items' => [
                        '*' => [
                            'description',
                            'urgency',
                            'due_interval',
                            'due_unit',
                        ],
                    ],
                ],
            ],
        ]);
    }

    /**
     * Test Update Template
     *
     * @return void
     */
    public function testUpdateTemplate()
    {
        /* get user */
        $user = \App\User::find(1);

        /* get template */
        $template = \App\Template::orderBy('created_at', 'desc')->first();

        /* send request */
        $this->actingAs($user)->json('patch', '/api/templates/' . $template->id, [
            'data' => [
                'name' => $this->faker->name,
                'checklist' => [
                    'description' => $this->faker->sentence(6),
                    'due_interval' => rand(1, 2),
                    'due_unit' => 'hour',
                ],
                'items' => [
                    [
                        'description' => $this->faker->sentence(rand(3, 5)),
                        'urgency' => rand(0, 3),
                        'due_interval' => rand(1, 60),
                        'due_unit' => 'minute',
                    ],
                    [
                        'description' => $this->faker->sentence(rand(3, 5)),
                        'urgency' => rand(0, 3),
                        'due_interval' => rand(1, 60),
                        'due_unit' => 'minute',
                    ],
                ],
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
                'name',
                'checklist' => [
                    'description',
                    'due_interval',
                    'due_unit',
                    'items' => [
                        '*' => [
                            'description',
                            'urgency',
                            'due_interval',
                            'due_unit',
                        ],
                    ],
                ],
            ],
        ]);
    }

    /**
     * Test Delete Template
     *
     * @return void
     */
    public function testDeleteTemplate()
    {
        /* get user */
        $user = \App\User::find(1);

        /* get template */
        $template = \App\Template::orderBy('created_at', 'desc')->first();

        /* send request */
        $this->actingAs($user)->json('delete', '/api/templates/' . $template->id);

        /* check status code */
        $this->seeStatusCode(204);
    }
}
