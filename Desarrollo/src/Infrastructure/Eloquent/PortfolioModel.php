<?php
namespace Finizens\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Model;

class PortfolioModel extends Model
{
    protected $table = 'portfolio';
    public $timestamps = false;   
}