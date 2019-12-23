<?php

namespace Voidpointers\Yunexpress;

class Receiver
{
    /**
     * 企业税号
     * 
     * @var string
     */
    public $taxId;

    /**
     * 国家，填写国际通用标准2位简码，可通过国家查询服务查询 必填
     * 
     * @var string
     */
    public $countryCode;

    /**
     * 姓 必填
     * 
     * @var string
     */
    public $firtstName;

    /**
     * 名
     * 
     * @var string
     */
    public $lastName;

    /**
     * 公司
     * 
     * @var string
     */
    public $company;

    /**
     * 详细地址 必填
     * 
     * @var string
     */
    public $street;

    /**
     * 详细地址1
     * 
     * @var string
     */
    public $streetAddress1;

    /**
     * 详细地址2
     * 
     * @var string
     */
    public $streetAddress2;

    /**
     * 市 必填
     * 
     * @var string
     */
    public $city;

    /**
     * 州/省
     * 
     * @var string
     */
    public $state;

    /**
     * 邮编
     * 
     * @var string
     */
    public $zip;

    /**
     * 电话
     * 
     * @var string
     */
    public $phone;
}
