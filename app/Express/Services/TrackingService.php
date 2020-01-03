<?php

namespace Express\Services;

use Voidpointers\Yunexpress\Waybill;

class TrackingService
{
    public function buildOrders($packages)
    {
        $orders = [];

        foreach ($packages as $package) {
            
        }

        return $orders;
    }

    public function build($package)
    {
        $waybill = (new Waybill);
        $waybill->CustomerOrderNumber = '';
        $waybill->ShippingMethodCode = '';
        $waybill->PackageCount = '';
        $waybill->Weight = '';

        $waybill->Receiver->CountryCode = '';
        $waybill->Receiver->FirtstName = '';
        $waybill->Receiver->LastName = '';
        $waybill->Receiver->Street = str_replace("&#39;", "", $package->first_line . $package->second_line);
        $waybill->Receiver->City = '';
        $waybill->Receiver->State = '';
        $waybill->Receiver->Zip = '';
        $waybill->Receiver->Phone = '';

        $waybill->Parcels->EName = $transaction->declare_ename;
        $waybill->Parcels->CName = $transaction->declare_name;
        $waybill->Parcels->Quantity => $transaction->quantity;
        $waybill->Parcels->UnitPrice => $transaction->declare_price;
        $waybill->Parcels->UnitWeight => $transaction->declare_weight * $transaction->quantity;
        $waybill->Parcels->CurrencyCode = 'USD';
    }
}
