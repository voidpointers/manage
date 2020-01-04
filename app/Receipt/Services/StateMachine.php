<?php

namespace Receipt\Services;

use Receipt\Entities\Receipt;

class StateMachine
{
    protected const OPERATION = [
        'create' => 1,
        'packup' => 2,
        'dispatch' => 3,
        'close' => 7,
        'complete' => 8,
    ];

    protected $data;

    /**
     * 操作
     */
    public function operation($action, $where = [])
    {
        if (!in_array($action, self::OPERATION)) {
            return false;
        }
        $this->build($action);

        return $this->update($where);
    }

    protected function build($action)
    {
        $data = [
            'status' => self::OPERATION[$action],
            $action . '_time' => time()
        ];

        $this->data = $data;
    }

    protected function update($receit_ids)
    {
        return Receipt::whereIn(
            'id', $receit_ids
        )->update($this->data);
    }
}
