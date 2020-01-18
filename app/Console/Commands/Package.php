<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Package\Services\PackageService;
use Receipt\Entities\Receipt;

class Package extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'package:pull';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '自动包裹';

    protected $request;

    protected $packageService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        PackageService $packageService
    )
    {
        parent::__construct();
        $this->packageService = $packageService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $count = Receipt::where('status', 8)->count();
        dd($count);
        for($i = 100; $i > 0; $i--) {
            $receipts = Receipt::where('status', 8)->offset(100)->limit($i)->get();
            $this->packageService->create($receipts);
            echo "$i - 次更新完成" . PHP_EOL;
        }
    }
}

