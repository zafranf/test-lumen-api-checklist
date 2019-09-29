<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * @group Checklist Item
 *
 * APIs for managing users
 */
class ItemController extends Controller
{
    public function index(Request $r)
    {
        $items = new \App\ChecklistItem();

        if ($r->input('filter')) {
            $items = $items->where('description', 'like', '%' . $r->input('filter') . '%');
        }
        if ($r->input('sort')) {
            $items = $items->orderBy('created_at', $r->input('sort'));
        }

        $items = $items->paginate();

        return response()->json($items);
    }

    public function indexByChecklist(Request $r, $id)
    {
        $checklist = \App\Checklist::with('items')->find($id);

        if ($r->input('filter')) {
            $checklist = $checklist->where('description', 'like', '%' . $r->input('filter') . '%');
        }
        if ($r->input('sort')) {
            $checklist = $checklist->orderBy('created_at', $r->input('sort'));
        }

        // $checklist = $checklist->paginate();

        return response()->json([
            'success' => true,
            'message' => 'Items by checklist found!',
            'data' => $checklist,
        ]);
    }

    public function show(Request $r, $id, $item_id)
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
        $checklist->item = $item;

        return response()->json([
            'success' => true,
            'message' => 'Item found!',
            'data' => $checklist,
        ]);
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

        /* save the checklist */
        $item = new \App\ChecklistItem();
        $item->description = $r->input('data.description');
        $item->due = \Carbon\Carbon::parse($r->input('data.due'));
        $item->urgency = $r->input('data.urgency');
        $item->checklist_id = $r->input('data.checklist_id');
        $item->created_by = \Auth::user()->id;
        $item->save();

        /* return error */
        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Checklist item not saved!',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Checklist item saved!',
            'data' => \App\ChecklistItem::find($item->id),
        ], 201);
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

        $item->description = $r->input('data.description');
        $item->due = \Carbon\Carbon::parse($r->input('data.due'));
        $item->urgency = $r->input('data.urgency');
        $item->checklist_id = $r->input('data.checklist_id');
        $item->updated_by = \Auth::user()->id;
        $item->save();

        /* return error */
        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Checklist item not updated!',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Checklist item updated!',
            'data' => $item,
        ], 201);
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
        $item->delete();

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
                'is_completed' => $cl_item->is_completed,
                'checklist_id' => $cl_item->checklist_id,
            ];
        }

        return response()->json([
            'success' => true,
            'message' => ($complete ? 'Complete' : 'Uncomplete') . 'items success',
            'data' => $data,
        ]);
    }

    public function uncomplete(Request $r)
    {
        return $this->complete($r, false);
    }
}
