<?php

namespace App\Services;

use App\Conference;
use App\Exceptions\ValidationException;
use Event;
use Validator;

class CreateConferenceForm
{
    private $rules = [
        'title' => ['required'],
        'description' => ['required'],
        'url' => ['required'],
        'cfp_url' => [],
        'starts_at' => ['date'],
        'ends_at' => ['date', 'onOrAfter:starts_at'],
        'cfp_starts_at' => ['date', 'before:starts_at'],
        'cfp_ends_at' => ['date', 'after:cfp_starts_at', 'before:starts_at'],
    ];

    private $input;
    private $user;

    private function __construct($input, $user)
    {
        $this->input = $this->removeEmptyFields($input);
        $this->user = $user;
    }

    private function removeEmptyFields($input)
    {
        return array_filter($input);
    }

    public static function fillOut($input, $user)
    {
        return new self($input, $user);
    }

    public function complete()
    {
        $validation = Validator::make($this->input, $this->rules);

        if ($validation->fails()) {
            throw new ValidationException('Invalid input provided, see errors', $validation->errors());
        }

        $conference = Conference::create(array_merge($this->input, [
            'author_id' => $this->user->id,
        ]));
        Event::fire('new-conference', [$conference]);
        return $conference;
    }
}
