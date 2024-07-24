<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Constituency extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'constituencies';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_code',
        'short_code',
        'name',
        'name_cy',
        'gss_code',
        'three_code',
        'nation',
        'region',
        'con_type',
        'electorate',
        'area',
        'density',
        'center_lat',
        'center_lon',
    ];

    public function localAuthorities()
    {
        return $this->belongsToMany(LocalAuthority::class)
            ->withPivot('overlap_area', 'original_area', 'percentage_overlap_area', 'percentage_overlap_pop', 'overlap_pop', 'original_pop', '__index_level_0__')
            ->withTimestamps()
            ->withCasts([
                'percentage_overlap_area' => 'float',
            ]);
    }

    public function charities()
    {
        return $this->hasMany(Charity::class);
    }

    public function towns(): BelongsToMany
    {
        return $this->belongsToMany(Town::class);
    }

    public function oldConstituencies(): BelongsToMany
    {
        return $this->belongsToMany(OldConstituency::class)
            ->withPivot('overlap_area', 'original_area', 'percentage_overlap_area', 'percentage_overlap_pop', 'overlap_pop', 'original_pop', '__index_level_0__')
            ->withCasts([
                'percentage_overlap_area' => 'float',
            ]);
    }

    public function dentists(): HasMany
    {
        return $this->hasMany(Dentist::class);
    }

    public function hospitals(): HasMany
    {
        return $this->hasMany(Hospital::class);
    }
}
