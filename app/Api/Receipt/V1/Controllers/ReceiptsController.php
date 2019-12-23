<?php

namespace Api\Receipt\V1\Controllers;

use Api\Controller;
use Api\Receipt\V1\Transforms\ReceiptTransformer;
use Dingo\Api\Http\Request;
use Receipt\Repositories\ReceiptRepository;

/**
 * 收据控制器
 * 
 * @author bryan <voidpointers@hotmail.com>
 */
class ReceiptsController extends Controller
{
    protected $repository;

    public function __construct(ReceiptRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 获取列表
     */
    public function lists(Request $request)
    {
        $where = [];

        if ($request->get('status', 0) > 0) {
            $where['status'] = $request->get('status');
        }

        $receipts = $this->repository
            ->scopeQuery(function ($query) use ($where) {
                return $query->where($where);
            })
            ->with(['consignee', 'transaction'])->paginate(30);

        return $this->response->paginator(
            $receipts,
            new ReceiptTransformer
        );
    }
}
