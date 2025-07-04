<?php

namespace App\Classes;

class ValidatorClass
{
    public static function checkValidator($validator){
        if($validator->fails()){
            return [
                'status'=>false,
                'errors'=>$validator->errors()
            ];
        }
        return [
            'status'=>true,
        ];
    }
}
