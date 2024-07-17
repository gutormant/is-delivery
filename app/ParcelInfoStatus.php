<?php

namespace App;

enum ParcelInfoStatus: string
{
    case NEW = 'new';
    case SENT = 'sent';
    case FAILED = 'failed';
    case RETRY_SEND = 'retry_send';
}
