<?php

namespace Api\Receipt\V1\Controllers;

use Api\Controller;
use Api\Receipt\V1\Filters\Filter;
use Api\Receipt\V1\Transforms\ReceiptTransformer;
use App\Exports\ReceiptsExport;
use Dingo\Api\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Receipt\Entties\Receipt;
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
     * 构造搜索语句
     * 
     * @param Request $request
     * @return 
     */
    protected function search($request)
    {
        $filter = new Filter($request);

        $query = $filter->filter('receipt')
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
    public function export()
    {
        return Excel::download(new ReceiptsExport, 'receipts.xlsx');
    }
}
