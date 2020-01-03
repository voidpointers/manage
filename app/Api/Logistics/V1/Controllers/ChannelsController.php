<?php

namespace Api\Logistics\V1\Controllers;

use Api\Controller;
use Api\Logistics\V1\Transformers\ChannelTransformer;
use Dingo\Api\Http\Request;
use Logistics\Repositories\ChannelRepository;

class ChannelsController extends Controller
{
    protected $channelRepository;

    public function __construct(ChannelRepository $channelRepository)
    {
        $this->channelRepository = $channelRepository;
    }

    public function lists()
    {
        $channels = $this->channelRepository->all();

        return $this->response->collection($channels, new ChannelTransformer);
    }

    public function edit(Request $request)
    {
        $ids = $request->input('id');
    }

    public function store()
    {

    }
}
