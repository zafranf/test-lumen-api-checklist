<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * @group Template
 *
 * APIs for managing users
 */
class TemplateController extends Controller
{
    public function index(Request $r)
    {
        $templates = \App\Template::with('checklist.items');

        if ($r->input('filter')) {
            $templates = $templates->where('name', 'like', '%' . $r->input('filter') . '%');
        }
        if ($r->input('sort')) {
            $templates = $templates->orderBy('created_at', $r->input('sort'));
        }

        $templates = $templates->paginate();

        return response()->json($templates);
    }

    public function show(Request $r, $id)
    {
        $template = \App\Template::with('checklist.items')->find($id);
        if (!$template) {
            return response()->json([
                'success' => false,
                'message' => 'Template not found!',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Template found!',
            'data' => $template,
        ]);
    }

    public function store(Request $r)
    {
        /* $this->validate($r, [
        'data.attributes.name' => 'required|max:100',
        'data.attributes.checklist.description' => 'required|max:100',
        'data.attributes.checklist.due_interval' => 'required',
        'data.attributes.checklist.due_unit' => 'required',
        'data.attributes.items.*.description' => 'required',
        'data.attributes.items.*.urgency' => 'required',
        'data.attributes.items.*.due_interval' => 'required',
        'data.attributes.items.*.due_unit' => 'required',
        ]); */

        /* save checklist */
        $cl_id = $this->saveChecklist($r);

        /* save the template */
        $template = new \App\Template();
        $template->name = $r->input('data.name');
        $template->checklist_id = $cl_id;
        $template->created_by = \Auth::user()->id;
        $template->save();

        /* return error */
        if (!$template) {
            return response()->json([
                'success' => false,
                'message' => 'Template not saved!',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Template saved!',
            'data' => $template->load('checklist.items'),
        ], 201);
    }

    public function update(Request $r, $id)
    {
        /* save checklist */
        $cl_id = $this->saveChecklist($r, true);

        /* save the template */
        $template = \App\Template::find($id);
        if (!$template) {
            return response()->json([
                'success' => false,
                'message' => 'Template not found!',
            ], 404);
        }

        $template->name = $r->input('data.name');
        $template->updated_by = \Auth::user()->id;
        $template->checklist_id = $cl_id;
        $template->save();

        /* return error */
        if (!$template) {
            return response()->json([
                'success' => false,
                'message' => 'Template not updated!',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Template updated!',
            'data' => $template->load('checklist.items'),
        ], 201);
    }

    public function destroy(Request $r, $id)
    {
        $template = \App\Template::find($id);
        if (!$template) {
            return response()->json([
                'success' => false,
                'message' => 'Template not found!',
            ], 404);
        }

        /* delete */
        $template->delete();

        return response('', 204);
    }

    public function saveChecklist(Request $r, $is_update = false)
    {
        $cl = $r->input('data.checklist');

        $checklist = \App\Checklist::firstOrNew(['description' => $cl['description']]);
        $checklist->description = $cl['description'];
        $checklist->due = \Carbon\Carbon::now()->add($cl['due_interval'], $cl['due_unit']);
        $checklist->due_interval = $cl['due_interval'];
        $checklist->due_unit = $cl['due_unit'];
        if ($is_update) {
            $checklist->updated_by = \Auth::user()->id;
        } else {
            $checklist->created_by = \Auth::user()->id;
        }
        $checklist->save();

        $this->saveItems($r, $checklist->id);

        return $checklist->id;
    }

    public function saveItems(Request $r, $checklist_id, $is_update = false)
    {
        $items = $r->input('data.items');
        foreach ($items as $item) {
            $cl_item = \App\ChecklistItem::firstOrNew(['description' => $item['description']]);
            $cl_item->description = $item['description'];
            $cl_item->urgency = $item['urgency'];
            $cl_item->due = \Carbon\Carbon::now()->add($item['due_interval'], $item['due_unit']);
            $cl_item->due_interval = $item['due_interval'];
            $cl_item->due_unit = $item['due_unit'];
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
