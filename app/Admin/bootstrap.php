<?php

use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Form;
use Dcat\Admin\Grid\Filter;
use Dcat\Admin\Show;
use Dcat\Admin\Repositories\Repository;

/**
 * Dcat-admin - admin builder based on Laravel.
 * @author jqhph <https://github.com/jqhph>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 *
 * extend custom field:
 * Dcat\Admin\Form::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Column::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Filter::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

// 监听器
Repository::listen('*', App\Admin\Event\RepositoryListener::class);

Admin::booting(function () {

});

// 这里加载所有皮肤，只是为了换肤切换效果，实际使用不需要加载所有皮肤
Admin::css('vendor/dcat-admin/AdminLTE/dist/css/skins/skin-blue-light.min.css');
Admin::css('vendor/dcat-admin/AdminLTE/dist/css/skins/skin-black-light.min.css');
Admin::script(
    <<<JS
$('[data-skin]').click(function () {
    var body = $('body');
    body.removeClass('skin-blue-light skin-black-light');
    body.addClass($(this).data('skin'));
});
JS

);

// 扩展Column
Grid\Column::extend('code', function ($v) {
    return "<code>$v</code>";
});

// 追加菜单
Admin::menu()->add(include __DIR__.'/menu.php', 0);

// 全局搜索表单
Admin::navbar(function ($navbar) {
    $navbar->left(
        <<<'HTML'
<div class="input-group input-sm navbar-search-form">
    <input type="text" name="global" class="form-control" placeholder="Search...">
    <span class="input-group-btn">
        <button type="submit" name="search" id="search-btn" class="btn"><i class="fa fa-search"></i></button>
     </span>
</div>
HTML
    );
});

Admin::section(function (\Dcat\Admin\Layout\SectionManager $manager) {
    return;
    // 右边菜单按钮
    $manager->inject(\AdminSection::NAVBAR_AFTER_USER_PANEL, function () {
        return <<<'HTML'
<li>
    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
</li>
HTML;
    });

    // 右边菜单栏样式
//    $manager->inject(\AdminSection::RIGHT_SIDEBAR_CLASS, 'control-sidebar-dark', false);
    // 右边菜单
    $manager->inject(\AdminSection::RIGHT_SIDEBAR, function () {
        return <<<'HTML'
<ul class="nav nav-tabs nav-justified control-sidebar-tabs">
  <li class="active"><a href="#control-sidebar-theme-demo-options-tab" data-toggle="tab"><i class="fa fa-wrench"></i></a></li><li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
  <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
</ul>
<div class="tab-content">
  <!-- Home tab content -->
  <div class="tab-pane" id="control-sidebar-home-tab">
    <h3 class="control-sidebar-heading">Recent Activity</h3>
    <ul class="control-sidebar-menu">
      <li>
        <a href="javascript:void(0)">
          <i class="menu-icon fa fa-birthday-cake bg-red"></i>

          <div class="menu-info">
            <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

            <p>Will be 23 on April 24th</p>
          </div>
        </a>
      </li>
      <li>
        <a href="javascript:void(0)">
          <i class="menu-icon fa fa-user bg-yellow"></i>

          <div class="menu-info">
            <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

            <p>New phone +1(800)555-1234</p>
          </div>
        </a>
      </li>
      <li>
        <a href="javascript:void(0)">
          <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

          <div class="menu-info">
            <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

            <p>nora@example.com</p>
          </div>
        </a>
      </li>
      <li>
        <a href="javascript:void(0)">
          <i class="menu-icon fa fa-file-code-o bg-green"></i>

          <div class="menu-info">
            <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

            <p>Execution time 5 seconds</p>
          </div>
        </a>
      </li>
    </ul>
    <!-- /.control-sidebar-menu -->

    <h3 class="control-sidebar-heading">Tasks Progress</h3>
    <ul class="control-sidebar-menu">
      <li>
        <a href="javascript:void(0)">
          <h4 class="control-sidebar-subheading">
            Custom Template Design
            <span class="label label-danger pull-right">70%</span>
          </h4>

          <div class="progress progress-xxs">
            <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
          </div>
        </a>
      </li>
      <li>
        <a href="javascript:void(0)">
          <h4 class="control-sidebar-subheading">
            Update Resume
            <span class="label label-success pull-right">95%</span>
          </h4>

          <div class="progress progress-xxs">
            <div class="progress-bar progress-bar-success" style="width: 95%"></div>
          </div>
        </a>
      </li>
      <li>
        <a href="javascript:void(0)">
          <h4 class="control-sidebar-subheading">
            Laravel Integration
            <span class="label label-warning pull-right">50%</span>
          </h4>

          <div class="progress progress-xxs">
            <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
          </div>
        </a>
      </li>
      <li>
        <a href="javascript:void(0)">
          <h4 class="control-sidebar-subheading">
            Back End Framework
            <span class="label label-primary pull-right">68%</span>
          </h4>

          <div class="progress progress-xxs">
            <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
          </div>
        </a>
      </li>
    </ul>
    <!-- /.control-sidebar-menu -->

  </div><div id="control-sidebar-theme-demo-options-tab" class="tab-pane active"><div>
<h4 class="control-sidebar-heading">Skins</h4><ul class="list-unstyled clearfix">
  
  <li style="float:left; width: 33.33333%; padding: 5px;">
  <a href="javascript:void(0)" data-skin="skin-black-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover waves-effect"><div style="box-shadow:0 0 2px rgba(0,0,0,0.1)" class="clearfix"><span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe"></span>
  <span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe"></span></div><div><span style="display:block;width:20%; float:left; height: 20px; background: #222"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div></a><p class="text-center no-margin font-12">Black Light</p></li>
<li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0)" data-skin="skin-blue-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix waves-effect full-opacity-hover"><div><span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9"></span>
<span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span></div><div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div></a><p class="text-center no-margin" style="font-size: 12px">Blue Light</p></li>

</ul></div></div>
  <!-- /.tab-pane -->
  <!-- Stats tab content -->
  <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
  <!-- /.tab-pane -->
  <!-- Settings tab content -->
  <div class="tab-pane" id="control-sidebar-settings-tab">
    <form method="post">
      <h3 class="control-sidebar-heading">General Settings</h3>

      <div class="form-group">
        <label class="control-sidebar-subheading">
          Report panel usage
          <input type="checkbox" class="pull-right" checked="">
        </label>

        <p>
          Some information about this general settings option
        </p>
      </div>
      <!-- /.form-group -->

      <div class="form-group">
        <label class="control-sidebar-subheading">
          Allow mail redirect
          <input type="checkbox" class="pull-right" checked="">
        </label>

        <p>
          Other sets of options are available
        </p>
      </div>
      <!-- /.form-group -->

      <div class="form-group">
        <label class="control-sidebar-subheading">
          Expose author name in posts
          <input type="checkbox" class="pull-right" checked="">
        </label>

        <p>
          Allow the user to show his name in blog posts
        </p>
      </div>
      <!-- /.form-group -->

      <h3 class="control-sidebar-heading">Chat Settings</h3>

      <div class="form-group">
        <label class="control-sidebar-subheading">
          Show me as online
          <input type="checkbox" class="pull-right" checked="">
        </label>
      </div>
      <!-- /.form-group -->

      <div class="form-group">
        <label class="control-sidebar-subheading">
          Turn off notifications
          <input type="checkbox" class="pull-right">
        </label>
      </div>
      <!-- /.form-group -->

      <div class="form-group">
        <label class="control-sidebar-subheading">
          Delete chat history
          <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
        </label>
      </div>
      <!-- /.form-group -->
    </form>
  </div>
  <!-- /.tab-pane -->
</div>
HTML;
    });
});
