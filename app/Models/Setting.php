<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value', 'default'];

    public static $Default = [
        ['key' => 'store-name', 'default' => 'VPOS Lite Store'],
        ['key' => 'store-address', 'default' => 'VPOS Lite street no.1'],
        ['key' => 'store-phone', 'default' => null],
        ['key' => 'tax-use', 'default' => '1'],
        ['key' => 'tax-nominal', 'default' => '11'],
    ];
}
