<?php

return [
    /*
     * Transformers will take properties within your data objects and transform
     * them to types that can be JSON encoded.
     */
    'date_format' => DATE_ATOM,

    'transformers' => [
        \Spatie\LaravelData\Transformers\DateTransformer::class,
        \Spatie\LaravelData\Transformers\ArrayableTransformer::class,
    ],

    'casts' => [
        DateTime::class => Spatie\LaravelData\Casts\DateTimeCast::class,
        DateTimeImmutable::class => Spatie\LaravelData\Casts\DateTimeImmutableCast::class,
        Carbon\Carbon::class => Spatie\LaravelData\Casts\CarbonCast::class,
        Carbon\CarbonImmutable::class => Spatie\LaravelData\Casts\CarbonImmutableCast::class,
    ],

    'auto_rules' => [
        Spatie\LaravelData\AutoRules\NullableAutoRule::class,
        Spatie\LaravelData\AutoRules\RequiredAutoRule::class,
        Spatie\LaravelData\AutoRules\BuiltInTypesAutoRule::class,
        Spatie\LaravelData\AutoRules\AttributesAutoRule::class,
    ],
];
