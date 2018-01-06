<?php

Route::get('knowledgebase', function () {
    dd('LOADED KNOWLEDBASE VIEW');
    return view('knowledge::admin');
});