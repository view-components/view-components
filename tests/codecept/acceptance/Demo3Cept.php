<?php
use Codeception\Util\Fixtures;
/** @var Codeception\TestCase\Cept $this */
$I = new AcceptanceTester($scenario);
$I->wantTo('perform actions and see result');
$I->amOnPage('/demo3');
$I->see('Users List');

$I->see('John');
$I->seeNumberOfElements('div[data-id]', count(Fixtures::get('users_array')));

$I->wantTo('check that list is sorted');
$this->assertEquals(
    'Anna',
    $I->grabTextFrom('div[data-id] h3'),
    'Anna must be first if list is sorted'
);


