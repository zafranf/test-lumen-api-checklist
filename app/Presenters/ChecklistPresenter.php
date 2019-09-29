<?php

namespace App\Presenters;

use App\Presenters\BasePresenter;

class ChecklistPresenter extends BasePresenter
{

    public function __construct()
    {
        parent::__construct();
        $this->resourceKeyItem =
        $this->resourceKeyCollection = 'checklists';
    }

    /**
     * Prepare data to present
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new \App\Transformers\ChecklistTransformer();
    }
}
