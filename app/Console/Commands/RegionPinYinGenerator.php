<?php

namespace App\Console\Commands;

use App\Region;
use Illuminate\Console\Command;

class RegionPinYinGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'region:pinyin-generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'region generate pinyin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //

        $regions = Region::all();

        foreach ($regions as $region) {
            $name = str_replace(['省', '市', '县', '区'], '', $region->name);
            $region->pinyin = pinyin_permalink($name,'');
            echo  $region->pinyin . "\n";
            $region->save();
        }

    }
}
