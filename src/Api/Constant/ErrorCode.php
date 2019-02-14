<?php
/**
 * Created by PhpStorm.
 * User: chenyu
 * Date: 2018/10/27
 * Time: 22:32
 */

namespace JoseChan\Api\Constant;

use Illuminate\Http\Response;

class ErrorCode
{

    //错误码
    const OK = 1;  //处理成功

    const ERR_SYSTEM = -1; //系统错误
    const ERR_OVERTIME = -2; // 请求超时
    const ERR_INVALID_PARAMETER = -4; //请求参数错误
    const ERR_CHECK_SIGN = -5; //签名验证错误
    const ERR_NO_PARAMETERS = -6; //参数缺失
    const ERR_UNKNOWN = -7; // 未知错误
    const AUTHORIZATION_FAIL = -8;//无权限查看

    const APP_NOT_EXISTS = 1000;
    const CHANNEL_NOT_EXISTS = 1001;
    const PAYMENT_NOT_EXISTS = 1002;
    const USER_NOT_LOGIN = 1003;
    const OAUTH_FAIL = 1004;
    const LOGIN_FAIL = 1005;
    const NAMED_NOT_CREATE = 1006;
    const HAS_RECOMMENDED = 1007;
    const HAS_LIKED = 1008;
    const NOT_OWNER = 1009;
    const ANALYST_USELESS = 1010;


    static $error = [

        self::OK                    => ['处理成功', Response::HTTP_OK],
        self::ERR_SYSTEM            => ['系统错误', Response::HTTP_INTERNAL_SERVER_ERROR],
        self::ERR_INVALID_PARAMETER => ['请求参数错误', Response::HTTP_BAD_REQUEST],
        self::ERR_CHECK_SIGN        => ['签名错误', Response::HTTP_FORBIDDEN],
        self::ERR_NO_PARAMETERS     => ['参数缺失', Response::HTTP_BAD_REQUEST],
        self::ERR_OVERTIME          => ['请求超时', Response::HTTP_BAD_REQUEST],
        self::AUTHORIZATION_FAIL    => ['无权限操作', Response::HTTP_BAD_REQUEST],

        self::APP_NOT_EXISTS        => ['应用不存在', Response::HTTP_NOT_FOUND],
        self::CHANNEL_NOT_EXISTS    => ['支付渠道不存在', Response::HTTP_NOT_FOUND],
        self::PAYMENT_NOT_EXISTS    => ['支付单不存在', Response::HTTP_NOT_FOUND],
        self::USER_NOT_LOGIN        => ['未登录', Response::HTTP_FORBIDDEN],
        self::OAUTH_FAIL            => ['授权信息获取失败', Response::HTTP_BAD_GATEWAY],
        self::LOGIN_FAIL            => ['登录失败', Response::HTTP_BAD_GATEWAY],
        self::NAMED_NOT_CREATE      => ['起名单不存在', Response::HTTP_NOT_FOUND],
        self::HAS_RECOMMENDED       => ['名字已推荐过', Response::HTTP_BAD_REQUEST],
        self::HAS_LIKED             => ['已点赞', Response::HTTP_BAD_REQUEST],
        self::NOT_OWNER             => ['没有操作权限', Response::HTTP_FORBIDDEN],
        self::ANALYST_USELESS       => ['查看次数限制，请付费后查看', Response::HTTP_FORBIDDEN],
    ];


    /**
     * 返回错误代码的描述信息
     *
     * @param int    $code        错误代码
     * @param string $otherErrMsg 其他错误时的错误描述
     * @return string 错误代码的描述信息
     */
    public static function msg($code, $otherErrMsg = '')
    {
        if (isset(self::$error[$code][0])) {
            return self::$error[$code][0];
        }

        return $otherErrMsg;
    }

    /**
     * 返回错误代码的Http状态码
     * @param int $code
     * @param int $default
     * @return int
     */
    public static function status($code, $default = 200)
    {
        return 200;
        if (isset(self::$error[$code][1])) {
            return self::$error[$code][1];
        }

        return $default;
    }

    public static function getCode($code)
    {
        return isset(self::$error[$code])?self::$error[$code]:false;
    }

    public static function error($code)
    {
        throw new \Exception(self::msg($code), $code);
    }
}