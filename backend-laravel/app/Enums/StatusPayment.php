<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class StatusPayment extends Enum implements LocalizedEnum
{
    const UNPAID = 0;
    const PAID = 1;
    const PAYMENT_FAILED = 2;
}
