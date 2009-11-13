<?php

namespace Twitter\Api;

use \Twitter\Api;

class Notifications extends Api
{
    public function enable($username)
    {
        return $this->post(sprintf('notifications/follow/%s', $username));
    }

    public function disable($username)
    {
        return $this->post(sprintf('notifications/leave/%s', $username));
    }
}