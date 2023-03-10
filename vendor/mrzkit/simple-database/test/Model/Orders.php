<?php

namespace Mrzkit\SimpleDatabaseTest\Model;

use Mrzkit\SimpleDatabase\Query\Model;

class Orders extends Model
{
    /**
     * @var string 表前缀
     */
    protected $tablePrefix = 'mrz_';

    /**
     * @var string 表名
     */
    protected $table = 'orders';

    /**
     * @var string 连接
     */
    protected $connection = 'tencent-rds';

}
