<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppTopCategory extends Model
{
    protected $table = 'appTopCategory';

    protected $primaryKey = 'id_appTopCategory';

    public $timestamps = false;

    protected $fillable = ['id_application', 'id_app', 'date', 'context'];
}
