<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/MailSetting.php
class MailSetting extends Model
{
    protected $fillable = [
        'mail_mailer', 'mail_host', 'mail_port',
        'mail_username', 'mail_password', 'mail_encryption',
        'mail_from_address', 'mail_from_name',
    ];

    protected function mailPassword(): Attribute
    {
        return Attribute::make(
            get: fn($value) => decrypt($value),
            set: fn($value) => encrypt($value),
        );
    }
}
