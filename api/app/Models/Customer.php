<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\SoftDeletes;


#[Fillable(['first_name', 'last_name', 'email', 'contact_number'])]
class Customer extends Model
{
    use SoftDeletes;
}
