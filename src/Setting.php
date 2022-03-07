<?php

namespace Dcat\Admin\Banner;

use Dcat\Admin\Extend\Setting as Form;

class Setting extends Form
{
    public function form()
    {
        $this->radio('action_style', '操作样式')->options(['下拉', '展开', '右键']);
        $this->url("frontend_base_url", '域名地址')->placeholder("example: https://yourdomain.com")->help("用于图片地址拼接，设置为空的话默认从env中获取");
    }
}
