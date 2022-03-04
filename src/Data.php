<?php

namespace Spatie\LaravelData;

use Illuminate\Contracts\Database\Eloquent\Castable as EloquentCastable;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Pagination\AbstractCursorPaginator;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Enumerable;
use JsonSerializable;
use Spatie\LaravelData\Concerns\AppendableData;
use Spatie\LaravelData\Concerns\IncludeableData;
use Spatie\LaravelData\Concerns\ResponsableData;
use Spatie\LaravelData\Concerns\ValidateableData;
use Spatie\LaravelData\Normalizers\ArraybleNormalizer;
use Spatie\LaravelData\Normalizers\ArrayNormalizer;
use Spatie\LaravelData\Normalizers\ModelNormalizer;
use Spatie\LaravelData\Normalizers\ObjectNormalizer;
use Spatie\LaravelData\Pipes\AuthorizedPipe;
use Spatie\LaravelData\Pipes\CastPropertiesPipe;
use Spatie\LaravelData\Pipes\DefaultValuesPipe;
use Spatie\LaravelData\Pipes\MapPropertiesPipe;
use Spatie\LaravelData\Pipes\ValidatePropertiesPipe;
use Spatie\LaravelData\Resolvers\DataFromSomethingResolver;
use Spatie\LaravelData\Resolvers\EmptyDataResolver;
use Spatie\LaravelData\Support\EloquentCasts\DataEloquentCast;
use Spatie\LaravelData\Support\TransformationType;
use Spatie\LaravelData\Transformers\DataTransformer;

/**
 * TODO: review DataProperty and DataClass and make them cachable
 * TODO: should we use closures in pipes? Should we add other pipes?
 * TODO: add MapTo support and a more general Map attribute combining both
 * TODO: remove Data traits?
 * TODO: restructure tests
 * TODO: split lazy classes
 * TODO: what about the pipeline and multiple arguments? -> use serializers for all arguments and merge them?
 * TODO: split DataCollection in DataCollection and PaginatedDataCollection
 * TODO: add more context to casts
 * TODO: test the pipeline
 * TODO: fix DataFromArrayResolver with constructor parameters
 */

abstract class Data implements Arrayable, Responsable, Jsonable, EloquentCastable, JsonSerializable
{
    use ResponsableData;
    use IncludeableData;
    use AppendableData;
    use ValidateableData;

    public static function optional($payload): ?static
    {
        return $payload === null
            ? null
            : static::from($payload);
    }

    public static function from($payload): static
    {
        return app(DataFromSomethingResolver::class)->execute(
            static::class,
            $payload
        );
    }

    public static function pipeline(): DataPipeline
    {
        return DataPipeline::create()
            ->into(static::class)
            ->normalizer(ModelNormalizer::class)
            ->normalizer(ArraybleNormalizer::class)
            ->normalizer(ObjectNormalizer::class)
            ->normalizer(ArrayNormalizer::class)
            ->through(AuthorizedPipe::class)
            ->through(ValidatePropertiesPipe::class)
            ->through(MapPropertiesPipe::class)
            ->through(DefaultValuesPipe::class)
            ->through(CastPropertiesPipe::class);
    }

    public static function collection(Enumerable|array|AbstractPaginator|AbstractCursorPaginator|Paginator|DataCollection $items): DataCollection
    {
        return new DataCollection(static::class, $items);
    }

    public static function empty(array $extra = []): array
    {
        return app(EmptyDataResolver::class)->execute(static::class, $extra);
    }

    public function transform(TransformationType $type): array
    {
        return DataTransformer::create($type)->transform($this);
    }

    public function all(): array
    {
        return $this->transform(TransformationType::withoutValueTransforming());
    }

    public function toArray(): array
    {
        return $this->transform(TransformationType::full());
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public static function castUsing(array $arguments)
    {
        return new DataEloquentCast(static::class);
    }
}
