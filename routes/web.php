<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'prefix'     => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect']
    ],
    function () {


        Route::get('/blog', 'PagesController@home');

        Route::get('blog/{article_slug}/{translation_slug?}', 'PagesController@article');

        Route::get('categories/{slug}', 'PagesController@category');

        Route::get('tags/{tag}/{slug?}', 'PagesController@tag');

        Route::get('/', 'HomePageController@show');

        Route::get('campaigns', 'CampaignsController@index');
        Route::get('initiatives', 'CampaignsController@index');
        Route::get('campaigns/{campaign:slug}/{name?}', 'CampaignsController@show');
        Route::get('initiatives/{campaign:slug}/{name?}', 'CampaignsController@show');

        Route::get('events', 'EventsController@index');
        Route::get('events/{event:slug}/{name?}', 'EventsController@show');

        Route::get('races/{activity:slug}/{name?}', 'ActivitiesController@show');
        Route::get('activities/{activity:slug}/{name?}', 'ActivitiesController@show');

        Route::get('galleries/{gallery:slug}', 'GalleriesController@show');

        Route::get('discover/{page:slug}', 'DiscoverPagesController@show');

        Route::get('friends', 'PeopleController@index');
        Route::get('ambassadors/{ambassador:slug}/{name?}', 'AmbassadorsController@show');
        Route::get('coaches/{coach:slug}/{name?}', 'CoachesController@show');

});

Route::post('newsletter/subscribe', 'NewsletterSignupController@store');

Route::group(['prefix' => 'previews', 'middleware' => ['auth'], 'namespace' => 'Admin'], function() {

    Route::get('events/{event}', 'EventPreviewController@show');
    Route::get('campaigns/{campaign}', 'CampaignPreviewController@show');

    Route::get('discover/pages/{page}', 'PreviewPagesController@show');

    Route::get('coach/{coach}', 'CoachPreviewController@show');
    Route::get('ambassador/{ambassador}', 'AmbassadorPreviewController@show');
});



Route::get('translations/{translation}/comments', 'CommentsController@index');
Route::post('translations/{translation}/comments', 'CommentsController@store');
Route::post('comments/{comment}/replies', 'RepliesController@store');
Route::post('flagged-comments', 'FlaggedCommentsController@store');
Route::post('flagged-replies', 'FlaggedRepliesController@store');

Route::group(['prefix' => 'admin', 'namespace' => 'Auth'], function () {
    Route::view('login', 'auth.login')->name('login');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout');

    Route::view('password/request', 'auth.password-request')->name('password.request');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::post('password/reset', 'ResetPasswordController@reset')
         ->name('password.update');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth'], 'namespace' => 'Admin'], function () {
    Route::get('me', 'ProfileController@show');
    Route::post('me', 'ProfileController@update');
    Route::post('me/password', 'UserPasswordController@update');

    Route::get('users', 'UsersController@index');
    Route::post('users', 'UsersController@store');
    Route::delete('users/{user}', 'UsersController@destroy');

    Route::get('categories', 'CategoriesController@index');
    Route::post('categories', 'CategoriesController@store');
    Route::post('categories/{category}', 'CategoriesController@update');
    Route::delete('categories/{category}', 'CategoriesController@destroy');

    Route::get('articles', 'ArticlesController@index');
    Route::post('articles', 'ArticlesController@store');
    Route::delete('articles/{article}', 'ArticlesController@destroy');
    Route::post('articles/{article}/categories', 'ArticleCategoriesController@update');
    Route::post('articles/{article}/translations', 'TranslationsController@store');
    Route::post('articles/{article}/title-image', 'ArticleTitleImageController@store');

    Route::get('search/articles', 'ArticleSearchController@index');

    Route::get('translations/{translation}', 'TranslationsController@show');
    Route::post('translations/{translation}', 'TranslationsController@update');
    Route::post('translations/{translation}/images', 'TranslationBodyImagesController@store');

    Route::post('published-translations', 'PublishedTranslationsController@store');
    Route::delete('published-translations/{translation}', 'PublishedTranslationsController@destroy');

    Route::get('site-settings/slide-count', 'SlideCountSettingController@show');
    Route::post('site-settings/slide-count', 'SlideCountSettingController@update');

    Route::get('slider/slides', 'SlidesController@index');
    Route::post('slider/slides', 'SlidesController@store');
    Route::delete('slider/{position}', 'SlidesController@destroy');

    Route::get('comments', 'CommentsController@index');
    Route::delete('comments/{comment}', 'CommentsController@destroy');

    Route::get('replies', 'RepliesController@index');
    Route::delete('replies/{reply}', 'RepliesController@destroy');

    Route::get('flagged-comments', 'FlaggedCommentsController@index');
    Route::delete('rejected-flags/{flagged}', 'RejectedFlagsController@destroy');
    Route::delete('enforced-flags/{flagged}', 'EnforcedFlagsController@destroy');

    Route::get('tags', 'TagsController@index');
    Route::delete('tags', 'TagsController@destroy');

    Route::get('tags/{tag}/translations', 'TagTranslationsController@index');

    Route::get('events', 'EventsController@index');
    Route::post('events', 'EventsController@store');
    Route::delete('events/{event}', 'EventsController@delete');
    Route::post('events/{event}/general-info', 'EventGeneralInfoController@update');
    Route::post('events/{event}/overview', 'EventOverviewController@update');

    Route::post('events/{event}/promo-video', 'EventPromoVideoController@store');
    Route::delete('events/{event}/promo-video', 'EventPromoVideoController@destroy');

    Route::get('events/activity-categories', 'EventActivityCategoriesController@index');

    Route::post('events/{event}/races', 'EventRacesController@store');
    Route::post('races/{race}', 'EventRacesController@update');
    Route::delete('races/{race}', 'EventRacesController@delete');

    Route::post('races/{race}/schedule', 'RaceScheduleController@update');
    Route::delete('races/{race}/schedule', 'RaceScheduleController@destroy');

    Route::post('events/{event}/activities', 'EventActivitiesController@store');
    Route::post('activities/{activity}', 'EventActivitiesController@update');
    Route::delete('activities/{activity}', 'EventActivitiesController@delete');

    Route::post('events/{event}/schedule', 'EventScheduleController@update');
    Route::delete('events/{event}/schedule', 'EventScheduleController@destroy');

    Route::post('events/{event}/fees', 'EventFeesController@update');
    Route::delete('events/{event}/fees', 'EventFeesController@destroy');

    Route::post('races/{race}/prizes', 'RacePrizesController@update');
    Route::delete('races/{race}/prizes', 'RacePrizesController@destroy');

    Route::post('races/{race}/fees', 'RaceFeesController@update');
    Route::delete('races/{race}/fees', 'RaceFeesController@destroy');

    Route::post('events/{event}/travel-routes', 'EventTravelRoutesController@store');
    Route::post('travel-routes/{route}', 'EventTravelRoutesController@update');
    Route::delete('travel-routes/{route}', 'EventTravelRoutesController@delete');

    Route::post('travel-routes/{route}/image', 'TravelRouteImageController@store');

    Route::post('events/{event}/travel-guide', 'EventTravelGuideController@store');
    Route::delete('events/{event}/travel-guide', 'EventTravelGuideController@destroy');

    Route::post('events/{event}/accommodation', 'EventAccommodationsController@store');
    Route::post('accommodations/{accommodation}', 'EventAccommodationsController@update');
    Route::delete('accommodations/{accommodation}', 'EventAccommodationsController@delete');

    Route::post('events/{event}/sponsors', 'EventSponsorsController@store');
    Route::post('event-sponsors/{sponsor}', 'EventSponsorsController@update');
    Route::delete('event-sponsors/{sponsor}', 'EventSponsorsController@delete');

    Route::post('event-sponsors-order', 'EventSponsorsOrderController@store');

    Route::post('event-sponsors/{sponsor}/image', 'SponsorLogosController@store');
    Route::delete('event-sponsors/{sponsor}/image', 'SponsorLogosController@destroy');

    Route::post('races/{race}/courses', 'RaceCoursesController@store');
    Route::post('courses/{course}', 'RaceCoursesController@update');
    Route::delete('courses/{course}', 'RaceCoursesController@delete');

    Route::post('courses/{course}/gpx-file', 'CourseGPXFileController@store');
    Route::delete('courses/{course}/gpx-file', 'CourseGPXFileController@destroy');

    Route::post('courses/{course}/images', 'CourseImagesController@store');
    Route::delete('courses/{course}/images/{media}', 'CourseImagesController@destroy');
    Route::post('courses/{course}/images-order', 'CourseImagesOrderController@update');

    Route::post('races/{race}/schedule-notes', 'RaceScheduleNotesController@update');
    Route::post('races/{race}/prize-notes', 'RacePrizeNotesController@update');
    Route::post('races/{race}/fees-notes', 'RaceFeesNotesController@update');

    Route::post('races/{race}/race-rules-doc', 'RaceRulesDocumentController@store');
    Route::delete('races/{race}/race-rules-doc', 'RaceRulesDocumentController@destroy');
    Route::delete('races/{race}/chinese-race-rules-doc', 'ChineseRaceRulesDocumentController@destroy');
    Route::post('races/{race}/chinese-race-rules-doc', 'ChineseRaceRulesDocumentController@store');
    Route::post('races/{race}/athletes-guide', 'RaceAthleteGuideController@store');
    Route::post('races/{race}/chinese-athletes-guide', 'RaceChineseAthleteGuideController@store');
    Route::delete('races/{race}/athletes-guide', 'RaceAthleteGuideController@destroy');
    Route::delete('races/{race}/chinese-athletes-guide', 'RaceChineseAthleteGuideController@destroy');

    Route::post('races/{race}/description', 'RaceDescriptionController@update');
    Route::post('races/{race}/race-rules', 'RaceRulesController@update');
    Route::post('races/{race}/race-info', 'RaceInfoController@update');

    Route::post('published-events', 'PublishedEventsController@store');
    Route::delete('published-events/{event}', 'PublishedEventsController@destroy');

    Route::post('events/{event}/youtube-videos', 'EventYoutubeVideosController@store');

    Route::post('embeddable-videos/{video}', 'EmbeddableVideosController@update');
    Route::delete('embeddable-videos/{video}', 'EmbeddableVideosController@delete');

    Route::post('events/{event}/galleries', 'EventGalleriesController@store');
    Route::delete('events/{event}/galleries/{gallery}', 'EventGalleriesController@destroy');

    Route::post('events/{event}/banner-image', 'EventBannerImageController@store');
    Route::delete('events/{event}/banner-image', 'EventBannerImageController@destroy');
    Route::post('events/{event}/mobile-banner', 'EventMobileBannerController@store');
    Route::delete('events/{event}/mobile-banner', 'EventMobileBannerController@destroy');

    Route::post('events/{event}/card-image', 'EventCardImageController@store');
    Route::delete('events/{event}/card-image', 'EventCardImageController@destroy');

    Route::post('races/{race}/content-images', 'ActivityContentImagesController@store');
    Route::post('races/{race}/banner-image', 'RaceBannerImageController@store');
    Route::post('races/{race}/card-image', 'RaceCardImageController@store');

    Route::post('races/{race}/mobile-banner', 'RaceMobileBannerController@store');
    Route::delete('races/{race}/mobile-banner', 'RaceMobileBannerController@destroy');

    Route::post('races/{race}/promo-video', 'RacePromoVideoController@store');

    Route::get('galleries', 'GalleriesController@index');
    Route::post('galleries', 'GalleriesController@store');
    Route::post('galleries/{gallery}', 'GalleriesController@update');
    Route::delete('galleries/{gallery}', 'GalleriesController@delete');
    Route::post('galleries/{gallery}/images', 'GalleryImagesController@store');
    Route::delete('galleries/{gallery}/images/{image}', 'GalleryImagesController@delete');
    Route::post('galleries/{gallery}/image-order', 'GalleryImagesOrderController@update');

    Route::get('coaches', 'CoachesController@index');
    Route::post('coaches', 'CoachesController@store');
    Route::post('coaches/{coach}', 'CoachesController@update');
    Route::delete('coaches/{coach}', 'CoachesController@delete');

    Route::post('published-coaches', 'PublishedCoachesController@store');
    Route::delete('published-coaches/{coach}', 'PublishedCoachesController@destroy');

    Route::post('coaches/{coach}/youtube-videos', 'CoachYoutubeVideosController@store');

    Route::post('coaches/{coach}/profile-pic', 'CoachProfilePicController@store');
    Route::delete('coaches/{coach}/profile-pic', 'CoachProfilePicController@destroy');

    Route::get('ambassadors', 'AmbassadorsController@index');
    Route::post('ambassadors', 'AmbassadorsController@store');
    Route::post('ambassadors/{ambassador}', 'AmbassadorsController@update');
    Route::delete('ambassadors/{ambassador}', 'AmbassadorsController@delete');

    Route::post('published-ambassadors', 'PublishedAmbassadorsController@store');
    Route::delete('published-ambassadors/{ambassador}', 'PublishedAmbassadorsController@destroy');

    Route::post('ambassadors/{ambassador}/youtube-videos', 'AmbassadorYoutubeVideosController@store');

    Route::post('ambassadors/{ambassador}/profile-pic', 'AmbassadorProfilePicController@store');
    Route::delete('ambassadors/{ambassador}/profile-pic', 'AmbassadorProfilePicController@destroy');

    Route::post('events/{event}/ambassadors', 'EventAmbassadorsController@store');
    Route::delete('events/{event}/ambassadors/{ambassador}', 'EventAmbassadorsController@destroy');
    Route::post('events/{event}/coaches', 'EventCoachesController@store');
    Route::delete('events/{event}/coaches/{coach}', 'EventCoachesController@destroy');

    Route::post('campaigns/{campaign}/ambassadors', 'CampaignAmbassadorsController@store');
    Route::delete('campaigns/{campaign}/ambassadors/{ambassador}', 'CampaignAmbassadorsController@destroy');
    Route::post('campaigns/{campaign}/coaches', 'CampaignCoachesController@store');
    Route::delete('campaigns/{campaign}/coaches/{coach}', 'CampaignCoachesController@destroy');

    Route::get('promotions', 'PromotionsController@index');
    Route::post('promotions', 'PromotionsController@store');
    Route::post('promotions/{promotion}', 'PromotionsController@update');
    Route::delete('promotions/{promotion}', 'PromotionsController@delete');

    Route::post('public-promotions', 'PublicPromotionsController@store');
    Route::delete('public-promotions/{promotion}', 'PublicPromotionsController@destroy');

    Route::post('featured-promotions', 'FeaturedPromotionsController@store');

    Route::post('promotions/{promotion}/image', 'PromotionImageController@store');
    Route::delete('promotions/{promotion}/image', 'PromotionImageController@destroy');

    Route::get('pages', 'PagesController@index');
    Route::post('pages', 'PagesController@store');
    Route::post('pages/{page}', 'PagesController@update');
    Route::delete('pages/{page}', 'PagesController@delete');

    Route::post('pages/{page}/content', 'PageContentController@update');

    Route::post('pages/{page}/images', 'PageImagesController@store');

    Route::post('published-pages', 'PublishedPagesController@store');
    Route::delete('published-pages/{page}', 'PublishedPagesController@destroy');

    Route::get('campaigns', 'CampaignsController@index');
    Route::post('campaigns', 'CampaignsController@store');
    Route::post('campaigns/{campaign}', 'CampaignsController@update');
    Route::delete('campaigns/{campaign}', 'CampaignsController@delete');

    Route::post('published-campaigns', 'PublishedCampaignsController@store');
    Route::delete('published-campaigns/{campaign}', 'PublishedCampaignsController@destroy');

    Route::post('campaigns/{campaign}/narrative', 'CampaignNarrativeController@update');

    Route::post('campaigns/{campaign}/promo-video', 'CampaignPromoVideoController@store');
    Route::delete('campaigns/{campaign}/promo-video', 'CampaignPromoVideoController@destroy');
    Route::post('campaigns/{campaign}/banner-video', 'CampaignBannerVideoController@store');
    Route::delete('campaigns/{campaign}/banner-video', 'CampaignBannerVideoController@destroy');

    Route::post('campaigns/{campaign}/banner-image', 'CampaignBannerImageController@store');
    Route::delete('campaigns/{campaign}/banner-image', 'CampaignBannerImageController@destroy');
    Route::post('campaigns/{campaign}/title-image', 'CampaignTitleImageController@store');
    Route::delete('campaigns/{campaign}/title-image', 'CampaignTitleImageController@destroy');

    Route::post('campaigns/{campaign}/narrative-images', 'CampaignNarrativeImagesController@store');

    Route::post('campaigns/{campaign}/event', 'CampaignEventController@update');
    Route::post('campaigns/{campaign}/promotion', 'CampaignPromotionController@update');

    Route::post('campaigns/{campaign}/articles', 'CampaignArticlesController@store');
    Route::delete('campaigns/{campaign}/articles/{article}', 'CampaignArticlesController@destroy');

    Route::get('content-cards', 'ContentCardController@index');
    Route::post('content-cards', 'ContentCardController@store');
    Route::post('content-cards/{card}', 'ContentCardController@update');
    Route::delete('content-cards/{card}', 'ContentCardController@delete');

    Route::post('content-cards-order', 'ContentCardsOrderController@store');

    Route::post('content-cards/{card}/image', 'ContentCardImageController@store');
    Route::delete('content-cards/{card}/image', 'ContentCardImageController@destroy');

    Route::post('article-content-cards', 'ArticleContentCardsController@store');
    Route::post('event-content-cards', 'EventContentCardsController@store');
    Route::post('promotion-content-cards', 'PromotionContentCardsController@store');

    Route::get('home-page', 'HomePageController@show');

    Route::post('home-page/banner-text', 'HomePageBannerTextController@update');

    Route::post('home-page/banner-image', 'HomePageBannerImageController@store');
    Route::delete('home-page/banner-image', 'HomePageBannerImageController@destroy');

    Route::post('home-page/featured-promotion', 'HomePageFeaturedPromotionController@store');
    Route::post('home-page/featured-event', 'HomePageFeaturedEventController@store');
    Route::post('home-page/featured-campaign', 'HomePageFeaturedCampaignController@store');

    Route::post('home-page/banner-video', 'HomePageBannerVideoController@store');
    Route::delete('home-page/banner-video', 'HomePageBannerVideoController@destroy');
    Route::post('home-page/promo-video', 'HomePagePromoVideoController@store');
    Route::delete('home-page/promo-video', 'HomePagePromoVideoController@destroy');

    Route::get('instagram', 'InstagramController@show');

});

Route::group([
    'prefix'     => 'admin/pages',
    'middleware' => ['auth'],
    'namespace'  => 'Admin\Pages'
], function () {
    Route::view("dashboard", "admin.spa-base");

    Route::get('previews/{translation}', 'TranslationPreviewController@show');
});

