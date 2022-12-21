<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
  protected $guarded = array('id');

  public static $rules = array(
    'body' => ['required', 'string', 'max:255'],
  );

  use SoftDeletes;
}
