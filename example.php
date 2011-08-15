<?php
//Test
require 'lib/Twitter/ClassLoader.php';

$classLoader = new \Twitter\ClassLoader('Twitter');
$classLoader->register();

$client = new \Twitter\Client\HTTP('username', 'password');

/*
$statuses = new \Twitter\Api\Statuses($client);
while ($friends = $statuses->getUserFriends('jwage', true)) {
    foreach ($friends->users as $friend) {
        echo $friend->screen_name . "\n";
    }
}
*/

/*
$statuses = new \Twitter\Api\Statuses($client);
while ($followers = $statuses->getUserFollowers('jwage', true)) {
    foreach ($followers->users as $follower) {
        echo $follower->screen_name . "\n";
    }
}
*/

/*
$search = new \Twitter\Api\Search($client);

$count = 1;
while($results = $search->find('@jwage', array('rpp' => 50), true)) {
    echo "\nPage #" . $count."\n\n";

    foreach ($results->results as $result) {
        echo $result->text . "\n";
    }

    $count++;
}
*/

/*
$search = new \Twitter\Api\Search($client);

$trends = $search->getWeeklyTrends(new \DateTime('2009-05-01'), false);
print_r($trends);
*/