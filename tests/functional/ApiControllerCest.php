<?php

class ApiControllerCest
{
    public function getCommitsList(\FunctionalTester $I)
    {
        $I->sendPOST('commits/list', [
            'limit' => 2,
            'offset' => 0,
        ]);
        $I->canSeeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
    }

    public function getCommitsListErrorWithWrongParameters(\FunctionalTester $I)
    {
        $I->sendPOST('commits/list', ['limit' => 101]);
        $I->canSeeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
    }
}
