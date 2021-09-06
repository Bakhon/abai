<?php

namespace App\Traits;

trait ClearOmgNgduOnDelete
{
    public static function boot() {
        parent::boot();
        self::deleting(function($object) {
            $object->omgngdu()->each(function($omgngdu) {
                $omgngdu->delete();
            });
        });
    }
}