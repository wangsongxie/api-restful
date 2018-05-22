<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUserIdentifyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("user_identify", function (Blueprint $table){
            $table->string("lon")->default('')->comment('经度');
            $table->string("lat")->default('')->comment('经度');
            $table->string("is_valid")->default(0)->comment('是否已认证');
            $table->string("region_id")->default('')->comment('地区ID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("user_identify", function (Blueprint $table){
            $table->dropColumn("lon");
            $table->dropColumn("lat");
            $table->dropColumn("is_valid");
            $table->dropColumn('created_at');
            $table->dropColumn("updated_at");
            $table->dropColumn("province_id");
            $table->dropColumn("city_id");
            $table->dropColumn("area_id");
        });
    }
}
