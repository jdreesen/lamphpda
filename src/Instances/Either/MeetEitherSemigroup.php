<?php

declare(strict_types=1);

namespace Marcosh\LamPHPda\Instances\Either;

use Marcosh\LamPHPda\Either;
use Marcosh\LamPHPda\Typeclass\Semigroup;

/**
 * joins the errors with an E semigroup
 * if one succeeds, then it all succeeds
 * if both validations succeed, we join the results with a B semigroup.
 *
 * @template E
 * @template B
 *
 * @implements Semigroup<Either<E, B>>
 *
 * @psalm-immutable
 */
final class MeetEitherSemigroup implements Semigroup
{
    /** @var Semigroup<E> */
    private Semigroup $eSemigroup;

    /** @var Semigroup<B> */
    private Semigroup $bSemigroup;

    /**
     * @param Semigroup<E> $eSemigroup
     * @param Semigroup<B> $bSemigroup
     */
    public function __construct(Semigroup $eSemigroup, Semigroup $bSemigroup)
    {
        $this->eSemigroup = $eSemigroup;
        $this->bSemigroup = $bSemigroup;
    }

    /**
     * @param Either<E, B> $a
     * @param Either<E, B> $b
     * @return Either<E, B>
     *
     * @psalm-pure
     */
    public function append($a, $b): Either
    {
        return $a->eval(
            /**
             * @param E $ea
             * @return Either<E, B>
             */
            fn ($ea): Either => $b->eval(
                /**
                 * @param E $eb
                 * @return Either<E, B>
                 */
                fn ($eb): Either => Either::left($this->eSemigroup->append($ea, $eb)),
                /**
                 * @param B $vb
                 * @return Either<E, B>
                 */
                static fn ($vb): Either => Either::right($vb)
            ),
            /**
             * @param B $va
             * @return Either<E, B>
             */
            fn ($va): Either => $b->eval(
                /**
                 * @param E $_
                 * @return Either<E, B>
                 */
                static fn ($_): Either => Either::right($va),
                /**
                 * @param B $vb
                 * @return Either<E, B>
                 */
                fn ($vb): Either => Either::right($this->bSemigroup->append($va, $vb))
            )
        );
    }
}
