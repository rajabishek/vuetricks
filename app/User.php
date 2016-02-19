<?php

namespace Vuetricks;

use Gravatar;
use Vuetricks\Presenters\UserPresenter;
use McCool\LaravelAutoPresenter\HasPresenter;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasPresenter
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
    * Users should not be admin by default
    *
    * @var array
    */
    protected $attributes = [
        'is_admin' => false
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the class used to present the model.
     *
     * @return string
     */
    public function getPresenterClass()
    {
        return UserPresenter::class;
    }

    /**
     * Query the tricks that the user has posted.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tricks()
    {
        return $this->hasMany('Vuetricks\Trick');
    }

    /**
     * Query the votes that are casted by the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function votes()
    {
        return $this->belongsToMany('Vuetricks\Trick', 'votes');
    }

    /**
     * Get the user's avatar image.
     *
     * @return string
     */
    public function getPhotocssAttribute()
    {
        if($this->photo) {
            return url('img/avatar/' . $this->photo);
        }

        return Gravatar::src($this->email, 100);
    }

    /**
     * Check user's permissions
     *
     * @return bool
     */
    public function isAdmin()
    {
        return ($this->is_admin == true);
    }
}
