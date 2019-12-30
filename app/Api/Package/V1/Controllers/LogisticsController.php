<?php

namespace Api\Package\V1\Controllers;

use Dingo\Api\Http\Request;
use Package\Repositories\PackageRepository;
use Voidpointers\Yunexpress\Waybill;

class LogisticsController
{
    protected $packageRepository;

    public function __construct(
        PackageRepository $packageRepository
    )
    {
        $this->packageRepository = $packageRepository;
    }
    
    public function transform()
    {
        $waybill = new Waybill;

        $waybill->CustomerOrderNumber = '';
        $waybill->ShippingMethodCode = '';
        $waybill->PackageCount = '';
        $waybill->Weight = '';
        $waybill->Receiver = '';
        $waybill->Parcels = '';

        return $waybill;
    }
}
