<?php

// UUID-based models
$models = [App\Talk::class, App\Conference::class, App\TalkRevision::class, App\Bio::class];

foreach ($models as $model) {
    $model::creating(function ($model) {
        $model->{$model->getKeyName()} = (string) Ramsey\Uuid\Uuid::uuid4();
    });
}

App\Talk::deleting(function ($talk) {
    $talk->revisions()->delete();
});
