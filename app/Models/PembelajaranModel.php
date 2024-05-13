<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelajaranModel extends Model
{
    use HasFactory;
    protected $table = 'pembelajaran';
    protected $guarded = ['id'];
}
