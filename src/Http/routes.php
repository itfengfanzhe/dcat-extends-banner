<?php

use Dcat\Admin\Banner\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('cms_banner', Controllers\BannerController::class.'@index'); // 首页
Route::get('cms_banner/addPosition', Controllers\BannerController::class.'@createPosition'); // 轮播图位置新增form
Route::get('cms_banner/editPosition/{id}/edit', Controllers\BannerController::class.'@editPosition'); // 轮播图位置修改form
Route::post('cms_banner/positionStore', Controllers\BannerController::class.'@positionStore'); // 轮播图位置执行新增
Route::put('cms_banner/positionUpdate/{id}', Controllers\BannerController::class.'@positionUpdate'); // 轮播图位置执行修改
Route::get('/cms_banner/editPosition', Controllers\BannerController::class.'@index'); // 轮播图位置列表页面
Route::delete('/cms_banner/editPosition/{id}', Controllers\BannerController::class.'@deletePosition'); // 轮播图位置删除
