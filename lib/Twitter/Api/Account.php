<?php

namespace Twitter\Api;

use \Twitter\Api,
    \Twitter\Client\HTTP;

class Account extends Api
{
    public function verify($username = null, $password = null)
    {
        if ($username && $password) {
            $api = new Api(new HTTP($username, $password));
        } else {
            $api = $this;
        }

        return (bool) ! isset($api->get('account/verify_credentials')->error);
    }

    public function getRateLimitStatus()
    {
        return $this->get('account/rate_limit_status');
    }

    public function endSession()
    {
        return $this->post('account/end_session');
    }

    public function updateDeliveryDevice($device)
    {
        if ( ! in_array($device, array('sms', 'none'))) {
            throw new \InvalidArgumentException('Invalid device. Must be either sms or none.');
        }
        return $this->post(sprintf('account/update_delivery_device?device=%s', $device));
    }

    public function updateProfileColors($colors)
    {
        $allowed = array(
            'profile_background_color',
            'profile_text_color',
            'profile_link_color',
            'profile_sidebar_fill_color',
            'profile_sidebar_border_color'
        );
        foreach ($colors as $name => $color) {
            if ( ! in_array($name, $allowed)) {
                throw new \InvalidArgumentException(sprintf('Invalid profile color "%s"', $color));
            }
        }

        return $this->post('account/update_profile_colors', $colors);
    }

    public function updateProfileImage($imagePath)
    {
        return $this->post('account/update_profile_image', array(
            'image' => '@'.$imagePath
        ));
    }

    public function updateProfileBackgroundImage($imagePath, $tile = false)
    {
        return $this->post('account/update_profile_background_image', array(
            'image' => '@'.$imagePath,
            'tile' => $tile ? 'true' : 'false'
        ));
    }

    public function updateProfile(array $profile)
    {
        $allowed = array(
            'name',
            'url',
            'location',
            'description'
        );
        foreach ($profile as $key => $value) {
            if ( ! in_array($key, $allowed)) {
                throw new \InvalidArgumentException(sprintf('Invalid profile key "%s"', $key));
            }
        }
        return $this->post('account/update_profile', $profile);
    }
}