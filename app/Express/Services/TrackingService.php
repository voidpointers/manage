<?php

namespace Express\Services;

class TrackingService
{
    public function buildOrders($packages)
    {
        $orders = [];

        foreach ($packages as $package) {
            $orders[] = $this->build($package);
        }

        return $orders;
    }

    public function build($package)
    {
        return [
            'CustomerOrderNumber' => '',
            'ShippingMethodCode' => '',
            'PackageCount' => 1,
            'Weight' => '',
            'Receiver' => [
                'CountryCode' => $package->consignee->country_code,
                'FirtstName' => $package->consignee->first_name,
                'LastName' => $package->consignee->last_name,
                'Street' => str_replace('&#39,', '', 
                    $package->consignee->first_line . $package->consignee->second_line
                ),
                'City' => $package->consignee->city,
                'State' => $package->consignee->state,
                'Zip' => $package->consignee->zip,
                'Phone' => $package->consignee->phone,
            ],
            'Parcels' => [
                'EName' => $package->item->en,
                'CName' => $package->item->title,
                'Quantity' => $package->item->quantity,
                'UnitPrice' => $package->item->price,
                'UnitWeight' => $package->item->weight * $package->item->quantity,
                'CurrencyCode' => 'USD',
            ],
        ],
    }
}
