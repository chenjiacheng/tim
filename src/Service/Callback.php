<?php

declare(strict_types=1);

namespace Chenjiacheng\Tim\Service;

class Callback extends AbstractService
{
    /**
     * 回调签名校验，签名算法：Sign=sha256(TokenRequestTime)
     *
     * @see https://cloud.tencent.com/document/product/269/1522
     *
     * @param string $sign 签名
     * @param string|int $requestTime 签名时间戳
     * @param string|null $token 在回调URL配置中，开启鉴权，并配置鉴权Token
     *
     * @return bool
     */
    public function verify(string $sign, string|int $requestTime, string $token = null): bool
    {
        $token = $token ?? $this->app->config->get('token');
        if ($sign != hash('sha256', $token . $requestTime)) {
            return false;
        }

        return true;
    }

    /**
     * 回调处理成功应答
     *
     * @param int $errCode 错误码
     * @param string $errInfo 错误信息
     *
     * @return bool|string
     */
    public function ok(int $errCode = 0, string $errInfo = ''): bool|string
    {
        return json_encode(['ActionStatus' => 'OK', 'ErrorCode' => $errCode, 'ErrorInfo' => $errInfo]);
    }

    /**
     * 回调处理失败应答
     *
     * @param int $errCode 错误码
     * @param string $errInfo 错误信息
     *
     * @return bool|string
     */
    public function fail(int $errCode = 1, string $errInfo = ''): bool|string
    {
        return json_encode(['ActionStatus' => 'FAIL', 'ErrorCode' => $errCode, 'ErrorInfo' => $errInfo]);
    }
}