<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Attributes\Description;

// #[Description('List of available User types')]
final class StatusOrder extends Enum implements LocalizedEnum
{
    const INIT = 0;
    const APPROVED = 1;
    const SHIPPING = 2;
    const COMPLETED = 3;
    const CANCELLED = 4;
}
