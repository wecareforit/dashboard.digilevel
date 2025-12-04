<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Attachment extends Model implements Auditable
{

    use SoftDeletes;

    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['model', 'filename', 'model', 'filename', 'original_filename', 'extention', 'description', 'size', 'user_id', 'item_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function type()
    {
        return $this->belongsTo(uploadType::class);
    }

}
