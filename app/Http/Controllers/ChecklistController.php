<?php

namespace App\Http\Controllers;

use App\Repositories\ChecklistRepository;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    protected $repository;

    public function __construct(ChecklistRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $r)
    {
        return $this->repository->paginate(10);
    }

    public function show(Request $r, $id)
    {
        return $this->repository->find($id);
    }

    public function store(Request $r)
    {
        /* create */
        $create = $this->repository->create($r->input('data.attributes'));

        /* save items */
        $this->saveItems($r, $create['data']['id']);

        return response()->json($create, 201);
    }

    public function update(Request $r, $id)
    {
        if (!$r->input('data.attributes')) {
            $data['attributes'] = $r->input('data');
            $r->merge([
                'data' => $data,
            ]);
        }

        /* save the checklist */
        $checklist = \App\Checklist::find($id);
        if (!$checklist) {
            return response()->json([
                'success' => false,
                'message' => 'Checklist not found!',
            ], 404);
        }

        /* create */
        $update = $this->repository->update($r->input('data.attributes'), $checklist->id);

        /* save items */
        if ($r->input('data.attributes.items')) {
            $this->saveItems($r, $update['data']['id']);
        }

        return response()->json($update);
    }

    public function destroy(Request $r, $id)
    {
        $checklist = \App\Checklist::find($id);
        if (!$checklist) {
            return response()->json([
                'success' => false,
                'message' => 'Checklist not found!',
            ], 404);
        }

        /* delete */
        $delete = $this->repository->delete($checklist->id);

        return response('', 204);
    }

    public function saveItems(Request $r, $checklist_id, $is_update = false)
    {
        $items = $r->input('data.attributes.items');
        foreach ($items as $item) {
            $cl_item = \App\ChecklistItem::firstOrNew(['description' => $item]);
            $cl_item->description = $item;
            /* $cl_item->urgency = $item['urgency'] ?? null;
            if (isset($item['due_internal']) && isset($item['due_unit'])) {
            $cl_item->due = \Carbon\Carbon::now()->add($item['due_interval'], $item['due_unit']);
            $cl_item->due_interval = $item['due_interval'];
            $cl_item->due_unit = $item['due_unit'];
            } */
            $cl_item->checklist_id = $checklist_id;
            if ($is_update) {
                $cl_item->updated_by = \Auth::user()->id;
            } else {
                $cl_item->created_by = \Auth::user()->id;
            }
            $cl_item->save();
        }
    }
}
