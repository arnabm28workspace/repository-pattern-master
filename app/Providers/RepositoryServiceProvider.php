<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\CategoryContract;
use App\Repositories\CategoryRepository;
use App\Contracts\PageContract;
use App\Repositories\PageRepository;
use App\Contracts\PageTypeContract;
use App\Repositories\PageTypeRepository;
use App\Contracts\CountryContract;
use App\Repositories\CountryRepository;
use App\Contracts\PackageContract;
use App\Repositories\PackageRepository;
use App\Contracts\CustomFieldContract;
use App\Repositories\CustomFieldRepository;
use App\Contracts\ProfileContract;
use App\Repositories\ProfileRepository;
use App\Contracts\AdsContract;
use App\Repositories\AdsRepository;
use App\Contracts\AttributeContract;
use App\Repositories\AttributeRepository;
use App\Contracts\PaymentContract;
use App\Repositories\PaymentRepository;
use App\Contracts\AdsImageContract;
use App\Repositories\AdsImageRepository;
use App\Contracts\BlogContract;
use App\Repositories\BlogRepository;
use App\Contracts\AdsMessagesContract;
use App\Repositories\AdsMessagesRepository;
use App\Contracts\AdMessageReplyContract;
use App\Repositories\AdMessageReplyRepository;
use App\Contracts\AdsReportsContract;
use App\Repositories\AdsReportsRepository;
use App\Contracts\CityContract;
use App\Repositories\CityRepository;
use App\Contracts\AdminContract;
use App\Repositories\AdminRepository;
use App\Contracts\UserContract;
use App\Repositories\UserRepository;
use App\Contracts\CategoryFormContract;
use App\Repositories\CategoryFormRepository;
use App\Contracts\AdSearchContract;
use App\Repositories\AdSearchRepository;
use App\Contracts\AdDetailsContract;
use App\Repositories\AdDetailsRepository;
use App\Contracts\AdPackagesContract;
use App\Repositories\AdPackagesRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    protected $repositories = [
        AdminContract::class        =>  AdminRepository::class,
        CategoryContract::class     =>  CategoryRepository::class,
        PageContract::class         =>  PageRepository::class,
        PageTypeContract::class     =>  PageTypeRepository::class,
        CountryContract::class      =>  CountryRepository::class,
        PackageContract::class      =>  PackageRepository::class,
        CustomFieldContract::class  =>  CustomFieldRepository::class,
        ProfileContract::class  =>  ProfileRepository::class,
        AdsContract::class  =>  AdsRepository::class,
        AttributeContract::class  =>  AttributeRepository::class,
        PaymentContract::class  =>  PaymentRepository::class,
        AdsImageContract::class  =>  AdsImageRepository::class,
        BlogContract::class  =>  BlogRepository::class,
        AdsMessagesContract::class  =>  AdsMessagesRepository::class,
        AdMessageReplyContract::class  =>  AdMessageReplyRepository::class,
        AdsReportsContract::class  =>  AdsReportsRepository::class,
        CityContract::class  =>  CityRepository::class,
        UserContract::class  =>  UserRepository::class,
        CategoryFormContract::class  =>  CategoryFormRepository::class,
        AdSearchContract::class  =>  AdSearchRepository::class,
        AdDetailsContract::class  =>  AdDetailsRepository::class,
        AdPackagesContract::class  =>  AdPackagesRepository::class,
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->repositories as $interface => $implementation)
        {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
