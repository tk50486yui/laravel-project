<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Models\Words;
use App\Models\WordsTags;
use App\Models\Categories;
use App\Models\Tags;
use App\Models\Articles;
use App\Models\ArticlesTags;
use App\Models\WordsGroups;
use App\Models\WordsGroupsDetails;
use App\Observers\WordsObserver;
use App\Observers\WordsTagsObserver;
use App\Observers\CategoriesObserver;
use App\Observers\TagsObserver;
use App\Observers\ArticlesObserver;
use App\Observers\ArticlesTagsObserver;
use App\Observers\WordsGroupsObserver;
use App\Observers\WordsGroupsDetailsObserver;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();  
        Words::observe(WordsObserver::class);
        WordsTags::observe(WordsTagsObserver::class);
        Categories::observe(CategoriesObserver::class);
        Tags::observe(TagsObserver::class);
        Articles::observe(ArticlesObserver::class);
        ArticlesTags::observe(ArticlesTagsObserver::class);
        WordsGroups::observe(WordsGroupsObserver::class);
        WordsGroupsDetails::observe(WordsGroupsDetailsObserver::class);
    }
}
