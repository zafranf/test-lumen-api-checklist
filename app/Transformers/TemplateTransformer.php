<?php
namespace App\Transformers;

use App\Template;
use League\Fractal\TransformerAbstract;

class TemplateTransformer extends TransformerAbstract
{
    public function transform(Template $template)
    {
        return [
            'id' => $template->id,
            'name' => $template->name,
            'checklist' => [
                'description' => $template->checklist->description,
                'due_interval' => $template->checklist->due_interval,
                'due_unit' => $template->checklist->due_unit,
            ],
            'items' => $template->checklist->items->map(function ($arr) {
                return [
                    'description' => $arr->description,
                    'urgency' => $arr->urgency,
                    'due_interval' => $arr->due_interval,
                    'due_unit' => $arr->due_unit,
                ];
            }),
        ];
    }
}
