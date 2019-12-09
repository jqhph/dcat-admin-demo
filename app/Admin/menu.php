<?php

return [
    [
        'id'        => 'layout',
        'title'     => 'Layout',
        'icon'      => 'fa-cubes',
        'uri'       => 'layout',
        'parent_id' => 0,
    ],

    /////////////////////////////////////////////////////
    [
        'id'        => 'tables',
        'title'     => 'Table',
        'icon'      => '  ti-view-grid',
        'uri'       => '',
        'parent_id' => 0,
    ],

    [
        'id'        => 'grid',
        'title'     => 'Default',
        'icon'      => 'fa-table',
        'uri'       => 'components/grid',
        'parent_id' => 'tables',
    ],

    [
        'id'        => 'reports',
        'title'     => 'Reports',
        'icon'      => 'fa-align-left',
        'uri'       => 'reports',
        'parent_id' => 'tables',
    ],


    [
        'id'        => 'selector',
        'title'     => 'Selector',
        'icon'      => '   fa-filter',
        'uri'       => 'tables/selector',
        'parent_id' => 'tables',
    ],

    ///////////////////////////////

    [
        'id'        => 'form',
        'title'     => 'Form',
        'icon'      => 'ti-pencil-alt',
        'uri'       => '',
        'parent_id' => 0,
    ],
    [
        'id'        => 'form1',
        'title'     => '普通表单',
        'icon'      => 'ti-pencil-alt',
        'uri'       => 'form',
        'parent_id' => 'form',
    ],
    [
        'id'        => 'modalf',
        'title'     => '弹窗表单',
        'icon'      => ' ti-new-window',
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
        'id'        => 'simple',
        'title'     => 'Simple Page',
        'icon'      => 'fa-cut',
        'uri'       => 'simple',
        'parent_id' => 0,
    ],

    ///////////////////////////////////////////////////////
    [
        'id'        => 'chart',
        'title'     => 'Chart',
        'icon'      => ' fa-pie-chart',
        'uri'       => 'components/charts',
        'parent_id' => 1,
    ],
    [
        'id'        => 'data-card',
        'title'     => 'Data Card',
        'icon'      => ' fa fa-clone',
        'uri'       => 'components/data-cards',
        'parent_id' => 1,
    ],


    ///////////////////////////////////////////////////////
    [
        'id'        => 1,
        'title'     => 'Components',
        'icon'      => 'fa-building',
        'uri'       => '',
        'parent_id' => 0,
    ],
    [
        'id'        => 'navbar',
        'title'     => 'Navbar',
        'icon'      => 'fa-navicon',
        'uri'       => 'components/navbar',
        'parent_id' => 1,
    ],
    [
        'id'        => 'dropdown',
        'title'     => 'Dropdown Menu',
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
        'id'        => 'layer',
        'title'     => 'Layer弹出层',
        'icon'      => 'fa-arrows-alt',
        'uri'       => 'components/layer',
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
    [
        'id'        => 'accordion',
        'title'     => 'Accordion',
        'icon'      => 'fa-plus-circle',
        'uri'       => 'components/accordion',
        'parent_id' => 1,
    ],


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
        'icon'      => 'ti-list-ol',
        'uri'       => 'movies/in-theaters',
        'parent_id' => 'api',
    ],
    [
        'id'        => 'coming',
        'title'     => 'Coming Soon',
        'icon'      => 'ti-list-ol',
        'uri'       => 'movies/coming-soon',
        'parent_id' => 'api',
    ],
    [
        'id'        => 'top250',
        'title'     => 'Top 250',
        'icon'      => 'ti-list-ol',
        'uri'       => 'movies/top250',
        'parent_id' => 'api',
    ],

    //////////////////////////////////
    [
        'id'        => 'extensions',
        'title'     => 'Extension Demo',
        'icon'      => 'ti-panel',
        'uri'       => '',
        'parent_id' => 0,
    ],
    [
        'id'        => 'UEditor',
        'title'     => 'UEditor',
        'icon'      => 'fa-underline',
        'uri'       => 'extensions/ueditor',
        'parent_id' => 'extensions',
    ],

];
