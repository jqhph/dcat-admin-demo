<?php

// Register the extension.
if (class_exists(Dcat\Admin\Admin::class)) {
    Dcat\Admin\Admin::extend(\Dcat\Page\Admin\DcatPageExtension::class);
}
