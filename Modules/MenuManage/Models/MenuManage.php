<?php

namespace Modules\MenuManage\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuManage extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'menumanages';

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\MenuManage\database\factories\MenuManageFactory::new();
    }
}
