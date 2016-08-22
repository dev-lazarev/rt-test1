<?php
/**
 * Created by PhpStorm.
 * User: Lazarev Aleksey
 * Date: 22.08.16
 * Time: 10:24
 */

namespace app\components;

class MongoWrapper
{
    /**
     * @var \MongoClient
     */
    private $client = null;
    private $db;
    private $connected = false;

    public $dsn;
    public $dbName;

    public function init()
    {

    }


    /**
     * @return bool|\MongoDB database or false on error
     * @throws /InvalidArgumentException
     */
    public function getDb()
    {
        if (!$this->connected && !$this->connect()) {
            return false;
        }
        return $this->db;
    }


    public function closeConnection()
    {
        if ($this->connected && $this->client) {
            $this->client->close(true);
            $this->connected = false;
        }
    }

    public static function isValidResult($res)
    {
        return (!empty($res) && isset($res['ok']) && $res['ok'] === 1);
    }

    /**
     * @return /\MongoDB\Driver\Manager|null
     * @throws /InvalidArgumentException
     */
    public function connect()
    {
        $this->client = new \MongoDB\Driver\Manager($this->dsn);
        $this->db = $this->client;
        $this->connected = true;

        return $this->client;
    }


    public function isConnected()
    {
        return $this->connected;
    }

}