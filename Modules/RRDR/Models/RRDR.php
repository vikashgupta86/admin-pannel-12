<?php

namespace Modules\RRDR\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class RRDR extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'rrdrs';

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\RRDR\database\factories\RRDRFactory::new();
    }
}
