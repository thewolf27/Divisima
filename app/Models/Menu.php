<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['name','location'];

    public function items()
    {
        return $this->hasMany(MenuItems::class);
    }
}