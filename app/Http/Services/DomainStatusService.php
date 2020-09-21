<?php


namespace App\Http\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class DomainStatusService
{
    /**
     * @param bool|string $checkedUrl
     * @return array|bool
     */
    public function runner($checkedUrl)
    {
        if (!isset($checkedUrl)) {
            return false;
        }
        return $this->checkDomainByProxy($checkedUrl);
    }

    private function checkDomainByProxy(string $url): array
    {
        $start = microtime(1);

        $data = $this->url_get_contents($url);

        $finish = microtime(1);
        $time = $finish - $start;
        $timeTransfer = round($time, 4);

        $content['domain'] = $url;

        $content['error'] = false;
        if (!$data) {
            $content['error'] = true;
            $content['errorMessage'] = 'Wrong domain, DNS not allowed!!!';
            return $content;
        }

        $content['status'] = $data->getStatusCode();
        $content['phrase'] = $data->getReasonPhrase();

        if ($content['status'] == '200') {
            $content['time'] = $timeTransfer;
        }
        return $content;
    }

    /**
     * @param string $url
     * @return bool|ResponseInterface
     */
    public function url_get_contents(string $url)
    {

        if (!$this->checkDNS($url)) return false;
        $client = new Client();

        $response = $client->request('GET', $url, [
            'http_errors' => false,
            'connect_timeout' => 10,
            'read_timeout' => 10,
            'timeout' => 10,
            'verify' => false,
            'allow_redirects' => true,

        ]);

        return $response;
    }

    public function checkDNS(string $url): bool
    {
        $checkedURL = parse_url($url);
        if (isset($checkedURL['scheme'])) {
            return checkdnsrr($checkedURL['host']);
        }
        $domain = explode('/', $url);
        return checkdnsrr($domain[0]);

    }

}