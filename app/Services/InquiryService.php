<?php

namespace App\Services;

use App\Enums\InquiryStatus;
use App\Models\PackageInquiry;

class InquiryService
{
    public function updateStatus(PackageInquiry $inquiry, InquiryStatus $status): PackageInquiry
    {
        $inquiry->status = $status;
        $inquiry->save();

        return $inquiry;
    }

    public function delete(PackageInquiry $inquiry): bool
    {
        return $inquiry->delete();
    }
}
