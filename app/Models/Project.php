<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use App\Models\User;

class Project extends Model
{
    use Uuids;
    protected $fillable = [ 'name'];

    use HasFactory;
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
