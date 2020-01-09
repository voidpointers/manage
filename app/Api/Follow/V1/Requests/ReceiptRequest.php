<?php

namespace Api\Follow\Requests;

use Api\FormRequest;

class ReceiptRequest extends FormRequest
{
    public function rules()
    {
        return [
            'receipt_id' => 'required'
        ];
    }
}
