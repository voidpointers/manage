<?php

namespace Api\Logistics\V1\Controllers;

use Api\Controller;
use Dingo\Api\Http\Request;

class TracksController extends Controller
{
    /**
     * 创建物流订单（获取运单号）
     * 
     * @param Reqeust $request
     * @param array
     */
    public function create(Request $request)
    {
        // 获取package
        $packages = $this->packageRepository->listByPackage(
            $request->input('package_sn')
        );

        $this->trackingService->create();

        $logistics = $this->logisticsService->createOrder($package_sn);

        $this->logisticsRepo->create();
    }
}
