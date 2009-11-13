<?php

namespace Twitter\Api;

use \Twitter\Api;

/**
 * Notification Methods
 *
 * @package Twitter
 * @subpackage Api
 * @author Jonathan H. Wage <jonwage@gmail.com>
 */
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