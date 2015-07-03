<?php
use Codeception\Util\Fixtures;
/**
 * @var Codeception\TestCase\Cept $this
 * @var Codeception\Scenario $scenario
 */

$I = new AcceptanceTester($scenario);
$I->amOnPage('/demo4');
$I->wantTo('See users list for demo4');
$I->see('Users List');
$I->see('John');
$I->seeNumberOfElements('div[data-id]', count(Fixtures::get('users_array')));

$I->wantTo('filter users by name="Bruce"');
$I->fillField('[name="name_filter"]', 'Bruce');
$I->click('Filter');
$I->see('Bruce');
$I->seeNumberOfElements('div[data-id]', 1);


