<?php

namespace App\Http\Controllers\Api;

use App;
use App\ApiResources\Talk;
use App\OAuthGuard\Facades\OAuthGuard;
use Exception;

class TalksController extends BaseController
{
    public function show($id)
    {
        try {
            $talk = OAuthGuard::user()->talks()->findOrFail($id);
        } catch (Exception $e) {
            App::abort(404);
        }

        $talk = new Talk($talk);

        return response()->jsonApi([
            'data' => $talk->toArray()
        ]);
    }
}
