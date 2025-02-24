<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactInformation extends Model
{
    protected $fillable = ['address', 'email', 'phone']; // Add fields for mass assignment

    // Define the correct relationship with ContactInfoMeta
    public function metas()
    {
        return $this->hasMany(ContactInfoMeta::class, 'contact_info_id', 'id');
    }

    // Save meta key-value pairs
    public function setMetaValue($key, $value)
    {
        return $this->metas()->updateOrCreate(
            ['key' => $key, 'contact_info_id' => $this->id], 
            ['value' => is_array($value) ? implode(',', $value) : $value]
        );
    }

    // Get a meta value
    public function getMetaValue($id)
    {
        // Fetch all meta records for the given contact_info_id
        $metas = $this->where('id', $id)->first()->metas;

        // Return an array of key-value pairs
        return $metas->pluck('value', 'key')->toArray();
    }
}
