<?php
/**
 * Created by PhpStorm.
 * User: Lazarev Aleksey
 * Date: 22.08.16
 * Time: 10:26
 */


namespace app\models;


use app\components\MongoWrapper;

abstract class AbstractMongoModel
{
    /**
     * @var MongoWrapper
     */
    public $db;

    abstract function getCollection();

    abstract function getBase();

    protected function getDb()
    {

        if (empty($this->db)) {
            $this->db = \Yii::$app->mongodb->getDb();
        }

        return $this->db;
    }


    public function find($filter, $options = [])
    {

        $query = new \MongoDB\Driver\Query($filter, $options);
        $readPreference = new \MongoDB\Driver\ReadPreference(\MongoDB\Driver\ReadPreference::RP_PRIMARY);
        return $this->getDb()->executeQuery($this->getBase() . '.' . $this->getCollection(), $query, $readPreference);
    }

    public function findOne($filter, $options = [])
    {

        $cursor = $this->find($filter, $options);

        $it = new \IteratorIterator($cursor);
        $it->rewind();

        return $it->current();
    }


    public function write($filter, $newObj, $options = [])
    {

        $bulk = new \MongoDB\Driver\BulkWrite;
        $bulk->update(
            $filter,
            $newObj,
            $options
        );

        $writeConcern = new \MongoDB\Driver\WriteConcern(\MongoDB\Driver\WriteConcern::MAJORITY, 1000);
        return $this->getDb()->executeBulkWrite($this->getBase() . '.' . $this->getCollection(), $bulk, $writeConcern);
    }

    public function remove($filter, $options = [])
    {

        $bulk = new \MongoDB\Driver\BulkWrite;
        $bulk->delete(
            $filter,
            $options
        );

        $writeConcern = new \MongoDB\Driver\WriteConcern(\MongoDB\Driver\WriteConcern::MAJORITY, 1000);
        return $this->getDb()->executeBulkWrite($this->getBase() . '.' . $this->getCollection(), $bulk, $writeConcern);
    }
}