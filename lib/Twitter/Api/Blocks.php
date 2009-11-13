<?php

namespace Twitter\Api;

use \Twitter\Api;

/**
 * Block Methods
 *
 * @package Twitter
 * @subpackage Api
 * @author Jonathan H. Wage <jonwage@gmail.com>
 */
class Blocks extends Api
{
    public function blockUser($username)
    {
        return $this->post(sprintf('blocks/create/%s', $username));
    }

    public function deleteBlock($username)
    {
        return $this->delete(sprintf('blocks/destroy/%s', $username));
    }

    public function isBlocking($username)
    {
        $result = $this->get(sprintf('blocks/exists/%s', $username));
        return isset($result->error) ? false : true;
    }

    public function getBlockedUsers()
    {
        return $this->get('blocks/blocking');
    }

    public function getBlockedIds()
    {
        return $this->get('blocks/blocking/ids');
    }
}