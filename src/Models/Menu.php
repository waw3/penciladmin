<?php


namespace Waw3\PencilAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Waw3\PencilAdmin\Helpers\Helper;

/**
 * Class Menu
 * @package Waw3\PencilAdmin\Models
 *
 * Menu Model which looks after Menus in Sidebar and Navbar
 */
class Menu extends Model
{
    protected $table = 'pa_menus';
    
    protected $guarded = [
    
    ];
}
