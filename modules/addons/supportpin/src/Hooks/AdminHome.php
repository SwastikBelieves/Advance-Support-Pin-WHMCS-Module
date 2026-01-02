<?php

namespace SwastikDev\SupportPin\Hooks;

use WHMCS\Module\AbstractWidget;
use WHMCS\Database\Capsule;

class AdminHome extends AbstractWidget
{
    protected $title = 'SupportPin';
    protected $description = '';
    protected $weight = 60;
    protected $wrapper = false;
    protected $cache = false;

    public function getData()
    {
        return [];
    }

    public function generateOutput($data)
    {

        $adminlang_global_search = \AdminLang::trans('global.search');

        return <<<EOF
<div class="panel panel-default" data-widget="SupportPinWidget">
    <div class="panel-heading">
        <div class="widget-tools">
            <a href="#" class="widget-minimise"><i class="fas fa-chevron-up"></i></a>
            <a href="#" class="widget-hide"><i class="fas fa-times"></i></a>
        </div>
        <h3 class="panel-title" style="touch-action: none;">Support PIN</h3>
    </div>
    <div class="panel-body">
        <div class="widget-content-padded">
            <div class="text-center">
                <form action="addonmodules.php?module=supportpin" method="post" style="text-align: center;">
                    <div class="input-group input-group-sm">
                        <input type="number" name="searchsupportpin" class="form-control" required>
                        <div class="input-group-btn">
                            <input type="submit" class="btn btn-success btn-sm" value="{$adminlang_global_search}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
EOF;
    }
}
