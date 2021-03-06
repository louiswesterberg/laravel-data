<?php

namespace Spatie\LaravelData\Tests\Fakes;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;

class CollectionAnnotationsData
{
    /** @var \Spatie\LaravelData\Tests\Fakes\SimpleData[]|\Spatie\LaravelData\DataCollection */
    public DataCollection $propertyA;

    /** @var \Spatie\LaravelData\Tests\Fakes\SimpleData[]|DataCollection */
    public DataCollection $propertyB;

    /** @var \Spatie\LaravelData\DataCollection|\Spatie\LaravelData\Tests\Fakes\SimpleData[] */
    public DataCollection $propertyC;

    /** @var DataCollection|\Spatie\LaravelData\Tests\Fakes\SimpleData[] */
    public DataCollection $propertyD;

    /** @var \Spatie\LaravelData\Tests\Fakes\SimpleData[] */
    public DataCollection $propertyE;

    /** @var \Spatie\LaravelData\Tests\Fakes\SimpleData[]|null */
    public DataCollection $propertyF;

    /** @var null|\Spatie\LaravelData\Tests\Fakes\SimpleData[] */
    public DataCollection $propertyG;

    /** @var ?Spatie\LaravelData\Tests\Fakes\SimpleData[] */
    public DataCollection $propertyH;

    /** @var \Spatie\LaravelData\DataCollection<\Spatie\LaravelData\Tests\Fakes\SimpleData> */
    public DataCollection $propertyI;

    /** @var ?Spatie\LaravelData\DataCollection<\Spatie\LaravelData\Tests\Fakes\SimpleData> */
    public DataCollection $propertyJ;

    /** @var SimpleData[] */
    public DataCollection $propertyK;

    #[DataCollectionOf(SimpleData::class)]
    public DataCollection $propertyL;

    /** @var SimpleData */
    public DataCollection $propertyM;

    /** @var \Spatie\LaravelData\Lazy[] */
    public DataCollection $propertyN;

    public DataCollection $propertyO;
}
