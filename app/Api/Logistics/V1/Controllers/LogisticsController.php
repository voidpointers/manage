<?php

namespace Api\Logistics\V1\Controllers;

use Api\Controller;
use Dingo\Api\Http\Request;
use Express\Services\ExpressService;
use Logistics\Services\LogisticsService;
use Package\Repositories\PackageRepository;

class LogisticsController extends Controller
{
    protected $packageRepository;

    protected $logisticsService;

    protected $expressService;

    public function __construct(
        PackageRepository $packageRepository,
        LogisticsService $logisticsService,
        ExpressService $expressService)
    {
        $this->packageRepository = $packageRepository;
        $this->logisticsService = $logisticsService;
        $this->expressService = $expressService;
    }

    public function lists(Request $request)
    {

    }

    /**
     * 获取跟踪信息
     * 
     * @param string $tracking_code
     * @return array
     */
    public function trackInfo($tracking_code)
    {
        $this->request->instance()->trackInfo($tracking_code);
    }

    /**
     * 获取面单
     * 
     * @param Request $request
     * @return array
     */
    public function labels(Request $request)
    {
        $tracking_codes = $request->input('tracking_code', []);
        if (!is_array($tracking_codes)) {
            $tracking_codes = [$tracking_codes];
        }

        $data = $this->expressService->labels($tracking_codes);

        return $this->response->array(['data' => $data]);
    }
}
