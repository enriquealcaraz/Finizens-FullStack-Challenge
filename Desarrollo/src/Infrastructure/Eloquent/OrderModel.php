<?php
namespace Finizens\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    protected $table = 'order';
    public $timestamps = false;
    
    protected $fillable = ['id', 'portfolio', 'allocation', 'shares', 'type', 'status'];
}
