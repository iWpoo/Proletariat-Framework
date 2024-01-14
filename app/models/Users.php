<?php 

namespace App\Models;

use Core\Model;

class Users extends Model
{
    protected $table = 'users';

    public static function getLink() {
        return static::$link;
    }  
}