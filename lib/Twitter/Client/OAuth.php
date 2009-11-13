<?php

namespace Twitter\Client;

/**
 * OAuth Twitter client
 *
 * @package Twitter
 * @subpackage Api
 * @author Jonathan H. Wage <jonwage@gmail.com>
 */
class OAuth extends AbstractClient
{
    private $_oAuth;
    private $_token;

    public function __construct($consumerKey, $consumerSecret, $signatureMethod = OAUTH_SIG_METHOD_HMACSHA1, $authType = OAUTH_AUTH_TYPE_URI)
    {
        $this->_oAuth = new OAuth($consumerKey, $consumerSecret, $signatureMethod, $authType);
        $result = $this->_oAuth->getRequestToken('https://twitter.com/oauth/request_token');
        $this->_oAuth->setToken($result['oauth_token'], $result['oauth_token_secret']);
        // How can we get the username?
    }

    protected function _doFetch($url, array $data = array(), $method = 'get')
    {
        $this->_oAuth->fetch($url, $data, $method);
        return $this->_oAuth->getLastResponse();
    }
}