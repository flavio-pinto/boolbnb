<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use Searchable;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'num_rooms',
        'num_beds',
        'num_baths',
        'square_m',
        'country',
        'city',
        'address',
        'lat',
        'long',
        'place_img',
        'price',
        'visibility',
        'slug'
    ];

    /****************************************************
    * Relations
    ****************************************************/

    // User (one to many)
    public function user(){
        return $this->belongsTo('App\User');
    }

    // Amenities (many to many)
    public function amenities(){
        return $this->belongsToMany('App\Amenity');
    }

    // Sponsors (many to many)
    public function sponsors(){
        return $this->belongsToMany('App\Sponsor','sponsor_place')->withPivot('start', 'end', 'id_transaction');
    }

    // Messages (one to many)
    public function messages(){
    return $this->hasMany('App\Message');
    }

    public function visits()
    {
        return $this->hasMany('App\Visit');
    }

    public function toSearchableArray()
    {
        $record = $this->toArray();

        $record['_geoloc'] = [
            'lat' => $record['lat'],
            'lng' => $record['long'],
        ];

        unset($record['created_at'], $record['updated_at']); // Remove unrelevant data
        unset($record['lat'], $record['long']);

        return $record;
    }
}
