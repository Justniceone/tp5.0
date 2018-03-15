<?php
namespace Lib;
use think\Config;
use think\Exception;
use think\Log;

class Redis
{
    protected $redis;
    protected $config;

    public function __construct()
    {
        $this->redis = new \Redis();
        $this->config = Config::get('redis');
        $this->connect();
    }

    protected function connect()
    {
        try
        {
            $this->redis->connect($this->config['host'],$this->config['port']);
        }catch (Exception $exception)
        {
            Log::log('connecting to redis failed at'.date('Y-m-d H:i:s'));
        }
    }

    public function save($key,$value,$expiration = 86400)
    {
        $this->redis->set($key,$value,$expiration);
    }

    public function get($key)
    {
        return $this->redis->get($key);
    }

    public function ttl($key)
    {
        return $this->redis->ttl($key);
    }
}