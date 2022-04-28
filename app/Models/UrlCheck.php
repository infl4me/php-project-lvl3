<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrlCheck extends Model
{
    use HasFactory;
    protected $fillable = ['status_code'];

    public function url()
    {
        return $this->belongsTo('App\Models\Url');
    }
}
