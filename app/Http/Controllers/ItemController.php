<?php

namespace App\Http\Controllers;

use App\Repositories\ChecklistItemRepository;
use App\Repositories\ChecklistWithItemRepository;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    protected $repository;
    protected $cli_repository;

    public function __construct(ChecklistItemRepository $repository, ChecklistWithItemRepository $cli_repository)
    {
        $this->repository = $repository;
        $this->cli_repository = $cli_repository;
    }

    public function index(Request $r)
    {
        return $this->repository->paginate(10);
    }

    public function indexByChecklist(Request $r, $id)
    {
        return $this->cli_repository->find($id);
    }

    public function show(Request $r, $id, $item_id)
    {
        $collect = collect($this->repository->findWhere([
            'checklist_id' => $id,
            'id' => $item_id,
        ])['data']);
        $data['data'] = $collect->first();

        return $data;
    }

    public function store(Request $r, $id)
    {
        $checklist = \App\Checklist::find($id);
        if (!$checklist) {
            return response()->json([
                'success' => false,
                'message' => 'Checklist not found!',
            ], 404);
        }

        /* create */
        $attr = $r->input('data.attribute');
        $attr['due'] = \Carbon\Carbon::parse($attr['due']);
        $attr['created_by'] = \Auth::user()->id;
        $create = $this->repository->create($attr);

        return response()->json($create, 201);
    }

    public function update(Request $r, $id, $item_id)
    {
        /* save the checklist */
        $checklist = \App\Checklist::find($id);
        if (!$checklist) {
            return response()->json([
                'success' => false,
                'message' => 'Checklist not found!',
            ], 404);
        }

        $item = \App\ChecklistItem::where('checklist_id', $checklist->id)->find($item_id);
        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Checklist item not found!',
            ], 404);
        }

        /* create */
        $attr = $r->input('data.attribute');
        $attr['due'] = \Carbon\Carbon::parse($attr['due']);
        $attr['updated_by'] = \Auth::user()->id;
        $update = $this->repository->update($attr, $item->id);

        return response()->json($update);
    }

    public function destroy(Request $r, $id, $item_id)
    {
        $checklist = \App\Checklist::find($id);
        if (!$checklist) {
            return response()->json([
                'success' => false,
                'message' => 'Checklist not found!',
            ], 404);
        }

        $item = \App\ChecklistItem::where('checklist_id', $checklist->id)->find($item_id);
        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Checklist item not found!',
            ], 404);
        }

        /* delete */
        $delete = $this->repository->delete($item->id);

        return response('', 204);
    }

    public function complete(Request $r, $complete = true)
    {
        $data = [];
        $items = $r->input('data');
        foreach ($items as $item) {
            $cl_item = \App\ChecklistItem::find($item['item_id']);
            $cl_item->is_completed = $complete ? 1 : 0;
            $cl_item->completed_at = $complete ? \Carbon\Carbon::now() : null;
            $cl_item->save();

            $data[] = [
                'id' => $cl_item->id,
                'item_id' => $cl_item->id,
                'is_completed' => $cl_item->is_completed ? true : false,
                'checklist_id' => $cl_item->checklist_id,
            ];
        }

        return response()->json([
            'data' => $data,
        ]);
    }

    public function uncomplete(Request $r)
    {
        return $this->complete($r, false);
    }
}
