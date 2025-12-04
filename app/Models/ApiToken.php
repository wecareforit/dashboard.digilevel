<?PHP

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class ApiToken extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'token', 'expires_at'];

    protected $dates = ['expires_at'];

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}