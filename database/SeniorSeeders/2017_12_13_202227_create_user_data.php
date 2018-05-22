<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserData extends Migration
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function up()
    {
        //
//        factory(App\User::class, 100)->create();
        factory(App\UserInfo::class, 100)->create();
        factory(App\ArticleComment::class, 1000)->create();
    }

    /**
     * Reverse the seeder.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
