<?php

namespace App\Providers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\ServiceProvider;

/// To registor 
/// /config/app.php
/// App\Providers\JsonResponseServiceProvider::class,
//  'providers' => [
//        // ...
//        App\Providers\JsonResponseServiceProvider::class,
//    ],
//    How to use it.
//    return response()->success("res msg",[1,2,],null,401);
//    return response()->error("error name");

class JsonResponseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(ResponseFactory $factory)
    {
        $factory->macro('success', function ($message, $data = [], $subStatus = NULL, $finalStatus = 200) use ($factory) {
            return $factory->make([
                'success' => true,
                'message' => $message,
                'status' => $subStatus ?? 200,
                'path' => '/' . request()->path(),
                'results' => $data,
                'metadata' => [
                    'auth_id' => auth()->id() ?? null,
                    'url' => request()->url()
                ],
            ], $finalStatus);
        });

        $factory->macro('error', function ($message, $data = [], $subStatus = NULL, $finalStatus = 500) use ($factory) {
            $response_payload = [
                'success' => false,
                'message' => $message,
                'status' => $subStatus ?? 400,
                'path' => '/' . request()->path(),
                'results' => $data,
                'metadata' => [
                    'auth_id' => auth()->id() ?? null,
                    'url' => request()->url()
                ],
            ];
            return $factory->make($response_payload, $finalStatus);
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }
}
