<?php

namespace Vuetricks\Presenters;

use Vuetricks\User;
use Vuetricks\Trick;
use Vuetricks\Category;
use Collective\Html\HtmlBuilder;
use Illuminate\Routing\UrlGenerator;
use McCool\LaravelAutoPresenter\BasePresenter;

class TrickPresenter extends BasePresenter
{
    /**
     * Cache for whether the user has liked this trick.
     *
     * @var bool
     */
    protected $likedByUser = null;

    /**
     * Create a new TrickPresenter instance.
     *
     * @param  \Vuetricks\Trick  $resource
     * @return void
     */
    public function __construct(Trick $resource, UrlGenerator $url, HtmlBuilder $html)
    {
        $this->wrappedObject = $resource;
        $this->url = $url;
        $this->html = $html;
    }

    /**
     * Get the edit link for this trick.
     *
     * @return string
     */
    public function editLink()
    {
        return $this->url->route('tricks.edit', [ $this->wrappedObject->slug ]);
    }

    /**
     * Get the delete link for this trick.
     *
     * @return string
     */
    public function deleteLink()
    {
        return $this->url->route('tricks.delete', [ $this->wrappedObject->slug ]);
    }

    /**
     * Get a readable created timestamp.
     *
     * @return string
     */
    public function timeago()
    {
        return $this->wrappedObject->created_at->diffForHumans();
    }

    /**
     * Returns whether the given user has liked this trick.
     *
     * @param  \Vuetricks\User $user
     * @return bool
     */
    public function likedByUser($user)
    {
        if (is_null($user)) {
            return false;
        }

        if (is_null($this->likedByUser)) {
            $this->likedByUser = $this->wrappedObject
                                      ->votes()
                                      ->where('users.id', $user->id)
                                      ->exists();
        }

        return $this->likedByUser;
    }

    /**
     * Get all the categories for this trick.
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Vuetricks\Category[]
     */
    public function allCategories()
    {
        return $this->wrappedObject->categories;
    }

    /**
     * List the categories which this trick is in.
     *
     * @return string
     */
    public function categories()
    {
        $result = '';

        if ($this->hasCategories()) {
            $categories = [];

            foreach ($this->wrappedObject->categories as $category) {
                $categories[] = $this->getCategoryLink($category);
            }

            $result = 'in ' . implode(', ', $categories);
        }

        return $result;
    }

    /**
     * Determine whether the trick has any categories.
     *
     * @return bool
     */
    protected function hasCategories()
    {
        return isset($this->wrappedObject->categories) && count($this->wrappedObject->categories) > 0;
    }

    /**
     * Get a HTML link to the given category.
     *
     * @param  \Vuetricks\Category  $category
     * @return string
     */
    protected function getCategoryLink(Category $category)
    {
        return $this->html->linkRoute('tricks.browse.category', $category->name, [ $category->slug ]);
    }

    /**
     * Get the meta description for this trick.
     *
     * @return string
     */
    public function pageDescription()
    {
        $description = $this->wrappedObject->description;
        $maxLength   = 160;
        $description = str_replace('"', '', $description);

        if (strlen($description) > $maxLength) {
            while (strlen($description) + 3 > $maxLength) {
                $description = $this->removeLastWord($description);
            }

            $description .= '...';
        }

        return e($description);
    }

    /**
     * Get the meta title for this trick.
     *
     * @return string
     */
    public function pageTitle()
    {
        $title     = $this->wrappedObject->title;
        $baseTitle = ' | Laravel-Tricks.com';
        $maxLength = 70;

        if (strlen($title.$baseTitle) > $maxLength) {
            while (strlen($title.$baseTitle) > $maxLength) {
                $title = $this->removeLastWord($title);
            }
        }

        return e($title);
    }

    /**
     * Remove the last word from a given string.
     *
     * @param  string  $string
     * @return string
     */
    protected function removeLastWord($string)
    {
        $split = explode(' ', $string);

        array_pop($split);

        return implode(' ', $split);
    }

    /**
     * Get the tag URI for this trick.
     *
     * @return string
     */
    public function tagUri()
    {
        $url = parse_url(route('tricks.show', $this->wrappedObject->slug));

        $output  = 'tag:';
        $output .= $url['host'] . ',';
        $output .= $this->wrappedObject->created_at->format('Y-m-d') . ':';
        $output .= $url['path'];

        return $output;
    }
}
