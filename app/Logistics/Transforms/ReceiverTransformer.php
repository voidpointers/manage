<?php

namespace Logistics\Transformers;

class ReceiverTransformer
{
    public function transoform()
    {
        return [
            'CountryCode' => $packageRow->country->iso_country_code, // 国家简码
            'FirstName' => $packageRow->buyer_name, //发件人
            'LastName' => '', //姓
            'Company' => '', //公司
            'Street' => str_replace("&#39;", "", $packageRow->first_line . $packageRow->second_line), //详细地址
            'City' => $packageRow->city, //城市
            'State' => $packageRow->state, //州
            'Zip' => $packageRow->zip, //邮编
            'Phone' => $packageRow->mobile, // 收件人电话
            'HouseNumber' => ''
        ];
    }
}
