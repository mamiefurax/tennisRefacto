<?php

namespace Tests\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class DefaultControllerTest extends TestMaster
{
    private $P1point = 0;
    private $P2point = 0;

    private $session = null;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->controller = $this->getMock('AppBundle\Controller\DefaultController', ['get', 'render', 'redirectToRoute']);

        $this->session = new Session(new MockArraySessionStorage());

        $this->controller->expects($this->any())
            ->method('get')
            ->with('session')
            ->willReturn($this->session);

        $this->controller->expects($this->any())
            ->method('render')
            ->will($this->returnArgument(1));

        $this->controller->expects($this->any())
            ->method('redirectToRoute')
            ->willReturn(null);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->controller = null;
        $this->session = null;
        parent::tearDown();
    }

    /**
     * @param int $score1
     * @param int $score2
     * @param string $expectedResult
     * @dataProvider data
     */
    public function testScores($score1, $score2, $expectedResult)
    {
        $highestScore = max($score1, $score2);
        for ($i = 0; $i < $highestScore; $i++) {
            if ($i < $score1) {
                $this->controller->wonPointAction("Roger Federer");
            }
            if ($i < $score2) {
                $this->controller->wonPointAction("Novak Djokovic");
            }
        }
        $this->assertEquals($expectedResult, $this->controller->getScoreAction());
    }
}
