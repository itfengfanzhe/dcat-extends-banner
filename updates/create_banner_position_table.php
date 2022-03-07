<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannerPositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itffz_cms_banner_position', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable()->comment('位置');
            $table->string('description')->nullable()->comment('描述');
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
        Schema::dropIfExists('itffz_cms_banner_position');
    }
}
