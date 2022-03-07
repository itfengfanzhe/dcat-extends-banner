<?php
namespace Dcat\Admin\Banner\Forms;

use Dcat\Admin\Banner\Models\Banner;
use Dcat\Admin\Contracts\LazyRenderable;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Facades\Schema;

class EditBannerForm extends Form implements LazyRenderable
{
    use LazyWidget;

    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return mixed
     */
    public function handle(array $input)
    {
        $id = $input['id'];
        $banner = Banner::find($id);
        if (!$banner) {
            return $this->response()->error('参数错误');
        }
        $data = $this->checkField($banner, $input, ['id']);
        foreach ($data as $key => $val) {
            $banner->$key = $val;
        }

        if (!$banner->save()) {
            return $this->response()->error('操作失败');
        }

        return $this
            ->response()
            ->success('操作成功')
            ->refresh();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->hidden('id')->value($this->payload['id'] ?? 0);
        $this->text('title', '标题');
        $this->textarea('description', '描述');
        $this->image('image', '图片')->uniqueName();
        $this->text('link', '链接');
        $this->switch('status', '启用')->default(0);
        $this->number('sort', '排序');
    }

    /**
     * 验证字段数据
     * @param $model
     * @param $data
     * @param array $expire
     * @return mixed
     * @author 张建伟 <itfengfanzhe@163.com>
     */
    private function checkField($model, $data, $expire = [])
    {
        $allFiled = Schema::getColumnListing($model->getTable());
        foreach ($data as $k => $v) {
            // 检验值是否存在
            if (!in_array($k, $allFiled)) {
                unset($data[$k]);
            }
            if (in_array($k, $expire)) {
                unset($data[$k]);
            }
        }

        return $data;
    }

    /**
     * The data of the form.
     *
     * @return array
     */

    public function default()
    {
        $id = $this->payload['id'] ?? 0;
        return Banner::find($id)?->toArray() ?? [];
    }
}
