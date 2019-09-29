<?php
namespace App\Transformers;

use App\ChecklistItem;
use League\Fractal\TransformerAbstract;

class ChecklistItemTransformer extends TransformerAbstract
{
    public function transform(ChecklistItem $cl_item)
    {
        return [
            'id' => $cl_item->id,
            'description' => $cl_item->description,
            'is_completed' => $cl_item->is_completed ? true : false,
            'completed_at' => $cl_item->completed_at,
            'due' => $cl_item->due,
            'urgency' => $cl_item->urgency,
            'checklist_id' => $cl_item->checklist_id,
            'created_by' => $cl_item->created_by,
            'updated_by' => $cl_item->updated_by,
            'created_at' => $cl_item->created_at,
            'updated_at' => $cl_item->updated_at,
        ];
    }
}
