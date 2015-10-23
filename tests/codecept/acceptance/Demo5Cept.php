<?php
/**
 * @var Codeception\TestCase\Cept $this
 * @var Codeception\Scenario $scenario
 */

$I = new AcceptanceTester($scenario);
$I->amOnPage('/demo5');
$I->wantTo('See panel');
$I->see('Panel Header');
$I->see('Panel Body');
$I->see('Panel Footer');

