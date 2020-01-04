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

    protected const TIME = [
        'create', 'packup', 'delivery', 'complete', 'close'
    ];

    protected $data;

    /**
     * 操作
     */
    public function operation($action, $where = [])
    {
        $this->build($action);

        return $this->update($where);
    }

    protected function build($action)
    {
        $data = [
            'status' => self::OPERATION[$action],
        ];
        if (self::TIME[$action]) {
            $data[$action . '_time'] = time();
        }

        $this->data = $data;
    }

    protected function update($receit_ids)
    {
        return Receipt::whereIn(
            'id', $receit_ids
        )->update($this->data);
    }
}
