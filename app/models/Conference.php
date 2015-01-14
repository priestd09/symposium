<?php

use Carbon\Carbon;
use Illuminate\Support\Collection;

class Conference extends UuidBase
{
    protected $table = 'conferences';

    protected $guarded = array(
        'id'
    );

    protected $dates = [
        'starts_at',
        'ends_at',
        'cfp_starts_at',
        'cfp_ends_at'
    ];

    public static $rules = [];

    public function author()
    {
        return $this->belongsTo('User', 'author_id');
    }

    /**
     * Whether or not CFP is currently open
     *
     * @return bool
     */
    public function cfpIsOpen()
    {
        if ($this->cfp_starts_at == null || $this->cfp_ends_at == null) return false;

        return Carbon::today()->between($this->getAttribute('cfp_starts_at'), $this->getAttribute('cfp_ends_at'));
    }

    /**
     * Get all users who favorited this conference
     */
    public function usersFavorited()
    {
        return $this->belongstoMany('User', 'favorites')->withTimestamps();
    }

    /**
     * Whether or not the current user favorited this conference
     *
     * @return bool
     */
    public function isFavorited()
    {
        return \Auth::user()->favoritedConferences->contains($this->id);
    }

    public function myTalks()
    {
        return new Collection;
        // @todo: Return all talks the current user submitted to this conf
    }


    public function startsAtDisplay()
    {
        return $this->startsAtSet() ? $this->starts_at->toFormattedDateString() : '[Date not set]';
    }

    public function endsAtDisplay()
    {
        return $this->endsAtSet() ? $this->ends_at->toFormattedDateString() : '[Date not set]';
    }

    public function cfpStartsAtDisplay()
    {
        return $this->cfpStartsAtSet() ? $this->cfp_starts_at->toFormattedDateString() : '[Date not set]';
    }

    public function cfpEndsAtDisplay()
    {
        return $this->cfpEndsAtSet() ? $this->cfp_ends_at->toFormattedDateString() : '[Date not set]';
    }



    public function startsAtSet()
    {
        return $this->starts_at && $this->starts_at->format('Y') != '-0001';
    }

    public function endsAtSet()
    {
        return $this->ends_at && $this->ends_at->format('Y') != '-0001';
    }

    public function cfpStartsAtSet()
    {
        return $this->cfp_starts_at && $this->cfp_starts_at->format('Y') != '-0001';
    }

    public function cfpEndsAtSet()
    {
        return $this->cfp_ends_at && $this->cfp_ends_at->format('Y') != '-0001';
    }
}
