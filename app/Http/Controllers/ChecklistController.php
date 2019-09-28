<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    public function index(Request $r)
    {
        $checklists = new \App\Checklist();

        if ($r->input('filter')) {
            $checklists = $checklists->where('description', 'like', '%' . $r->input('filter') . '%');
        }
        if ($r->input('sort')) {
            $checklists = $checklists->orderBy('created_at', $r->input('sort'));
        }

        $checklists = $checklists->paginate();

        return response()->json($checklists);
    }

    public function show(Request $r, $id)
    {
        $checklist = new \App\Checklist();
        if ($r->input('include') == 'items') {
            $checklist = $checklist->with('items');
        }
        $checklist = $checklist->find($id);
        if (!$checklist) {
            return response()->json([
                'success' => false,
                'message' => 'Checklist not found!',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Checklist found!',
            'data' => $checklist,
        ]);
    }

    public function store(Request $r)
    {
        /* save the checklist */
        $checklist = new \App\Checklist();
        $checklist->description = $r->input('data.description');
        $checklist->due = \Carbon\Carbon::parse($r->input('data.due'));
        $checklist->object_domain = $r->input('data.object_domain');
        $checklist->object_id = $r->input('data.object_id');
        $checklist->urgency = $r->input('data.urgency');
        $checklist->task_id = $r->input('data.task_id');
        $checklist->created_by = \Auth::user()->id;
        $checklist->save();

        /* save items */
        $this->saveItems($r, $checklist->id);

        /* return error */
        if (!$checklist) {
            return response()->json([
                'success' => false,
                'message' => 'Checklist not saved!',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Checklist saved!',
            'data' => \App\Checklist::find($checklist->id),
        ], 201);
    }

    public function update(Request $r, $id)
    {
        /* save the checklist */
        $checklist = \App\Checklist::find($id);
        if (!$checklist) {
            return response()->json([
                'success' => false,
                'message' => 'Checklist not found!',
            ], 404);
        }

        $checklist->description = $r->input('data.description');
        $checklist->due = \Carbon\Carbon::parse($r->input('data.due'));
        $checklist->object_domain = $r->input('data.object_domain');
        $checklist->object_id = $r->input('data.object_id');
        $checklist->urgency = $r->input('data.urgency');
        $checklist->task_id = $r->input('data.task_id');
        $checklist->updated_by = \Auth::user()->id;
        $checklist->save();

        /* return error */
        if (!$checklist) {
            return response()->json([
                'success' => false,
                'message' => 'Checklist not updated!',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Checklist updated!',
            'data' => $checklist,
        ], 201);
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
        $checklist->delete();

        return response('', 204);
    }

    public function saveItems(Request $r, $checklist_id, $is_update = false)
    {
        $items = $r->input('data.items');
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
