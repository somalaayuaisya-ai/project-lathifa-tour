<?php

namespace App\Enums;

enum InquiryStatus: string
{
    case NEW = 'new';
    case CONTACTED = 'contacted';
    case SPAM = 'spam';
}
