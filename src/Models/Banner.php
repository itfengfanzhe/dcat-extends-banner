<?php
namespace Dcat\Admin\Banner\Models;

use Dcat\Admin\Admin;
use Dcat\Admin\Banner\BannerServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use JetBrains\PhpStorm\ArrayShape;

class Banner extends Model
{
    protected $table = 'itffz_cms_banner';

    /**
     * 获取轮播图列表
     * @param int $position_id 轮播图位置
     * @param int $limit 获取多少条数据 0不分页
     * @return array                    返回一个数组['count' => 10, 'list' => [....]]
     * @throws \Exception
     * @author 张建伟 <itfengfanzhe@163.com>
     */
    #[ArrayShape(['count' => "int", 'list' => "array|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection"])]
    public static function getBannerList(int $position_id, int $limit = 10): array
    {
        if (!Admin::extension()->enabled('itfengfanzhe.dcat-admin-banner')) {
            throw new \Exception('该扩展未启用');
        }
        $query = Banner::query()
            ->when($position_id, function ($query) use ($position_id){
               $query->where('position_id', $position_id);
            })
            ->where('status', 1)
            ->orderBy('sort', 'desc');
        if ($limit > 0) {
            $list = $query->paginate($limit);
            $data = [
                'count' => $list->total(),
                'list' => $list->items()
            ];
        } else {
            $list = $query->get();
            $data = [
                'count' => $query->count(),
                'list' => $list
            ];
        }
        foreach ($data['list'] as $val) {
            $val->image = self::formatPath($val->image);
        }
        return $data;
    }

    /**
     * 获取轮播图详情
     * @param int $banner_id        轮播图id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model|null
     * @throws \Exception
     * @author 张建伟 <itfengfanzhe@163.com>
     */
    public static function detail(int $banner_id): Model|array|null
    {
        if (!Admin::extension()->enabled('itfengfanzhe.dcat-admin-banner')) {
            throw new \Exception('该扩展未启用');
        }
        $detail = Banner::query()->find($banner_id);
        $detail->image = self::formatPath($detail->image);

        return $detail;
    }

    /**
     * 关联轮播图位置表
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     * @author 张建伟 <itfengfanzhe@163.com>
     */
    public function getPosition()
    {
        return $this->hasOne(BannerPosition::class, 'id', 'position_id');
    }

    /**
     * 格式化地址
     * @param mixed $path
     * @return mixed|string
     * @author 张建伟 <itfengfanzhe@163.com>
     */
    public static function formatPath($path = ''): string
    {
        $frontend_base_url = BannerServiceProvider::setting('frontend_base_url');
        if ($path) {
            preg_match('/http/', $path, $match);
            if ($match) {
                return $path;
            }
            if (empty($frontend_base_url)) {
                return env('APP_URL').Storage::url($path);
            } else {
                return $frontend_base_url.Storage::url($path);
            }

        }
        return '';
    }
}
