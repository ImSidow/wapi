<?php

namespace Imsidow\Wapi\Enumerations;

enum ResponseStatusCode
{
    const INSUFFICIENT_BALANCE = 430;
    const INVALID_PIN_CODE = 432;
    const USER_CANCEL = 434;
    const REQUEST_TIMEOUT = 436;
    const INVALID_PHONE_NUMBER = 438;
    const UNKNOWN = 450;
}
