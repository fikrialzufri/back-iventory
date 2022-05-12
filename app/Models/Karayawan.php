<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karayawan extends Model
{
    use HasFactory;
    use UsesUuid;
    // mengnonaktifkan incrementing
    public $incrementing = false;
    protected $fillable = [];
    protected $guarded = [];
}
