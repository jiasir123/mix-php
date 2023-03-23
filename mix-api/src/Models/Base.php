<?php

namespace App\Models;

use App\Container\DB;
use Mix\Database\ConnectionInterface;

class Base
{
    /**
     * 定义表名
     * @var string
     */
    protected $table;

    /**
     * 定义表主键
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var ConnectionInterface
     */
    protected $query;

    public function __construct()
    {
        $this->query = DB::instance()->table($this->table);
    }

    /**
     * @return ConnectionInterface
     */
    public static function query(): ConnectionInterface
    {
        $new = new static();
        return $new->query;
    }

    /**
     * @param $id
     * @return array|false|object
     */
    public static function find($id)
    {
        $new = new static();
        return $new->query->where("$new->primaryKey = ?", $id)->first();
    }

    /**
     * @param $data
     * @return int
     */
    public static function create($data): int
    {
        $new = new static();

        $createData = array_merge($data, $new->getNowTime());

        return $new->query->insert($new->table, $createData)->rowCount();
    }


    /**
     * @param array $data
     * @param int $len
     * @return int
     */
    public static function createInBatches(array $data, int $len): int
    {
        if ($len == 0) {
            return 0;
        }

        $new = new static();

        $createData = [];
        if ($len == 1) {
            $createData = $data[0];
        } else {
            foreach ($data as $val) {
                $createData[] = array_merge($val, $new->getNowTime());
            }
        }

        return $new->query->insert($new->table, $createData)->rowCount();
    }

    public function getNowTime(): array
    {
        return [
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ];
    }
}