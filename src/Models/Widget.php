<?php

namespace Sinevia\Cms\Models;

class Widget extends BaseModel {

    //protected $connection = 'sinevia';
    protected $table = 'snv_cms_widget';
    protected $primaryKey = 'Id';
    public $timestamps = false;
    public $incrementing = false;
    public $useMicroId = true;
}