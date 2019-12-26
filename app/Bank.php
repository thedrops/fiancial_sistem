<?php

namespace App;

use App\Currency;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Bank extends Model
{
    use SoftDeletes;

    protected $table = 'banks';
    protected $fillable = [
        'name','currency_id'
    ];

    public function currency(){
        return $this->belongsTo('App\Currency')->withTrashed();
    }
}
