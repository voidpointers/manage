<?php

namespace Voidpointers\Yunexpress;

class Client
{
    /**
     * @var string
     */
    protected $host;

    /**
     * @var string
     */
    protected $appKey;

    /**
     * @var string
     */
    protected $appSecret;

    /**
     * @var string
     */
    protected $client;

    /**
     * @var string
     */
    protected $headers;

    /**
     * Constructor.
     */
    public function __construct($lang = 'en-us')
    {
        foreach (config('yunexpress') as $key => $value) {
            $this->$key = $value;
        }

        $this->headers = [
            'Content-Type' => 'application/json; charset=utf8',
            'Authorization' => 'Basic ' . $this->buildToken(),
            'Accept-Language' => $lang,
            'Accept' => 'text/json',
        ];

        $this->init();
    }

    /**
     * Init
     */
    protected function init()
    {
        $this->client = new \GuzzleHttp\Client([
            'headers' => $this->headers
        ]);

        return $this;
    }

    /**
     * Build authorization token
     *
     * @return string
     */
    protected function buildToken()
    {
        return base64_encode($this->appKey . '&' . $this->appSecret);
    }

    /**
     * Set language
     *
     * @param  string   $lang en-us / zh-cn
     * @return Client
     */
    public function setLang($lang)
    {
        $this->headers['Accept-Language'] = $lang;
        return $this->init();
    }

    /**
     * @param array $packages
     */
    public function createOrder(array $orders)
    {
        $api = 'WayBill/CreateOrder';

        $data = [];
        foreach ($orders as $order) {
            $data[] = $order->toArray();
        }
        $body = ['body' => json_encode($data)];
        $response = $this->client->post($this->host . $api, $body);
        return $this->parseResult($response->getBody());
    }

    /**
     * Get tracking info by waybill number, order number or tracking number
     *
     * @param  string  $number waybill number, order number or tracking number
     * @return array
     */
    public function getTrackInfo($order_number)
    {
        $api = 'Tracking/GetTrackInfo';

        $query = [
            'query' => [
                'orderNumber' => $order_number,
            ],
        ];
        $response = $this->client->get($this->host . $api, $query);
        return $this->parseResult($response->getBody());
    }

    /**
     * 解析结果
     *
     * @param  string      $result
     * @throws Exception
     * @return array
     */
    public function parseResult($result)
    {
        $arr = json_decode($result, true);
        if (empty($arr) || !isset($arr['Code'])) {
            throw new \Exception('Invalid response: ' . $result, 400);
        }
        if (!in_array($arr['Code'], ['0000', '5001'])) {
            if (!is_numeric($arr['Code'])) {
                $arr['code'] = '1001';
            }
            throw new \Exception($arr['Message'], $arr['Code']);
        }
        return $arr['Item'];
    }
}
