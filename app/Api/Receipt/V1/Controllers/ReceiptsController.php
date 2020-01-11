<?php

namespace Api\Receipt\V1\Controllers;

use Api\Controller;
use Api\Receipt\V1\Requests\ReceiptRequest;
use Api\Receipt\V1\Transforms\ReceiptTransformer;
use App\Exports\ReceiptsExport;
use Dingo\Api\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Package\Services\PackageService;
use Receipt\Entities\Receipt;
use Receipt\Filters\ReceiptFilter;
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
        ReceiptService $receiptService,
        Receipt $receipt)
    {
        $this->repository = $repository;
        // $this->stateMachine = $stateMachine;
        // $this->packageService = $packageService;
        // $this->receiptService = $receiptService;
        $this->receipt = $receipt;
    }

    public function lists(Request $request)
    {
        return $this->repository->apply($request)->with([
            'consignee', 'transaction', 'logistics'
        ])->get();
    }

    /**
     * 获取订单列表
     * 
     * @param Request $request
     * @return string
     */
    public function listsv2(Request $request)
    {
        $receipts = $this->receiptService->query($request)->orderBy('id', 'desc')
            ->paginate($request->get('limit', 30));
        
        return $this->response->paginator(
            $receipts,
            new ReceiptTransformer
        );
    }

    public function create()
    {

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

    /**
     * 关闭
     */
    public function close(Request $request)
    {
        $receipt_ids = $request->input('receipt_id', '');
        if (!$receipt_ids) {
            return $this->response->error('参数错误', 500);
        }
        $receipt_ids = json_decode($receipt_ids);

        // 更改状态
        if (!$this->stateMachine->operation('close', ['id' => $receipt_ids])) {
            return $this->response->error('订单状态更改失败', 500);
        }

        return $this->response->noContent();
    }

    /**
     * 更新
     */
    public function update(ReceiptRequest $request, $receipt_sn)
    {
        $validated = $request->validated();
        if (!$validated) {
            return $this->response->error('缺少必要参数', 500);
        }

        $this->receiptService->update(
            ['where' => ['receipt_sn' => $receipt_sn]], $validated
        );

        return $this->response->array(['msg' => 'success']);
    }
}
