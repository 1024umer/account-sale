<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomRefferal extends Model
{
    use HasFactory;

    protected $fillable = [
      'title',
      'refferal_name',
      'refferal_link',
  ];
}
