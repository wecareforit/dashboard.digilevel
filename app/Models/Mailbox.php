<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Carbon\Carbon;

class Mailbox extends Model
{
    protected $fillable = 
    [
        'server', 'email', 'password', 'portnumber', 'security_protocol', 'company_id', 'last_succes_at', 'last_error_at', 'last_error_message'
    ];   

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
