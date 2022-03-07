<?php
namespace Dcat\Admin\Banner\Extensions;

use Dcat\Admin\Banner\Models\Banner;
use Dcat\Admin\Grid\RowAction;
use Illuminate\Http\Request;

class DeleteBannerAction extends RowAction
{
    public function title()
    {
        return '删除';
    }

    public function confirm()
    {
        return [
            '确定要删除该数据吗？',
            $this->row->title
        ];
    }

    public function handle(Request $request)
    {
        $id = $this->getKey();
        Banner::find($id)->delete();

        return $this->response()->success('删除成功')->refresh();
    }

    public function parameters()
    {
        return [];
    }

}
