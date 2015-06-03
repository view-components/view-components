<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('See index page');
$I->amOnPage('/index');
$I->see('Index Page');