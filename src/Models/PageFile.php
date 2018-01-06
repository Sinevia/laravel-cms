<?php

namespace Sinevia\Cms\Models;

class PageFile extends BaseModel {
    protected $table = 'snv_cms_pagefile';
    protected $primaryKey = 'Id';
    public $timestamps = false;
    public $incrementing = false;    
    public $useMicroId = true;
}