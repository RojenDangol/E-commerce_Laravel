<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactInfoMeta extends Model
{
    protected $fillable = ['contact_info_id', 'key', 'value'];

    public function contactInfo()
    {
        return $this->belongsTo(ContactInformation::class, 'contact_info_id', 'id');
    }
}
