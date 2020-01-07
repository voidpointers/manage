<?php

namespace Api\Package\V1\Controllers;

use Api\Controller;
use Api\Package\V1\Transforms\PackageTransformer;
use Dingo\Api\Http\Request;
use Package\Repositories\PackageRepository;
use Package\Services\PackageService;
use Receipt\Services\ReceiptService;
use Receipt\Services\StateMachine as ReceiptStateMachine;
use Package\Services\StateMachine as PackageStateMachine;

class PackagesController extends Controller
{
    protected $packageRepository;

    protected $receiptService;

    protected $packageService;

    protected $receiptStateMachine;

    protected $packageStateMachine;

    public function __construct(
        PackageRepository $packageRepository,
        ReceiptService $receiptService,
        PackageService $packageService,
        ReceiptStateMachine $receiptStateMachine,
        PackageStateMachine $packageStateMachine)
    {
        $this->packageRepository = $packageRepository;
        $this->receiptService = $receiptService;
        $this->packageService = $packageService;
        $this->receiptStateMachine = $receiptStateMachine;
        $this->packageStateMachine = $packageStateMachine;
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

        // 过滤不符合状态的订单
        foreach ($receipts as $key => $receipt) {
            if ($receipt->status != 1) {
                unset($receipts[$key]);
            }
        }
        if ($receipts->isEmpty()) {
            return $this->response->error('订单不存在或状态不正确', 500);
        }

        // 更改订单状态
        if (!$this->receiptStateMachine->operation('packup', ['id' => $receipt_ids])) {
            return $this->response->error('订单状态更改失败', 500);
        }

        // 生成包裹
        $packages = $this->packageService->create($receipts);

        return $this->response->array(['data' => $packages]);
    }

    /**
     * 发货
     */
    public function delivery(Request $request)
    {
        $package_sn = $request->input('package_sn', '');
        if (!$package_sn) {
            return $this->response->error('参数错误[package_sn为空]', 500);
        }
        $package_sn = json_decode($package_sn);

        // 获取包裹列表
        $packages = $this->packageService->lists($package_sn);

        // 校验包裹状态
        $items = [];
        foreach ($packages as $key => $package) {
            if ($package->status != 3) {
                unset($packages[$key]);
                continue;
            }
            foreach ($package->item as $item) {
                $items[] = [
                    'receipt_id' => $item->receipt_id,
                ];
            }
        }
        if ($packages->isEmpty()) {
            return $this->response->error("当前没有需要获取物流单号的包裹", 500);
        }
        $package_sn = $packages->pluck('package_sn')->toArray();

        // 更改包裹状态
        $this->packageStateMachine->operation('dispatch', ['package_sn' => $package_sn]);

        // 获取包裹包含订单
        $receipt_ids = array_unique(array_column($items, 'receipt_id'));

        // 更改订单状态
        if (!$this->receiptStateMachine->operation('dispatch', ['id' => $receipt_ids])) {
            return $this->response->error('订单状态更改失败', 500);
        }

        return $this->response->array(['data' => ['package_sn' => $package_sn]]);
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
