<?php

namespace Api\Package\V1\Controllers;

use Api\Controller;
use Api\Package\V1\Transforms\PackageTransformer;
use Dingo\Api\Http\Request;
use Package\Repositories\PackageRepository;
use Package\Services\PackageService;
use Receipt\Services\ReceiptService;
use Receipt\Services\StateMachine as ReceiptStateMachine;

class PackagesController extends Controller
{
    protected $packageRepository;

    protected $receiptService;

    protected $packageService;

    protected $receiptStateMachine;

    public function __construct(
        PackageRepository $packageRepository,
        ReceiptService $receiptService,
        PackageService $packageService,
        ReceiptStateMachine $receiptStateMachine)
    {
        $this->packageRepository = $packageRepository;
        $this->receiptService = $receiptService;
        $this->packageService = $packageService;
        $this->receiptStateMachine = $receiptStateMachine;
    }

    /**
     * 打包
     */
    public function create(Request $request)
    {
        $receipt_ids = $request->input('receipt_id', '');
        if (!$receipt_ids) {
            return $this->response->error('参数错误[receipt_id为空]', 500);
        }
        $receipt_ids = json_decode($receipt_ids);

        // 获取订单列表
        $receipts = $this->receiptService->listsByIds($receipt_ids);

        // 更改订单状态
        if (!$this->receiptStateMachine->operation('packup', $receipt_ids)) {
            return $this->response->error('订单状态更改失败', 500);
        }

        // 生成包裹
        $package = $this->packageService->create($receipts);

        return $this->response->array(['msg' => 'success']);
    }

    /**
     * 包裹列表
     */
    public function lists(Request $request)
    {
        $packages = $this->packageRepository->with([
            'consignee',
            'logistics' => function ($query) {
                return $query->with('channel');
            },
            'item' => function ($query) {
                return $query->with('transaction');
            }
        ])->paginate($request->get('limit', 30));

        return $this->response->paginator($packages, new PackageTransformer);
    }
}
