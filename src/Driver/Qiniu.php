<?php

declare(strict_types=1);

namespace Goletter\Sms\Driver;

use Exception;
use Goletter\Sms\Contract\SmsInterface;
use Goletter\Sms\SmsBase;
use GuzzleHttp;

class Qiniu extends SmsBase implements SmsInterface
{
    /**
     * 发送短信
     * https://developer.qiniu.com/sms/5897/sms-api-send-message#2
     * @param string $mobile
     * @param array $message
     * @return void
     * @throws Exception
     */
    public function send(string $mobile, array $message): void
    {
        try {
            $message = $this->formatMessage($message);

            $url = sprintf('https://%s.qiniuapi.com/%s/%s', 'sms', 'v1', 'message/single');

            $data = json_encode([
                'template_id' => $message->getTemplate($this),
                'mobile'      => $mobile,
                'parameters'  => $message->getData($this),
            ]);

            $response = (new GuzzleHttp\Client([
                'headers' => ['requestSource' => 4, 'Authorization' => $this->sign($url, 'POST', $data, 'application/json')],
                'timeout' => 60,
            ]))->post($url, ['multipart' => $data]);

            return ;
        }  catch (GuzzleHttp\Exception\RequestException $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * 签名
     * @param string $url
     * @param string $method
     * @param string $body
     * @param string $contentType
     * @return string
     */
    protected function sign(string $url, string $method, string $body, string $contentType): string
    {
        $urlItems = parse_url($url);
        $host     = $urlItems['host'];
        if (isset($urlItems['port'])) {
            $port = $urlItems['port'];
        } else {
            $port = '';
        }
        $path = $urlItems['path'];
        if (isset($urlItems['query'])) {
            $query = $urlItems['query'];
        } else {
            $query = '';
        }
        // write request uri
        $toSignStr = $method . ' ' . $path;
        if (!empty($query)) {
            $toSignStr .= '?' . $query;
        }
        // write host and port
        $toSignStr .= "\nHost: " . $host;
        if (!empty($port)) {
            $toSignStr .= ':' . $port;
        }
        // write content type
        if (!empty($contentType)) {
            $toSignStr .= "\nContent-Type: " . $contentType;
        }
        $toSignStr .= "\n\n";
        // write body
        if (!empty($body)) {
            $toSignStr .= $body;
        }

        $hmac = hash_hmac('sha1', $toSignStr, $this->config['secret_key'], true);

        return 'Qiniu ' . $this->config['access_key'] . ':' . $this->base64UrlSafeEncode($hmac);
    }

    /**
     *
     * @param string $data
     * @return string
     */
    protected function base64UrlSafeEncode(string $data): string
    {
        $find    = ['+', '/'];
        $replace = ['-', '_'];

        return str_replace($find, $replace, base64_encode($data));
    }
}
