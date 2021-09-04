<?php

namespace Sinevia\Cms\Models;

class BaseModel extends \AdvancedModel {
    use \Illuminate\Database\Eloquent\SoftDeletes;
    
    public $timestamps = true;
    public $useUniqueId = true;
}
