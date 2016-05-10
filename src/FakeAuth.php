<?php

namespace Listo;

/**
 * FakeAuth.
 *
 * @author Jun Takeuchi <jakeun.mob@gmail.com>
 */
class FakeAuth
{
    protected $accessKey;
    protected $secretAccessKey;
    public $logger;

    public function __construct($config)
    {
        $this->accessKey = self::array_get($config, 'acceskey');
        $this->secretAccessKey = self::array_get($config, 'secretaccesskey');
    }

    public function auth($request)
    {
        $reqauth = $request->headers->get('Authorization');
        $this->logger->debug('Head Authorization: '. $reqauth);
        $this->logger->debug('accessKey: '. $this->accessKey);
        $this->logger->debug('strpos:'. strpos($reqauth, 'AWS '.$this->accessKey));
        return (strpos($reqauth, 'AWS '.$this->accessKey) === 0);
    }

    static function array_get($array, $key, $default = '')
    {
        return isset($array[$key]) ? $array[$key] : $default;
    }

    function array_log($array)
    {
        foreach($array as $k => $v) {
            $this->logger->info(' '. $k .' => '.$v);
        }
    }
}
