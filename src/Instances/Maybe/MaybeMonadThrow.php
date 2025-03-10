<?php

declare(strict_types=1);

namespace Marcosh\LamPHPda\Instances\Maybe;

use Marcosh\LamPHPda\Brand\MaybeBrand;
use Marcosh\LamPHPda\HK\HK1;
use Marcosh\LamPHPda\Maybe;
use Marcosh\LamPHPda\Typeclass\MonadThrow;

/**
 * @template E
 *
 * @implements MonadThrow<MaybeBrand, E>
 *
 * @psalm-immutable
 */
final class MaybeMonadThrow implements MonadThrow
{
    /**
     * @template A
     * @template B
     * @param callable(A): B $f
     * @param HK1<MaybeBrand, A> $a
     * @return Maybe<B>
     *
     * @psalm-pure
     *
     * @psalm-suppress LessSpecificImplementedReturnType
     */
    public function map(callable $f, HK1 $a): Maybe
    {
        return (new MaybeFunctor())->map($f, $a);
    }

    /**
     * @template A
     * @template B
     * @param HK1<MaybeBrand, callable(A): B> $f
     * @param HK1<MaybeBrand, A> $a
     * @return Maybe<B>
     *
     * @psalm-pure
     *
     * @psalm-suppress LessSpecificImplementedReturnType
     */
    public function apply(HK1 $f, HK1 $a): Maybe
    {
        return (new MaybeApply())->apply($f, $a);
    }

    /**
     * @template A
     * @param A $a
     * @return Maybe<A>
     *
     * @psalm-pure
     *
     * @psalm-suppress LessSpecificImplementedReturnType
     */
    public function pure($a): Maybe
    {
        return (new MaybeApplicative())->pure($a);
    }

    /**
     * @template A
     * @template B
     * @param HK1<MaybeBrand, A> $a
     * @param callable(A): HK1<MaybeBrand, B> $f
     * @return Maybe<B>
     *
     * @psalm-pure
     *
     * @psalm-suppress LessSpecificImplementedReturnType
     */
    public function bind(HK1 $a, callable $f): Maybe
    {
        return (new MaybeMonad())->bind($a, $f);
    }

    /**
     * @template A
     * @param E $e
     * @return Maybe<A>
     *
     * @psalm-pure
     *
     * @psalm-suppress LessSpecificImplementedReturnType
     */
    public function throwError($e): Maybe
    {
        return Maybe::nothing();
    }
}
