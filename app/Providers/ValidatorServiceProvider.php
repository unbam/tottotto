<?php

namespace App\Providers;

use App\Validation\CustomValidator;
use Illuminate\Support\ServiceProvider;

/**
 * バリデーションプロバイダ
 * @package App\Providers
 */
class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // CustomValidatorを登録
        \Validator::resolver(function($translator, $data, $rules, $messages){
            return new CustomValidator($translator, $data, $rules, $messages);
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
