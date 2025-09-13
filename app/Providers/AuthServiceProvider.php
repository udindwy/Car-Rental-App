<?php

namespace App\Providers;

// Models
use App\Models\Booking;
use App\Models\Brand;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Extra;
use App\Models\Feature;
use App\Models\Page;
use App\Models\User;
use App\Models\Payment;
use App\Models\Availability;
use App\Models\Review;

// Policies
use App\Policies\BookingPolicy;
use App\Policies\BrandPolicy;
use App\Policies\BranchPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\CouponPolicy;
use App\Policies\ExtraPolicy;
use App\Policies\FeaturePolicy;
use App\Policies\PagePolicy;
use App\Policies\UserPolicy;
use App\Policies\PaymentPolicy;
use App\Policies\AvailabilityPolicy;
use App\Policies\ReviewPolicy;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Booking::class    => BookingPolicy::class,
        User::class       => UserPolicy::class,
        Brand::class      => BrandPolicy::class,
        Category::class   => CategoryPolicy::class,
        Branch::class     => BranchPolicy::class,
        Feature::class    => FeaturePolicy::class,
        Extra::class      => ExtraPolicy::class,
        Coupon::class     => CouponPolicy::class,
        Page::class       => PagePolicy::class,
        Payment::class => PaymentPolicy::class,
        Availability::class => AvailabilityPolicy::class,
        Review::class => ReviewPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
