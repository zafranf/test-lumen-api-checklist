<?php
namespace App\Transformers;

use App\Checklist;
use League\Fractal\TransformerAbstract;

class ChecklistWithItemTransformer extends TransformerAbstract
{
    public function transform(Checklist $checklist)
    {
        return [
            'id' => $checklist->id,
            'description' => $checklist->description,
            'object_domain' => $checklist->object_domain,
            'object_id' => $checklist->object_id,
            'is_completed' => $checklist->is_completed ? true : false,
            'completed_at' => $checklist->completed_at,
            'due' => $checklist->due,
            'task_id' => $checklist->task_id,
            'urgency' => $checklist->urgency,
            'last_update_by' => $checklist->updated_by,
            'created_at' => $checklist->created_at,
            'updated_at' => $checklist->updated_at,
            'items' => $checklist->items,
        ];
    }
}
