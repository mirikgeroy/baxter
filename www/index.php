<?php
$cookie = tempnam('/tmp', 'cookie');

// log in
$c = curl_init('http://ru.iq-test.cc/start');
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($c, CURLOPT_COOKIEJAR, $cookie);
$page = curl_exec($c);
curl_close($c);

$answers = array(1 => 2, 2 => 3, 3 => 3, 30 => 5);

foreach ($answers as $question => $answer) {
    list($page, $cookie) = nexStep($question, $answer, $cookie);
    $pages[] = $page;
}

print_r($pages);
list($page, $cookie) = nexStep($question, $answer, $cookie,'finish3');
$loadRegistrationUrl = 'http://ru.iq-test.cc/finish2';
$loadRegistrationPostUrl = 'http://ru.iq-test.cc/finish3';
$submitData = array(
    'firstname' => 'Mirik',
    'lastname' => 'Progger',
    'age' => 25,
    'email' => 'some_semail@gmail.com',
);

/**
 * @param integer $stepId
 * @param integer $answerId
 * @param $cookie
 * @param string $pageId
 * @return mixed
 */
function nexStep($stepId, $answerId, $cookie, $pageId = 'start')
{
    $c = curl_init(sprintf('http://ru.iq-test.cc/%s?qid=%s&answered_id=%s', $pageId, $stepId, $answerId));
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_COOKIEJAR, $cookie);
    $page = curl_exec($c);
    curl_close($c);
    return array($page, $cookie);
}

