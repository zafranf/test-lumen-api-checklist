<?php

namespace App\Http\Controllers;

use App\Repositories\TemplateRepository;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    protected $repository;

    public function __construct(TemplateRepository $repository)
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
        /* save checklist */
        $cl_id = $this->saveChecklist($r);

        /* create new input */
        $r->merge([
            'name' => $r->input('data.attributes.name'),
            'created_by' => \Auth::user()->id,
            'checklist_id' => $cl_id,
        ]);

        /* create */
        $create = $this->repository->create($r->only(['name', 'created_by', 'checklist_id']));

        return response()->json($create, 201);
    }

    public function update(Request $r, $id)
    {
        $data['attributes'] = $r->input('data');
        $r->merge([
            'data' => $data,
        ]);

        /* save checklist */
        $cl_id = $this->saveChecklist($r, true);

        /* create new input */
        $r->merge([
            'name' => $r->input('data.attributes.name'),
            'updated_by' => \Auth::user()->id,
            'checklist_id' => $cl_id,
        ]);

        /* save the template */
        $template = \App\Template::find($id);
        if (!$template) {
            return response()->json([
                'success' => false,
                'message' => 'Template not found!',
            ], 404);
        }

        return $this->repository->update($r->only(['name', 'updated_by', 'checklist_id']), $template->id);
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
        $delete = $this->repository->delete($template->id);

        return response('', 204);
    }

    public function saveChecklist(Request $r, $is_update = false)
    {
        $cl = $r->input('data.attributes.checklist');

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
        $items = $r->input('data.attributes.items');
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
