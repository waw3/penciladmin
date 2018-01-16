<?php


namespace Waw3\PencilAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Exception;
use Log;
use DB;
use Waw3\PencilAdmin\Helpers\Helper;

/**
 * Class Configs
 * @package Waw3\PencilAdmin\Models
 *
 */
class Configs extends Model
{
    protected $table = 'pa_configs';

    protected $fillable = [
        "key", "value"
    ];

    protected $hidden = [

    ];

    /**
     * Get configuration string value by using key such as 'sitename'
     *
     * Configs::getByKey('sitename');
     *
     * @param $key key string of configuration
     * @return bool value of configuration
     */
    public static function getByKey($key)
    {
        $row = Configs::where('key', $key)->first();
        if(isset($row->value)) {
            return $row->value;
        } else {
            return false;
        }
    }

    /**
     * Get all configuration as object
     *
     * Configs::getAll();
     *
     * @return object
     */
    public static function getAll()
    {
        $configs = array();
        $configs_db = Configs::all();
        foreach($configs_db as $row) {
            $configs[$row->key] = $row->value;
        }
        return (object)$configs;
    }
}
