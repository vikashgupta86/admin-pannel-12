<?php

namespace Modules\RRDR\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;

class RRDRSController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'RRDRS';

        // module name
        $this->module_name = 'rrdrs';

        // directory path of the module
        $this->module_path = 'rrdr::backend';

        // module icon
        $this->module_icon = 'fa-regular fa-sun';

        // module model name, path
        $this->module_model = "Modules\RRDR\Models\RRDR";
    }

}
