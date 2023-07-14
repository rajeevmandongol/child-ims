<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model {
    use HasFactory;

    // if your key name is not 'id'
    // you can also set this to null if you don't have a primary key
    protected $primaryKey = 'id';

    protected $fillable = [
        "child_first_name",
        "child_middle_name",
        "child_last_name",
        "child_age",
        "child_gender",
        "child_different_address",
        "child_address",
        "child_city",
        "child_state",
        "child_country",
        "child_zip_code",
    ];
}
