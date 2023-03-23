<?php

namespace App\Command;

use App\Container\DB;
use App\Container\RDS;
use App\Models\Users;
use Mix\Cli\Flag;
use Mix\Cli\RunInterface;

/**
 * Class ClearCache
 * @package App\Command
 */
class ClearCache implements RunInterface
{

    public function main(): void
    {
        $key = Flag::match('k', 'key')->string();
        RDS::instance()->del($key);
        print 'ok';
    }

}
