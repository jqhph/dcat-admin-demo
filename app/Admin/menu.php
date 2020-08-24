<?php

return [
    [
        'id'        => 'layout',
        'title'     => '布局',
        'icon'      => 'fa-cubes',
        'uri'       => 'layout',
        'parent_id' => 0,
    ],

    /////////////////////////////////////////////////////
    [
        'id'        => 'tables',
        'title'     => '列表',
        'icon'      => 'feather icon-grid',
        'uri'       => '',
        'parent_id' => 0,
    ],

    [
        'id'        => 'grid',
        'title'     => '默认表格',
        'icon'      => 'feather icon-menu',
        'uri'       => 'components/grid',
        'parent_id' => 'tables',
    ],

    [
        'id'        => 'reports',
        'title'     => '组合表头',
        'icon'      => 'feather icon-menu',
        'uri'       => 'reports',
        'parent_id' => 'tables',
    ],
    [
        'id'        => 'fixed-columns',
        'title'     => '固定列',
        'icon'      => 'feather icon-menu',
        'uri'       => 'fixed-columns',
        'parent_id' => 'tables',
    ],
    [
        'id'        => 'with-border',
        'title'     => '边框模式+异步加载',
        'icon'      => 'feather icon-menu',
        'uri'       => 'with-border',
        'parent_id' => 'tables',
    ],
    [
        'id'        => 'grid-tree',
        'title'     => '树',
        'icon'      => 'feather icon-align-left',
        'uri'       => 'tree',
        'parent_id' => 'tables',
    ],
    [
        'id'        => 'selector',
        'title'     => '筛选器',
        'icon'      => 'feather icon-menu',
        'uri'       => 'tables/selector',
        'parent_id' => 'tables',
    ],
    [
        'id'        => 'custom-grid',
        'title'     => '自定义视图',
        'icon'      => 'feather icon-image',
        'uri'       => 'grid/custom',
        'parent_id' => 'tables',
    ],
    [
        'id'        => 'row-space',
        'title'     => '行间距模式',
        'icon'      => 'feather icon-menu',
        'uri'       => 'row-space',
        'parent_id' => 'tables',
    ],
    ///////////////////////////////

    [
        'id'        => 'form',
        'title'     => '表单',
        'icon'      => 'feather icon-edit',
        'uri'       => '',
        'parent_id' => 0,
    ],
    [
        'id'        => 'form1',
        'title'     => '表单字段',
        'icon'      => 'feather icon-edit-1',
        'uri'       => 'form',
        'parent_id' => 'form',
    ],
    [
        'id'        => 'modalf',
        'title'     => '弹窗表单',
        'icon'      => 'feather icon-edit-1',
        'uri'       => 'form/modal',
        'parent_id' => 'form',
    ],
    [
        'id'        => 'stform',
        'title'     => '分步表单',
        'icon'      => ' fa-list-ol',
        'uri'       => 'form/step',
        'parent_id' => 'form',
    ],

    [
        'id'        => 'whenform',
        'title'     => '表单动态显示',
        'icon'      => 'feather icon-edit-1',
        'uri'       => 'form/when',
        'parent_id' => 'form',
    ],

    [
        'id'        => 'full',
        'title'     => 'Full Page',
        'icon'      => 'fa-cut',
        'uri'       => 'full',
        'parent_id' => 0,
    ],

    ///////////////////////////////////////////////////////
//    [
//        'id'        => 'chart',
//        'title'     => 'Chart',
//        'icon'      => ' fa-pie-chart',
//        'uri'       => 'components/charts',
//        'parent_id' => 1,
//    ],
    [
        'id'        => 'metric-card',
        'title'     => '数据统计卡片',
        'icon'      => ' fa  fa-line-chart',
        'uri'       => 'components/metric-cards',
        'parent_id' => 1,
    ],


    ///////////////////////////////////////////////////////
    [
        'id'        => 1,
        'title'     => '组件',
        'icon'      => 'fa-building',
        'uri'       => '',
        'parent_id' => 0,
    ],


    [
        'id'        => 'modal',
        'title'     => 'Modal',
        'icon'      => ' fa fa-clone',
        'uri'       => 'components/modal',
        'parent_id' => 1,
    ],
//    [
//        'id'        => 'navbar',
//        'title'     => 'Navbar',
//        'icon'      => 'fa-navicon',
//        'uri'       => 'components/navbar',
//        'parent_id' => 1,
//    ],
    [
        'id'        => 'dropdown',
        'title'     => 'Dropdown',
        'icon'      => 'fa-list-ol',
        'uri'       => 'components/dropdown-menu',
        'parent_id' => 1,
    ],
    [
        'id'        => 'button',
        'title'     => 'Tab & Button',
        'icon'      => 'fa-btc',
        'uri'       => 'components/tab-button',
        'parent_id' => 1,
    ],
    [
        'id'        => 'checkbox',
        'title'     => 'Checkbox & Radio',
        'icon'      => 'fa-check-square-o',
        'uri'       => 'components/checkbox-radio',
        'parent_id' => 1,
    ],
    [
        'id'        => 'alert',
        'title'     => 'Alert',
        'icon'      => 'fa-circle-o-notch',
        'uri'       => 'components/alert',
        'parent_id' => 1,
    ],
    [
        'id'        => 'markdown',
        'title'     => 'Markdown',
        'icon'      => 'fa-trademark',
        'uri'       => 'components/markdown',
        'parent_id' => 1,
    ],
    [
        'id'        => 'tooltip',
        'title'     => 'Tooltip',
        'icon'      => 'fa-info-circle',
        'uri'       => 'components/tooltip',
        'parent_id' => 1,
    ],
    [
        'id'        => 'loading',
        'title'     => 'Loading',
        'icon'      => 'fa-spin fa-circle-o-notch',
        'uri'       => 'components/loading',
        'parent_id' => 1,
    ],
//    [
//        'id'        => 'accordion',
//        'title'     => 'Accordion',
//        'icon'      => 'fa-plus-circle',
//        'uri'       => 'components/accordion',
//        'parent_id' => 1,
//    ],


    ///////////////////////////////////////////////////////
    [
        'id'        => 'api',
        'title'     => 'Data From Api',
        'icon'      => 'fa-film',
        'uri'       => '',
        'parent_id' => 0,
    ],
    [
        'id'        => 'theaters',
        'title'     => 'In Theaters',
        'icon'      => '',
        'uri'       => 'movies/in-theaters',
        'parent_id' => 'api',
    ],
    [
        'id'        => 'coming',
        'title'     => 'Coming Soon',
        'icon'      => '',
        'uri'       => 'movies/coming-soon',
        'parent_id' => 'api',
    ],
    [
        'id'        => 'top250',
        'title'     => 'Top 250',
        'icon'      => '',
        'uri'       => 'movies/top250',
        'parent_id' => 'api',
    ],

    //////////////////////////////////
//    [
//        'id'        => 'extensions',
//        'title'     => 'Extension Demo',
//        'icon'      => 'fa fa-plugin',
//        'uri'       => '',
//        'parent_id' => 0,
//    ],
    [
        'id'        => 'editor',
        'title'     => '编辑器',
        'icon'      => 'fa-underline',
        'uri'       => '',
        'parent_id' => '0',
    ],
    [
        'id'        => 'tinymce',
        'title'     => 'TinyMCE',
        'icon'      => '',
        'uri'       => 'form/tinymce',
        'parent_id' => 'editor',
    ],
    [
        'id'        => 'markdown',
        'title'     => 'Markdown',
        'icon'      => '',
        'uri'       => 'form/markdown',
        'parent_id' => 'editor',
    ],
    [
        'id'        => 'ueditor',
        'title'     => 'UEditor',
        'icon'      => '',
        'uri'       => 'extensions/ueditor',
        'parent_id' => 'editor',
    ],
];
