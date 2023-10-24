<?php

namespace Tests;

use Illuminate\Testing\TestResponse;

trait TestTraits
{
    public function responseDd(TestResponse $response): void {
        $get_only_response = collect($response->json());
        $trace = $get_only_response['trace'][0];

        $new_response = collect([
            ...$get_only_response->forget('trace'),
            'trace' => $trace
        ]);

        $new_response->dd();
    }

    public function responseDump(TestResponse $response): void {
        $get_only_response = collect($response->json());
        $trace = $get_only_response['trace'][0];

        $new_response = collect([
            ...$get_only_response->forget('trace'),
            'trace' => $trace
        ]);

        $new_response->dump();
    }
}
