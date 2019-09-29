<?php
namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;

class TemplateRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name' => 'like',
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
        return "App\\Template";
    }

    public function presenter()
    {
        return "App\\Presenters\\TemplatePresenter";
    }
}
