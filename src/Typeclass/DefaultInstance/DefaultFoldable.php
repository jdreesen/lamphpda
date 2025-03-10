<?php

declare(strict_types=1);

namespace Marcosh\LamPHPda\Typeclass\DefaultInstance;

use Marcosh\LamPHPda\Brand\Brand;
use Marcosh\LamPHPda\HK\HK1;

/**
 * @template T of Brand
 * @template-covariant A
 *
 * @extends HK1<T, A>
 *
 * @psalm-immutable
 */
interface DefaultFoldable extends HK1
{
    /**
     * @template B
     * @param callable(A, B): B $f
     * @param B $b
     * @return B
     */
    public function foldr(callable $f, $b);
}
