<?php

namespace Api\Receipt\V1\Controllers;

use Api\Controller;
use Api\Receipt\V1\Filters\Filter;
use Api\Receipt\V1\Transforms\ReceiptTransformer;
use App\Exports\ReceiptsExport;
use Dingo\Api\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Receipt\Entities\Transaction;
use Receipt\Entties\Receipt;
use Receipt\Repositories\ReceiptRepository;
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

    public function __construct(
        ReceiptRepository $repository,
        StateMachine $stateMachine)
    {
        $this->repository = $repository;
        $this->stateMachine = $stateMachine;
    }

    /**
     * 构造搜索语句
     * 
     * @param Request $request
     * @return 
     */
    protected function search($request)
    {
        $filter = new Filter($request);

        $query = $filter->filter('receipt', Receipt::query())
        ->whereHas('consignee', function ($query) use ($filter) {
            return $filter->filter('consignee', $query);
        })->whereHas('transaction', function ($query) use ($filter) {
            return $filter->filter('transaction', $query);
        })->with(['transaction', 'consignee']);

        return $query;
    }

    /**
     * 获取订单列表
     * 
     * @param Request $request
     * @return string
     */
    public function lists(Request $request)
    {
        $receipts = $this->search($request)->orderBy('id', 'desc')
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
        $filter = new Filter($request);

        $query = $filter->filter('transaction', Transaction::query())
        ->whereHas('consignee', function ($query) use ($filter) {
            return $filter->filter('consignee', $query);
        })->whereHas('receipt', function ($query) use ($filter) {
            return $filter->filter('receipt', $query);
        })->with(['consignee', 'receipt']);

        $data = $query->get();

        return Excel::download(new ReceiptsExport($data), 'receipts.xlsx');
    }

    public function packUp(Request $request)
    {
        // 更改状态
        $this->stateMachine->operation('pakcup', $request->input('receipt_id'));

        // 生成包裹
        
    }

    public function delivery()
    {

    }
}
