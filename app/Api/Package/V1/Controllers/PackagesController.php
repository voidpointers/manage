<?php

namespace Api\Package\V1\Controllers;

use Api\Controller;
use Api\Package\V1\Transforms\PackageTransformer;
use Package\Repositories\PackageRepository;

class PackagesController extends Controller
{
    protected $packageRepository;

    public function __construct(PackageRepository $packageRepository)
    {
        $this->packageRepository = $packageRepository;
    }

    public function lists()
    {
        $packages = $this->packageRepository->with([
            'consignee', 'logistics', 'item' => function ($query) {
                return $query->with('transaction');
            }
        ])->get();

        return $this->response->collection($packages, new PackageTransformer);
    }
}
