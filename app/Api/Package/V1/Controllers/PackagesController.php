<?php

namespace Api\Package\V1\Controllers;

use Api\Controller;
use Api\Package\V1\Transforms\PackageTransformer;
use Dingo\Api\Http\Request;
use Package\Repositories\PackageRepository;

class PackagesController extends Controller
{
    protected $packageRepository;

    public function __construct(PackageRepository $packageRepository)
    {
        $this->packageRepository = $packageRepository;
    }

    public function lists(Request $request)
    {
        $packages = $this->packageRepository->with([
            'consignee',
            'logistics' => function ($query) {
                return $query->with('channel');
            },
            'item' => function ($query) {
                return $query->with('transaction');
            }
        ])->paginate($request->get('limit', 30));

        return $this->response->paginator($packages, new PackageTransformer);
    }
}
