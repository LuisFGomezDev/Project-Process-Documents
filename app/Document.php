<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable=[

        "role_id", "title", "file_name", "expired_date", "email", "mobile"
    ];


    public $timestamps  = false;
}
