<?php

namespace Api\Receipt\V1\Controllers;

use Api\Controller;
use Api\Receipt\V1\Transforms\ReceiptTransformer;
use App\Exports\ReceiptsExport;
use Dingo\Api\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Package\Services\PackageService;
use Receipt\Repositories\ReceiptRepository;
use Receipt\Services\ReceiptService;
use Receipt\Services\StateMachine;

/**
 * 收据控制器
 * 
 * @author bryan <voidpointers@hotmail.com>
 */
class ReceiptsController extends Controller
{
    protected $repository;

    protected $stateMachine;

    protected $packageService;

    protected $receiptService;

    public function __construct(
        ReceiptRepository $repository,
        StateMachine $stateMachine,
        PackageService $packageService,
        ReceiptService $receiptService)
    {
        $this->repository = $repository;
        $this->stateMachine = $stateMachine;
        $this->packageService = $packageService;
        $this->receiptService = $receiptService;
    }

    /**
     * 获取订单列表
     * 
     * @param Request $request
     * @return string
     */
    public function lists(Request $request)
    {
        $receipts = $this->receiptService->query($request)->orderBy('id', 'desc')
            ->paginate($request->get('limit', 30));
        
        return $this->response->paginator(
            $receipts,
            new ReceiptTransformer
        );
    }

    /**
     * 导出订单
     * 
     * @return
     */
    public function export(Request $request)
    {
        $data = $this->receiptService->query($request, [
            'base' => 'transaction', 'with' => ['consignee', 'receipt']
        ])->get();

        return Excel::download(new ReceiptsExport($data), 'receipts.xlsx');
    }

    public function packUp(Request $request)
    {
        $receipt_ids = $request->input('receipt_id', '');
        if (!$receipt_ids) {
            return $this->response->error('参数错误', 500);
        }

        get_last_sql();

        // 更改状态
        $this->stateMachine->operation('packup', json_decode($receipt_ids));
        dd('');

        // 生成包裹
        $this->packageService->create($receipts);
    }

    public function delivery()
    {

    }
}
