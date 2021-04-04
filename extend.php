<?php

namespace Nearata\NoSelfLikes;

use Flarum\Extend;
use Flarum\Foundation\ValidationException;

use Flarum\Likes\Event\PostWasLiked;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js'),
    new Extend\Locales(__DIR__ . '/resources/locale'),
    (new Extend\Event())
        ->listen(PostWasLiked::class, function (PostWasLiked $event) {
            $post = $event->post;
            $actor = $event->actor;
            $actorId = $actor->id;

            if ($post->user_id === $actorId) {
                $post->likes()->detach($actorId);
                throw new ValidationException(['noselflikes' => app('translator')->trans('nearata-no-self-likes.forum.error_message')]);
            }
        })
];
