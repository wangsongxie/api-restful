<?php

namespace QiaWeiCom\SeniorSeeder\Providers;

use Illuminate\Support\ServiceProvider;
use QiaWeiCom\SeniorSeeder\Console\FreshCommand;
use QiaWeiCom\SeniorSeeder\Console\InstallCommand;
use QiaWeiCom\SeniorSeeder\Console\RefreshCommand;
use QiaWeiCom\SeniorSeeder\Console\ResetCommand;
use QiaWeiCom\SeniorSeeder\Console\RollbackCommand;
use QiaWeiCom\SeniorSeeder\Console\SeniorSeederCommand;
use QiaWeiCom\SeniorSeeder\Console\SeniorSeederMakeCommand;
use QiaWeiCom\SeniorSeeder\Console\StatusCommand;
use QiaWeiCom\SeniorSeeder\DatabaseMigrationRepository;
use QiaWeiCom\SeniorSeeder\SeniorSeeder;
use QiaWeiCom\SeniorSeeder\SeniorSeederCreator;

class SeniorSeederServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $path = realpath(__DIR__.'/../../config/config.php');

        $this->publishes([$path => config_path('senior_seeder.php')], 'config');
        $this->mergeConfigFrom($path, 'senior_seeder');
        //
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRepository();

        $this->registerSeeder();

        $this->registerCreator();

        $this->registerCommands();
    }

    /**
     * Register the migration repository service.
     *
     * @return void
     */
    protected function registerRepository()
    {
        $this->app->singleton('SeniorSeeder.repository', function ($app) {
            $table = $app['config']['senior_seeder.seedersTable'];
            return new DatabaseMigrationRepository($app['db'], $table);
        });
    }

    /**
     * Register the seeder service.
     *
     * @return void
     */
    protected function registerSeeder()
    {
        // The seeder is responsible for actually running and rollback the migration
        // files in the application. We'll pass in our database connection resolver
        // so the seeder can resolve any of these connections when it needs to.
        $this->app->singleton('SeniorSeeder', function ($app) {
            $repository = $app['SeniorSeeder.repository'];
            return new SeniorSeeder($repository, $app['db'], $app['files']);
        });
    }

    /**
     * Register the seeder creator.
     *
     * @return void
     */
    protected function registerCreator()
    {
        $this->app->singleton('SeniorSeeder.creator', function ($app) {
            return new SeniorSeederCreator($app['files']);
        });
    }


    public function registerCommands()
    {
        $this->app->singleton('command.SeniorSeeder', function ($app) {
            return new SeniorSeederCommand($app['SeniorSeeder']);
        });

        $this->app->singleton('command.SeniorSeeder.fresh', function () {
            return new FreshCommand();
        });


        $this->app->singleton('command.SeniorSeeder.reset', function ($app) {
            return new ResetCommand($app['SeniorSeeder']);
        });


        $this->app->singleton('command.SeniorSeeder.rollback', function ($app) {
            return new RollbackCommand($app['SeniorSeeder']);
        });

        $this->app->singleton('command.SeniorSeeder.status', function ($app) {
            return new StatusCommand($app['SeniorSeeder']);
        });

        $this->app->singleton('command.SeniorSeeder.make', function ($app) {
            // Once we have the migration creator registered, we will create the command
            // and inject the creator. The creator is responsible for the actual file
            // creation of the migrations, and may be extended by these developers.
            $creator = $app['SeniorSeeder.creator'];

            $composer = $app['composer'];

            return new SeniorSeederMakeCommand($creator, $composer);
        });


        $this->app->singleton('command.SeniorSeeder.refresh', function () {
            return new RefreshCommand();
        });

        $this->app->singleton('command.SeniorSeeder.install', function ($app) {
            return new InstallCommand($app['SeniorSeeder.repository']);
        });

        $this->commands([
            'command.SeniorSeeder',
            'command.SeniorSeeder.install',
            'command.SeniorSeeder.make',
        ]);
    }
}
