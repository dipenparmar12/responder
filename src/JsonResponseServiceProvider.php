<?php

namespace Dipenparmar12\Responder;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Collection;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ServiceProvider;

class JsonResponseServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @param ResponseFactory $factory
     *
     * @return void
     */
    public function boot(ResponseFactory $factory)
    {
        $factory->macro('success', function (string $message, $data = [], $subStatus = NULL, $finalStatus = 200, array $rules = []) use ($factory) {

            $response_payload = ['success' => true,
                'status' => $subStatus ?? 200,
                'message' => is_string($message) ? $message : (string)$message,
                'requestLocation' => request()->path(),
                'rules' => [],
            ];

            if (isset($rules) and $rules) {
                $response_payload['rules'] = $rules;
            }

            if (isset($data) and $data instanceof Collection) {
                $response_payload['results'] = collect($data)->toArray();
            } else {
                $response_payload['results'] = is_array($data) ? $data : [$data];
            }

            $response_payload['metadata'] = ['auth_id' => auth()->id() ?? null, 'url' => request()->url()];
            return $factory->make($response_payload, $finalStatus);
        });

        $factory->macro('error', function ($message, $data = [], $subStatus = NULL, $finalStatus = 200, array $rules = []) use ($factory) {
            $response_payload = [
                'success' => false,
                'status' => $subStatus ?? 400,
                'requestLocation' => request()->path(),
                'message' => is_string($message) ? $message : (string)$message,
            ];

            if (isset($rules) and $rules) {
                $response_payload['rules'] = $rules;
            }

            /*if (isset($data['rules'])) {
                $response_payload['rules'] = $data['rules'];
                unset($data['rules']);
            }*/

            if (isset($data) and $data instanceof MessageBag) {
                $response_payload['results'] = [collect($data)->toArray()];
            } else {
                $response_payload['results'] = is_array($data) ? $data : [$data];
            }

            $response_payload['metadata'] = ['auth_id' => auth()->id() ?? null, 'url' => request()->url()];
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
