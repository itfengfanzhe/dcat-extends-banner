<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itffz_cms_banner', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100)->nullable()->comment('图片标题');
            $table->string('description')->nullable()->comment('描述');
            $table->integer('position_id')->nullable()->comment('位置');
            $table->string('link')->nullable()->comment('自定义链接');
            $table->tinyInteger('jump_where')->nullable()->default(0)->comment('跳转类型');
            $table->tinyInteger('rel_id')->nullable()->default(0)->comment('指定模块的数据id');
            $table->string('image')->nullable()->comment('图片');
            $table->integer('sort')->nullable()->comment('排序');
            $table->tinyInteger('status')->default(0)->nullable()->comment('状态');
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
        Schema::dropIfExists('itffz_cms_banner');
    }
}
