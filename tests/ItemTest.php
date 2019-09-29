<?php

class ItemTest extends TestCase
{
    protected $faker;
    protected $checklist;

    public function setUp(): void
    {
        parent::setUp();

        $this->faker = \Faker\Factory::create();
        $this->checklist = \App\Checklist::orderBy('created_at', 'desc')->first();
    }

    /**
     * Test List All Items
     *
     * @return void
     */
    public function testListAllItems()
    {
        /* get user */
        $user = \App\User::find(1);

        /* send request */
        $this->actingAs($user)->get('/api/checklists/items');

        /* check status code */
        $this->seeStatusCode(200);

        /* check response structure */
        $this->seeJsonStructure([
            'data' => [
                '*' => [
                    'type',
                    'id',
                    'attributes' => [
                        'description',
                        'is_completed',
                        'completed_at',
                        'due',
                        'urgency',
                        'checklist_id',
                        'created_by',
                        'updated_by',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ],
            'meta' => [
                'count',
                'total',
            ],
            'links' => [
                'first',
                'last',
            ],
        ]);
    }

    /**
     * Test List All Items
     *
     * @return void
     */
    public function testListAllItemsByChecklist()
    {
        /* get user */
        $user = \App\User::find(1);

        /* send request */
        $this->actingAs($user)->get('/api/checklists/' . $this->checklist->id . '/items');

        /* check status code */
        $this->seeStatusCode(200);

        /* check response structure */
        $this->seeJsonStructure([
            'data' => [
                'type',
                'id',
                'attributes' => [
                    'description',
                    'due',
                    'urgency',
                    'task_id',
                    'object_id',
                    'object_domain',
                    'is_completed',
                    'completed_at',
                    'last_update_by',
                    'created_at',
                    'updated_at',
                    'items' => [
                        '*' => [
                            'id',
                            'description',
                            'is_completed',
                            'completed_at',
                            'due',
                            'urgency',
                            'checklist_id',
                            'created_by',
                            'updated_by',
                            'created_at',
                            'updated_at',
                        ],
                    ],
                ],
            ],
        ]);
    }

    /**
     * Test Get Single Item
     *
     * @return void
     */
    public function testGetItem()
    {
        /* get user */
        $user = \App\User::find(1);

        /* get item */
        $item = \App\ChecklistItem::orderBy('created_at', 'desc')->first();

        /* send request */
        $this->actingAs($user)->get('/api/checklists/' . $item->checklist_id . '/items/' . $item->id);

        /* check status code */
        $this->seeStatusCode(200);

        /* check response structure */
        $this->seeJsonStructure([
            'data' => [
                'type',
                'id',
                'attributes' => [
                    'description',
                    'is_completed',
                    'completed_at',
                    'due',
                    'urgency',
                    'checklist_id',
                    'created_by',
                    'updated_by',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }

    /**
     * Test Create a New Item
     *
     * @return void
     */
    public function testCreateItem()
    {
        /* get user */
        $user = \App\User::find(1);

        /* send request */
        $this->actingAs($user)->json('post', '/api/checklists/' . $this->checklist->id . '/items', [
            'data' => [
                'attribute' => [
                    'description' => $this->faker->sentence(rand(3, 6)),
                    'due' => \Carbon\Carbon::now(),
                    'urgency' => rand(1, 5),
                    'checklist_id' => $this->checklist->id,
                ],
            ],
        ]);

        /* check status code */
        $this->seeStatusCode(201);

        /* check response structure */
        $this->seeJsonStructure([
            'data' => [
                'type',
                'id',
                'attributes' => [
                    'description',
                    'is_completed',
                    'completed_at',
                    'due',
                    'urgency',
                    'checklist_id',
                    'created_by',
                    'updated_by',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }

    /**
     * Test Update Item
     *
     * @return void
     */
    public function testUpdateItem()
    {
        /* get user */
        $user = \App\User::find(1);

        /* get item */
        $item = \App\ChecklistItem::orderBy('created_at', 'desc')->first();

        /* send request */
        $this->actingAs($user)->json('patch', '/api/checklists/' . $item->checklist_id . '/items/' . $item->id, [
            'data' => [
                'attribute' => [
                    'description' => $this->faker->sentence(rand(3, 6)),
                    'due' => \Carbon\Carbon::now(),
                    'urgency' => rand(1, 5),
                    'checklist_id' => $this->checklist->id,
                ],
            ],
        ]);

        /* check status code */
        $this->seeStatusCode(200);

        /* check response structure */
        $this->seeJsonStructure([
            'data' => [
                'type',
                'id',
                'attributes' => [
                    'description',
                    'is_completed',
                    'completed_at',
                    'due',
                    'urgency',
                    'checklist_id',
                    'created_by',
                    'updated_by',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }

    /**
     * Test Delete Item
     *
     * @return void
     */
    public function testDeleteItem()
    {
        /* get user */
        $user = \App\User::find(1);

        /* get item */
        $item = \App\ChecklistItem::orderBy('created_at', 'desc')->first();

        /* send request */
        $this->actingAs($user)->json('delete', '/api/checklists/' . $item->checklist_id . '/items/' . $item->id);

        /* check status code */
        $this->seeStatusCode(204);
    }

    public function testComplete()
    {
        /* get user */
        $user = \App\User::find(1);

        /* get item */
        $items = \App\ChecklistItem::inRandomOrder()->take(5)->get();
        foreach ($items as $item) {
            $data[] = [
                'item_id' => $item->id,
            ];
        }

        /* send request */
        $this->actingAs($user)->json('post', '/api/checklists/complete', [
            'data' => $data,
        ]);

        /* check status code */
        $this->seeStatusCode(200);

        /* check response structure */
        $this->seeJsonStructure([
            'success',
            'message',
            'data' => [
                '*' => [
                    'id',
                    'is_completed',
                    'checklist_id',
                ],
            ],
        ]);
    }

    public function testUncomplete()
    {
        /* get user */
        $user = \App\User::find(1);

        /* get item */
        $items = \App\ChecklistItem::inRandomOrder()->take(5)->get();
        foreach ($items as $item) {
            $data[] = [
                'item_id' => $item->id,
            ];
        }

        /* send request */
        $this->actingAs($user)->json('post', '/api/checklists/uncomplete', [
            'data' => $data,
        ]);

        /* check status code */
        $this->seeStatusCode(200);

        /* check response structure */
        $this->seeJsonStructure([
            'success',
            'message',
            'data' => [
                '*' => [
                    'id',
                    'is_completed',
                    'checklist_id',
                ],
            ],
        ]);
    }
}
