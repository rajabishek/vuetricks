<?php

namespace Vuetricks;

use Vuetricks\Presenters\TrickPresenter;
use McCool\LaravelAutoPresenter\HasPresenter;
use Illuminate\Database\Eloquent\Model;

class Trick extends Model implements HasPresenter
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tricks';

	/**
	 * The relations to eager load on every query.
	 *
	 * @var array
	 */
	protected $with = ['tags', 'categories', 'user'];

	/**
     * Get the class used to present the model.
     *
     * @return string
     */
    public function getPresenterClass()
    {
        return TrickPresenter::class;
    }

	/**
	 * Query the tricks' votes.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function votes()
	{
		return $this->belongsToMany('Vuetricks\User', 'votes');
	}

	/**
	 * Query the user that posted the trick.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
    {
        return $this->belongsTo('Vuetricks\User');
    }

    /**
     * Query the tags under which the trick was posted.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
	public function tags()
	{
		return $this->belongsToMany('Vuetricks\Tag');
	}

	/**
	 * Query the categories under which the trick was posted.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function categories()
	{
		return $this->belongsToMany('Vuetricks\Category');
	}
}