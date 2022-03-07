# Dcat Admin 后台扩展
- banner轮播图模型
```php
$banner = new \Dcat\Admin\Banner\Models\Banner();
```
- banner模型中的一些方法
1. 获取轮播图列表
```php
/**
 * 获取轮播图列表
 * @param int $position_id 轮播图位置
 * @param int $limit 获取多少条数据 0不分页
 * @return array                    返回一个数组['count' => 10, 'list' => [....]]
 * @throws \Exception
 * @author 张建伟 <itfengfanzhe@163.com>
 */
#[ArrayShape(['count' => "int", 'list' => "array|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection"])]
public static function getBannerList(int $position_id, int $limit = 10): array {}
```
2. 获取轮播图详情
```php
/**
 * 获取轮播图详情
 * @param int $banner_id        轮播图id
 * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model|null
 * @throws \Exception
 * @author 张建伟 <itfengfanzhe@163.com>
 */
public static function detail(int $banner_id): Model|array|null {}
```
- 轮播图位置模型
```php
$position = new \Dcat\Admin\Banner\Models\BannerPosition();
```


