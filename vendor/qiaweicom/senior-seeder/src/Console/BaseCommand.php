<?php

namespace QiaWeiCom\SeniorSeeder\Console;

use Illuminate\Console\Command;

class BaseCommand extends \Illuminate\Database\Console\Migrations\BaseCommand
{

    /**
     * config seeders patch
     *
     * @return string
     */
    protected function getMigrationPath()
    {
        return $this->laravel->databasePath().DIRECTORY_SEPARATOR. config('senior_seeder.seederDir');
    }
}
