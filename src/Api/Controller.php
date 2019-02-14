<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2018/10/27
 * Time: 21:50
 */

namespace JoseChan\Api;


use JoseChan\Api\Constant\ErrorCode;

class Controller
{
    protected function validate($data, $rule)
    {
        $validator = validator($data, $rule);

        if($validator->fails())
        {
            ErrorCode::error(ErrorCode::ERR_INVALID_PARAMETER);
//            $validator->errors();
        }
    }
}