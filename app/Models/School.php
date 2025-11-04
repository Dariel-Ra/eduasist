<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'code',
        'address',
        'district',
        'phone',
        'email',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the school's full contact info.
     *
     * @return string
     */
    public function getFullContactAttribute(): string
    {
        $contact = [];
        
        if ($this->phone) {
            $contact[] = $this->phone;
        }
        
        if ($this->email) {
            $contact[] = $this->email;
        }
        
        return implode(' | ', $contact);
    }

    /**
     * Get the school's full location.
     *
     * @return string
     */
    public function getFullLocationAttribute(): string
    {
        $location = [];
        
        if ($this->address) {
            $location[] = $this->address;
        }
        
        if ($this->district) {
            $location[] = $this->district;
        }
        
        return implode(', ', $location);
    }

    /**
     * Scope a query to search schools by name or code.
     */
    public function scopeSearch($query, ?string $search)
    {
        if (empty($search)) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('code', 'like', "%{$search}%")
              ->orWhere('district', 'like', "%{$search}%");
        });
    }

    /**
     * Scope a query to order by most recent.
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}