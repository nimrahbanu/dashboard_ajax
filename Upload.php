<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Upload extends Model
{
    use SoftDeletes;
    protected $table = 'upload';
    protected $primaryKey = 'upload_id';
    public $timestamps = true;
    const CREATED_AT = 'upload_created_at';
    const UPDATED_AT = 'upload_updated_at';
    const   DELETED_AT = 'upload_deleted_at';


    public function category()
    {
    }
    // public static function stateDropdown()
    // {

    //     return  self::orderBy('journal_title', 'asc')->pluck('journal_title', 'journal_id')->toArray();
    // }
}
