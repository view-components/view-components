<?php
use Codeception\Util\Fixtures;

$I = new AcceptanceTester($scenario);
$I->wantTo('perform actions and see result');
$I->amOnPage('/demo1');
$I->see('Users List');

$I->see('John');
$I->seeNumberOfElements('div[data-id]', count(Fixtures::get('users_array')));