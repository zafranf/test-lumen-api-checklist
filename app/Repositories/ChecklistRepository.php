<?php
namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

class ChecklistRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'description' => 'like',
    ];

    public function boot()
    {
        $this->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return "App\\Checklist";
    }

    public function presenter()
    {
        return "App\\Presenters\\ChecklistPresenter";
    }
}
