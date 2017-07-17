<?php namespace Chy2015\Translations\Models;

use Illuminate\Database\Eloquent\Model;

class Strings extends Model
{
    protected $connection = 'locations';
    protected $table = 'strings';
    protected $primaryKey = 'code';

    protected $guarded = [];
}
