<?php

namespace Api\Receipt\V1\Controllers;

use Api\Controller;
use Api\Receipt\V1\Transforms\ReceiptTransformer;
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

    public function lists()
    {
        $receipts = $this->repository->with(['consignee', 'transaction'])->paginate(30);

        return $this->response->paginator(
            $receipts,
            new ReceiptTransformer,
            ['key' => 'receipt']
        );
    }
}
