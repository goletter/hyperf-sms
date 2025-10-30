<?php

declare(strict_types=1);

namespace Goletter\Sms\Driver;

use Exception;
use Goletter\Sms\Contract\SmsInterface;
use Goletter\Sms\SmsBase;
use GuzzleHttp;

class Aliyun extends SmsBase implements SmsInterface
{
    /**
     * 发送短信
     * @param string $mobile
     * @param array $message
     * @return void
     * @throws Exception
     */
    public function send(string $mobile, array $message): void
    {
        try {
            $message = $this->formatMessage($message);

            $params = [
                'Format'           => 'JSON',
                'Version'          => '2017-05-25',
                'SignatureMethod'  => 'HMAC-SHA1',
                'SignatureNonce'   => uniqid((string)mt_rand(0, 65535), true),
                'SignatureVersion' => '1.0',
                'AccessKeyId'      => $this->config['accessKeyId'],
                'Timestamp'        => gmdate('Y-m-d\TH:i:s\Z'),
                'Action'           => 'SendSms',
                'RegionId'         => $this->config['regionId'],
                'PhoneNumbers'     => $mobile,
                'SignName'         => $this->config['signName'],
                'TemplateCode'     => $message->getTemplate($this),
                'TemplateParam'    => json_encode($message->getData($this))
            ];

            // 对参数进行排序
            ksort($params);

            // 构建待签名字符串
            $stringToSign = 'GET&%2F&' . urlencode(http_build_query($params, '', '&', PHP_QUERY_RFC3986));

            // 生成签名
            $signature = base64_encode(hash_hmac('sha1', $stringToSign, $this->config['accessKeySecret'] . '&', true));

            // 将签名添加到请求参数中
            $params['Signature'] = $signature;

            // 构建请求 URL
            $url      = 'https://dysmsapi.aliyuncs.com/?' . http_build_query($params);
            $response = (new GuzzleHttp\Client([
                'headers' => ['requestSource' => 4],
                'timeout' => 60,
            ]))->get($url);
            $content = $response->getBody()->getContents();
            $content = json_decode($content, true);

        } catch (GuzzleHttp\Exception\RequestException $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}
