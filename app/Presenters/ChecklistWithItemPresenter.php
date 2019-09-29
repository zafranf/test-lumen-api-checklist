<?php

namespace App\Presenters;

use App\Presenters\BasePresenter;

class ChecklistWithItemPresenter extends BasePresenter
{

    public function __construct()
    {
        parent::__construct();
        $this->resourceKeyItem =
        $this->resourceKeyCollection = 'items';
    }

    /**
     * Prepare data to present
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new \App\Transformers\ChecklistWithItemTransformer();
    }
}
