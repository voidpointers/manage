<?php

namespace Voidpointers\Yunexpress;

class Waybill
{
    /**
     * 客户订单号，不能重复，必填
     *
     * @var string
     */
    public $customerOrderNumber;

    /**
     * 运输方式代码 必填
     *
     * @var string
     */
    public $shippingMethodCode;

    /**
     * 包裹跟踪号，非必填
     *
     * @var string
     */
    public $trackingNumber;

    /**
     * 平台交易号（wish邮），非必填
     *
     * @var string
     */
    public $transactionNumber;

    /**
     * 预估包裹单边长，单位cm，默认1，非必填
     *
     * @var int
     */
    public $length;

    /**
     * 预估包裹单边宽，单位cm，默认1，非必填
     *
     * @var int
     */
    public $width;

    /**
     * 预估包裹单边高，单位cm，默认1，非必填
     *
     * @var int
     */
    public $height;

    /**
     * 运单包裹的件数，必须大于0的整数，必填
     *
     * @var int
     */
    public $packageNumber;

    /**
     * 预估包裹总重量，单位kg，最多3位小数，必填
     *
     * @var decimal(18,3)
     */
    public $weight;

    /**
     * 收件人信息，必填
     *
     * @var Receiver 
     */
    public $receiver;

    /**
     * 发件人信息，非必填
     *
     * @var Sender
     */
    public $sender;

    /**
     * 申报类型，用于打印CN22，1-Gift，2-Sample，3-Documents，4-Others，默认4-Other，非必填
     *
     * @var int
     */
    public $applicationType;

    /**
     * 是否退回，包裹无人签收时是否退回，1-退回，0-不退回，默认0，非必填
     *
     * @var bool
     */
    public $returnOption;

    /**
     * 关税预付服务费，1-参加关税预付，0-不参加关税预付，默认0 (渠道需开通关税预付服务)，非必填
     *
     * @var bool
     */
    public $tariffPrepay;

    /**
     * 包裹投保类型，0-不参保，1-按件，2-按比例，默认0，表示不参加运输保险，具体参考包裹运输，非必填
     *
     * @var int
     */
    public $insuranceOption;

    /**
     * 保险的最高额度，单位RMB，非必填
     *
     * @var decimal(18,2)
     */
    public $coverage;

    /**
     * 包裹中特殊货品类型，可调用货品类型查询服务查询，可以不填写，表示普通货品，非必填
     *
     * @var int
     */
    public $sensitiveTypeID;

    /**
     * 申请单信息，必填
     *
     * @var Parcels[]
     */
    public $parcels;

    /**
     * 订单来源代码，非必填
     *
     * @var string
     */
    public $sourceCode;
}
