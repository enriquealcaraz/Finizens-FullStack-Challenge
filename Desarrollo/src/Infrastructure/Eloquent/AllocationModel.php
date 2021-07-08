<?php
namespace Finizens\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Model;

class AllocationModel extends Model
{
    protected $table = 'allocation';
    public $timestamps = false;
    
    protected $fillable = ['id', 'portfolio', 'shares'];
}