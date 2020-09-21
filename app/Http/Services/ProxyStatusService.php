<?php


namespace App\Http\Services;

use ErrorException;

class ProxyStatusService
{
    function checkServersUp(): array
    {
        $proxies = [
            'msk' => ['176.62.178.247', '47556'],
            'spb' => ['176.9.85.13', '3128'],
            'kzn' => ['85.172.39.174', '47326'],
            'lch' => ['127.0.0.1', '8080'],
            'nnv' => ['195.211.30.115', '35867'],
            'vlv' => ['159.69.89.56', '3128'],
            'err' => ['165.255.255.255', '8080']//its wrong server from check enable or disable
        ];
        $proxiesStatus = [];
        foreach ($proxies as $proxyName => $proxy) {

            try {
                $data = fsockopen($proxy[0], $proxy[1], $errorNumber, $errorString, 5);
                if ($data) {
                    $proxiesStatus[] = [
                        'proxyName' => $proxyName,
                        'proxyStatus' => 'true'
                    ];
                }
                fclose($data);
            } catch (ErrorException $e) {
                $proxiesStatus[] = [
                    'proxyName' => $proxyName,
                    'proxyStatus' => 'false'
                ];
                continue;
            }
            echo '<br>';
        }

       return $proxiesStatus;
    }

}