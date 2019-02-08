<?php

namespace tests\unit\models;

use app\components\git\Commit;
use app\components\viewer\commit\ApiViewer;
use app\components\viewer\commit\ConsoleViewer;
use app\models\CommitsListRequest;

class CommitsListRequestTest extends \Codeception\Test\Unit
{
    /** @var CommitsListRequest */
    private $model;
    /**
     * @var \UnitTester
     */
    public $tester;

    public function testprocessUsingConsoleViewer()
    {
        $this->mockModel();
        expect($this->model->processUsingViewer(new ConsoleViewer(ConsoleViewer::RENDER_MODE_SHORT)))
            ->equals(iterator_to_array($this->createTestCommit())[0]->hash . ':' . PHP_EOL);
    }


    public function testprocessUsingApiViewer()
    {
        $this->mockModel();
        expect($this->model->processUsingViewer(new ApiViewer(\yii\web\Response::FORMAT_JSON)))
            ->equals(json_encode(json_decode($this->tester->loadFixture('commit_api.json')), true) . PHP_EOL);
    }

    /**
     * @return Commit
     */
    private function createTestCommit()
    {
        yield new Commit(json_decode($this->tester->loadFixture('commit.json'), true));
    }

    private function mockModel()
    {
        /** @var CommitsListRequest $model */
        $this->model = $this->getMockBuilder('app\models\CommitsListRequest')
            ->setMethods(['getCommits'])
            ->getMock();

        $this->model->expects($this->once())
            ->method('getCommits')
            ->will($this->returnValue($this->createTestCommit()));
    }
}
