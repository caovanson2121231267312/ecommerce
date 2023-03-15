<?php

namespace App\Repositories\Voucher;

use App\Models\Voucher;
use App\Repositories\EloquentRepository;
use App\Repositories\BaseRepository;
use App\Repositories\Voucher\VoucherRepositoryInterface;

class VoucherRepository extends BaseRepository implements VoucherRepositoryInterface
{
    public function getModel()
    {
        return Voucher::class;
    }
}