<?php

namespace App;

use Prettus\Repository\Eloquent\BaseRepository;

abstract class Repository extends BaseRepository
{
    /**
     * Update a entity in repository by where
     *
     * @throws ValidatorException
     *
     * @param array $where
     * @param array $values
     *
     * @return mixed
     */
    public function updateWhere(array $where, array $values)
    {
        $this->applyScope();

        $temporarySkipPresenter = $this->skipPresenter;

        $this->skipPresenter(true);

        foreach ($where as $key => $value) {
            if (is_array($value)) {
                $this->model->whereIn($key, $value);
            }
        }
        $model = $this->model->where($where)->update($values);

        $this->skipPresenter($temporarySkipPresenter);
        $this->resetModel();

        // event(new RepositoryEntityUpdated($this, $model));

        return $this->parserResult($model);
    }
}
