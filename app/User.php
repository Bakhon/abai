<?php

namespace App;

use App\Models\Refs\Org;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *`
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'password', 'org_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_authorized_at' => 'datetime',
    ];


    //relations

    public function profile()
    {
        return $this->hasOne(Profile::class)->withDefault();
    }

    public function org()
    {
        return $this->belongsTo(\App\Models\Refs\Org::class);
    }

    public function pageViewLogs()
    {
        return $this->hasMany(\App\Models\LogPageView::class)->orderBy('created_at', 'desc');
    }

    public function bigdataFavoriteReports()
    {
        return $this->belongsToMany(\App\Models\BigdataReport::class);
    }

    public function getOrganizations()
    {
        if($this->org_id) {
            return Org::query()
                ->where('id', $this->org_id)
                ->orWhere('parent_id', $this->org_id)
                ->get();
        }
        else {
            return new \Illuminate\Database\Eloquent\Collection();
        }
    }

    public function getOrganizationIds()
    {
        return $this->getOrganizations()->pluck('id')->toArray();
    }
}
