<?php

namespace QiaWeiCom\SeniorSeeder\Console;

use Illuminate\Console\Command;
use QiaWeiCom\SeniorSeeder\DatabaseMigrationRepository;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Database\Migrations\MigrationRepositoryInterface;

class InstallCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'seniorSeeder:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the senior seeder repository';

    /**
     * The repository instance.
     *
     * @var \Illuminate\Database\Migrations\MigrationRepositoryInterface
     */
    protected $repository;

    /**
     * Create a new migration install command instance.
     *
     * @param  \Illuminate\Database\Migrations\MigrationRepositoryInterface  $repository
     * @return void
     */
    public function __construct(DatabaseMigrationRepository $repository)
    {
        parent::__construct();

        $this->repository = $repository;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->repository->setSource($this->input->getOption('database'));

        $this->repository->createRepository();

        $this->info('Seeders table created successfully.');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['database', null, InputOption::VALUE_OPTIONAL, 'The database connection to use.'],
        ];
    }
}
