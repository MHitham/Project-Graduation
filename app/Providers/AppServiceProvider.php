<?php

namespace App\Providers;

use App\Repositories\Auth\AuthRepository;
use App\Repositories\Auth\IAuthRepository;
use App\Repositories\Cart\CartRepository;
use App\Repositories\Cart\ICartRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\ICategoryRepository;
use App\Repositories\Disease\DiseaseRepository;
use App\Repositories\Disease\IDiseaseRepository;
use App\Repositories\Fertilizer\FertilizerRepository;
use App\Repositories\Fertilizer\IFertilizerRepository;
use App\Repositories\GoodImages\GoodImagesRepository;
use App\Repositories\GoodImages\IGoodImageRepository;
use App\Repositories\Goods\GoodsRepository;
use App\Repositories\Goods\IGoodsRepository;
use App\Repositories\Image\IImageRepository;
use App\Repositories\Images\IImageReposiroty;
use App\Repositories\Images\ImageRepository;
use App\Repositories\Payment\IPaymentRepository;
use App\Repositories\Payment\PaymentRepository;
use App\Repositories\PaymentMethod\IPaymentMethodRepository;
use App\Repositories\PaymentMethod\PaymentMethodRepository;
use App\Repositories\Product\IProductRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\ResetPassword\IResetPasswordRepository;
use App\Repositories\ResetPassword\ResetPasswordRepository;
use App\Repositories\Roles\IUserRolesRepository;
use App\Repositories\Roles\UserRolesRepository;
use App\Repositories\Season\ISeasonRepository;
use App\Repositories\Season\SeasonRepository;
use App\Repositories\Soil\ISoilRepository;
use App\Repositories\Soil\SoilRepository;
use App\Repositories\Token\ITokenRepository;
use App\Repositories\Token\TokenRepository;
use App\Services\Auth\AuthService;
use App\Services\Auth\IAuthService;
use App\Services\Cart\CartService;
use App\Services\Cart\ICartService;
use App\Services\Category\CategoryService;
use App\Services\Category\ICategoryService;
use App\Services\Disease\DiseaseService;
use App\Services\Disease\IDiseaseService;
use App\Services\EmailService;
use App\Services\EmailService\IEmailService;
use App\Services\Fertilizer\FertilizerService;
use App\Services\Fertilizer\IFertilizerService;
use App\Services\GoodImages\GoodImagesService;
use App\Services\GoodImages\IGoodImagesService;
use App\Services\Image\IImageService;
use App\Services\Image\ImageService;
use App\Services\Order\IOrderService;
use App\Services\Order\OrderService;
use App\Services\PaymentMethods\IPaymentMethodsService;
use App\Services\PaymentMethods\PaymentMethodService;
use App\Services\Product\IProductService;
use App\Services\Product\ProductsService;
use App\Services\Season\ISeasonService;
use App\Services\Season\SeasonService;
use App\Services\Soil\ISoilService;
use App\Services\Soil\SoilService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IAuthRepository::class, AuthRepository::class);
        $this->app->bind(ITokenRepository::class, TokenRepository::class);
        $this->app->bind(IAuthService::class, AuthService::class);
        $this->app->bind(IEmailService::class, EmailService::class);
        $this->app->bind(IResetPasswordRepository::class, ResetPasswordRepository::class);
        $this->app->bind(IUserRolesRepository::class, UserRolesRepository::class);
        $this->app->bind(ICategoryRepository::class, CategoryRepository::class);
        $this->app->bind(IProductRepository::class, ProductRepository::class);
        $this->app->bind(ICartRepository::class, CartRepository::class);
        $this->app->bind(ISeasonRepository::class, SeasonRepository::class);
        $this->app->bind(IFertilizerRepository::class, FertilizerRepository::class);
        $this->app->bind(IDiseaseRepository::class, DiseaseRepository::class);
        $this->app->bind(ISoilRepository::class, SoilRepository::class);
        $this->app->bind(IGoodsRepository::class, GoodsRepository::class);
        $this->app->bind(IGoodImageRepository::class, GoodImagesRepository::class);
        $this->app->bind(IPaymentMethodRepository::class, PaymentMethodRepository::class);
        $this->app->bind(IPaymentRepository::class, PaymentRepository::class);
        $this->app->bind(IFertilizerService::class, FertilizerService::class);
        $this->app->bind(IDiseaseService::class, DiseaseService::class);
        $this->app->bind(ISoilService::class, SoilService::class);
        $this->app->bind(ISeasonService::class, SeasonService::class);
        $this->app->bind(ICategoryService::class, CategoryService::class);
        $this->app->bind(IImageService::class, ImageService::class);
        $this->app->bind(IImageReposiroty::class, ImageRepository::class);
        $this->app->bind(IPaymentMethodsService::class, PaymentMethodService::class);
        $this->app->bind(ICartService::class, CartService::class);
        $this->app->bind(IGoodImagesService::class, GoodImagesService::class);
        $this->app->bind(IProductService::class, ProductsService::class);
        $this->app->bind(IOrderService::class, OrderService::class);
    }
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(255);
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verify Email Address')
                ->line('Click the button below to verify your email address.')
                ->action('Verify Email Address', $url);
        });
    }
}
