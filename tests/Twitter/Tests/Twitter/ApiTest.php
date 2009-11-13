<?php

namespace Twitter\Tests\Twitter;

use \Twitter\Api,
    \Twitter\Client\HTTP;

require_once __DIR__ . '/../TestInit.php';

class ApiTest extends \PHPUnit_Framework_TestCase
{
    private $_client;

    public function setUp()
    {
        $this->_client = new MockClient('jwage', 'password');
    }

    public function testAccount()
    {
        $account = new Api\Account($this->_client);
        $account->verify();
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/account/verify_credentials.json');

        $account->getRateLimitStatus();
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/account/rate_limit_status.json');

        $account->updateDeliveryDevice('sms');
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/account/update_delivery_device.json?device=sms');

        $colors = array(
            'profile_background_color' => 'ffffff',
            'profile_text_color' => '000000',
            'profile_link_color' => '000000',
            'profile_sidebar_fill_color' => '9bcef8',
            'profile_sidebar_border_color' => 'b8b8b8'
        );
        $account->updateProfileColors($colors);
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/account/update_profile_colors.json');
        $this->assertLastRequestDataEquals($colors);
        $this->assertLastRequestMethodEquals('post');

        $account->updateProfileImage('/Users/jwage/Desktop/me.jpg');
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/account/update_profile_image.json');
        $this->assertLastRequestDataEquals(array('image' => '@/Users/jwage/Desktop/me.jpg'));
        $this->assertLastRequestMethodEquals('post');

        $account->updateProfile(array(
            'name' => 'Jonathan H. Wage'
        ));
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/account/update_profile.json');
        $this->assertLastRequestDataEquals(array('name' => 'Jonathan H. Wage'));
        $this->assertLastRequestMethodEquals('post');

        $account->getUser('jwage');
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/users/show/jwage.json');

        $account->updateProfileBackgroundImage('/Users/jwage/Desktop/Doctrine/Logos/big-logo-white-bg.gif', false);
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/account/update_profile_background_image.json');
        $this->assertLastRequestDataEquals(array(
            'image' => '@/Users/jwage/Desktop/Doctrine/Logos/big-logo-white-bg.gif',
            'tile' => true
        ));
        $this->assertLastRequestMethodEquals('post');      

        $account->endSession();
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/account/end_session.json');  
    }

    public function testBlocks()
    {
        $blocks = new Api\Blocks($this->_client);

        $blocks->blockUser('doctrineorm');
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/blocks/create/doctrineorm.json');
        $this->assertLastRequestMethodEquals('post');

        $blocks->getBlockedUsers();
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/blocks/blocking.json');

        $blocks->getBlockedIds();
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/blocks/blocking/ids.json');

        $blocks->deleteBlock('doctrineorm');
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/blocks/destroy/doctrineorm.json');
        $this->assertLastRequestMethodEquals('delete');

        $blocks->isBlocking('doctrineorm');
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/blocks/exists/doctrineorm.json');
    }

    public function testDirectMessages()
    {
        $dms = new Api\DirectMessages($this->_client);
        $dms->sendMessage('apiunittest', 'first test direct message');
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/direct_messages/new.json');
        $this->assertLastRequestDataEquals(array(
            'user' => 'apiunittest',
            'text' => 'first test direct message'
        ));
        $this->assertLastRequestMethodEquals('post');

        $dms->getMostRecent();
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/direct_messages.json');

        $dms->getSent();
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/direct_messages/sent.json');

        $dms->deleteMessage('1234');
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/direct_messages/destroy/1234.json');
        $this->assertLastRequestMethodEquals('delete');
    }

    public function testFavorites()
    {
        $favorites = new Api\Favorites($this->_client);
        $favorites->createFavorite('5631632347');
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/favorites/create/5631632347.json');
        $this->assertLastRequestMethodEquals('post');

        $favorites->getMostRecent();
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/favorites.json?id=jwage');

        $favorites->deleteFavorite('5631632347');
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/favorites/destroy/5631632347.json');
        $this->assertLastRequestMethodEquals('delete');
    }

    public function testFriendships()
    {
        $friendships = new Api\Friendships($this->_client);
        $friendships->unfollow('apiunittest');
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/friendships/destroy/apiunittest.json');
        $this->assertLastRequestMethodEquals('delete');

        $friendships->follow('apiunittest');
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/friendships/create/apiunittest.json');
        $this->assertLastRequestMethodEquals('post');

        $friendships->isFollowing('apiunittest');
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/friendships/show.json?source_screen_name=jwage&target_screen_name=apiunittest');

        $friendships->isFollowedBy('apiunittest');
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/friendships/show.json?source_screen_name=jwage&target_screen_name=apiunittest');

        $friendships->getFriendship('doctrineorm');
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/friendships/show.json?source_screen_name=jwage&target_screen_name=doctrineorm');
    }

    public function testLists()
    {
        $lists = new Api\Lists($this->_client);
        $lists->createList('Test Twitter List');
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/jwage/lists.json');
        $this->assertLastRequestMethodEquals('post');

        $lists->deleteList('test-twitter-list');
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/jwage/lists/test-twitter-list.json');
        $this->assertLastRequestMethodEquals('delete');
    }

    public function testListMembers()
    {
        $listMembers = new Api\ListMembers($this->_client);
        $slug = 'jwage-test-list';
        $listMembers->addMember($slug, '1');
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/jwage/1/members.json');
        $this->assertLastRequestMethodEquals('post');

        $listMembers->deleteMember($slug, '2');
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/jwage/2/members.json');
        $this->assertLastRequestMethodEquals('delete');
    }

    public function testListSubscribers()
    {
        $listSubscribers = new Api\ListSubscribers($this->_client);
        $listSubscribers->subscribe('jaxn/faves');
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/jaxn/faves/subscribers.json');
        $this->assertLastRequestMethodEquals('post');

        $listSubscribers->unsubscribe('jaxn/faves');
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/jaxn/faves/subscribers.json');
        $this->assertLastRequestMethodEquals('delete');

        $listSubscribers->isSubscriber('jaxn/faves', '2');
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/jaxn/faves/subscribers/2.json');

        $listSubscribers->getSubscribers('jaxn/faves');
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/jaxn/faves/subscribers.json');
    }

    public function testNotifications()
    {
        $notifications = new Api\Notifications($this->_client);
        $notifications->disable('fabpot');
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/notifications/leave/fabpot.json');
        $this->assertLastRequestMethodEquals('post');

        $notifications->enable('fabpot');
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/notifications/follow/fabpot.json');
        $this->assertLastRequestMethodEquals('post');
    }

    public function testSavedSearches()
    {
        $savedSearches = new Api\SavedSearches($this->_client);
        $savedSearches->getSavedSearches();
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/saved_searches.json');

        $savedSearches->getSavedSearch('1');
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/saved_searches/show/1.json');

        $savedSearches->createSavedSearch('@jwage');
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/saved_searches/create.json');
        $this->assertLastRequestMethodEquals('post');
        $this->assertLastRequestDataEquals(array(
            'query' => '@jwage'
        ));

        $savedSearches->deleteSavedSearch('1');
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/saved_searches/destroy.json');
        $this->assertLastRequestMethodEquals('delete');
        $this->assertLastRequestDataEquals(array(
            'id' => 1,
            '_method' => 'DELETE'
        ));
    }

    public function testSocialGraph()
    {
        $socialGraph = new Api\SocialGraph($this->_client);
        $socialGraph->getFriendIds();
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/friends/ids/jwage.json');

        $socialGraph->getFollowerIds();
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/followers/ids/jwage.json');
    }

    public function testStatuses()
    {
        $statuses = new Api\Statuses($this->_client);        
        $statuses->getPublicTimeline();
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/statuses/public_timeline.json');

        $statuses->getFriendsTimeline();
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/statuses/friends_timeline.json');

        $statuses->getUserTimeline();
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/statuses/user_timeline.json');

        $status = $statuses->updateStatus('test');
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/statuses/update.json');
        $this->assertLastRequestDataEquals(array(
            'status' => 'test'
        ));
        $this->assertLastRequestMethodEquals('post');

        if ($status) {
            $statuses->deleteStatus($status->id);
        }

        $statuses->getStatus('1');
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/statuses/show/1.json');

        $statuses->deleteStatus('2');
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/statuses/destroy/2.json');

        $statuses->getUserFriends('fabpot');
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/statuses/friends/fabpot.json');

        $statuses->getUserFollowers('fabpot');
        $this->assertLastRequestUrlEquals('http://api.twitter.com/1/statuses/followers/fabpot.json');
    }

    public function testSearch()
    {
        $search = new Api\Search($this->_client);
        $search->find('jwage', array(
            'rpp' => 50
        ));
        $this->assertLastRequestUrlEquals('http://search.twitter.com/search.json?q=jwage&rpp=50');        
        $this->assertLastRequestDataEquals(array(
            'rpp' => 50
        ));
    }

    public function assertLastRequestUrlEquals($url)
    {
        $lastRequest = $this->_client->getLastRequest();
        $this->assertEquals($url, $lastRequest[0]);
    }

    public function assertLastRequestDataEquals($data)
    {
        $lastRequest = $this->_client->getLastRequest();
        $this->assertEquals($data, $lastRequest[1]);
    }

    public function assertLastRequestMethodEquals($method)
    {
        $lastRequest = $this->_client->getLastRequest();
        $this->assertEquals($method, $lastRequest[2]);
    }

    public function assertUserExists($username, $users)
    {
        foreach ($users as $user) {
            if ($user->screen_name == $username) {
                return true;
            }
        }
        return false;
    }
}

class MockClient extends \Twitter\Client\HTTP
{
    private $_requests = array();

    public function getLastRequest()
    {
        return end($this->_requests);
    }

    protected function _doFetch($url, array $data, $method)
    {
        $this->_requests[] = array(
            $url, $data, $method
        );

        return json_encode(array());
        //return parent::_doFetch($url, $data, $method);
    }
}