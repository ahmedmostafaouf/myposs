<?php

namespace App\Traits;

use Illuminate\Support\ServiceProvider;
use PhpParser\Builder\Trait_;

Trait ImageTraits
{
    function SaveImages($photo,$folder){
        // save photo in folder();
        $file_extension= $photo -> getClientOriginalExtension();
        // بزود تايم عشان لو سيفت اكتر من مره
        $file_name=time().'.'.$file_extension;
        $path=$folder;
        $photo -> move($path,$file_name);
        return $file_name;

    }


}
