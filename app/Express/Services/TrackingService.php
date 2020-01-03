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
        $orders = [
            'CustomerOrderNumber' => $package->package_sn,
            'ShippingMethodCode' => $package->channel,
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
            
        ];

        $parcels = [];
        foreach ($package->item as $item) {
            $weight = $item->weight * $item->quantity;
            $parcels = [
                'EName' => $item->en,
                'CName' => $item->title,
                'Quantity' => $item->quantity,
                'UnitPrice' => $item->price,
                'UnitWeight' => $weight,
                'CurrencyCode' => 'USD',
            ];
            $total_weight += $weight;
        }
        $orders['Weight'] = $total_weight;
        $orders['Parcels'] = $parcels;

        return $orders;
    }
}
