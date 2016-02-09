<?php

namespace Tests\AppBundle\Controller;;

use AppBundle\Controller\DefaultController;

class TestMaster extends \PHPUnit_Framework_TestCase
{
    /** @var DefaultController */
    protected $controller = null;

    /**
     * @return mixed[][]
     */
    public function data()
    {
        return array(
            '0-0' => array(0, 0, ['score' => "Love-All"]),
            '1-1' => array(1, 1, ['score' => "Fifteen-All"]),
            '2-2' => array(2, 2, ['score' => "Thirty-All"]),
            '3-3' => array(3, 3, ['score' => "Deuce"]),
            '4-4' => array(4, 4, ['score' => "Deuce"]),
            '1-0' => array(1, 0, ['score' => "Fifteen-Love"]),
            '0-1' => array(0, 1, ['score' => "Love-Fifteen"]),
            '2-0' => array(2, 0, ['score' => "Thirty-Love"]),
            '0-2' => array(0, 2, ['score' => "Love-Thirty"]),
            '3-0' => array(3, 0, ['score' => "Forty-Love"]),
            '0-3' => array(0, 3, ['score' => "Love-Forty"]),
            '4-0' => array(4, 0, ['score' => "Roger Federer Win"]),
            '0-4' => array(0, 4, ['score' => "Novak Djokovic Win"]),
            '2-1' => array(2, 1, ['score' => "Thirty-Fifteen"]),
            '1-2' => array(1, 2, ['score' => "Fifteen-Thirty"]),
            '3-1' => array(3, 1, ['score' => "Forty-Fifteen"]),
            '1-3' => array(1, 3, ['score' => "Fifteen-Forty"]),
            '4-1' => array(4, 1, ['score' => "Roger Federer Win"]),
            '1-4' => array(1, 4, ['score' => "Novak Djokovic Win"]),
            '3-2' => array(3, 2, ['score' => "Forty-Thirty"]),
            '2-3' => array(2, 3, ['score' => "Thirty-Forty"]),
            '4-2' => array(4, 2, ['score' => "Roger Federer Win"]),
            '2-4' => array(2, 4, ['score' => "Novak Djokovic Win"]),
            '4-3' => array(4, 3, ['score' => "Advantage Roger Federer"]),
            '3-4' => array(3, 4, ['score' => "Advantage Novak Djokovic"]),
            '5-4' => array(5, 4, ['score' => "Advantage Roger Federer"]),
            '4-5' => array(4, 5, ['score' => "Advantage Novak Djokovic"]),
            '15-14' => array(15, 14, ['score' => "Advantage Roger Federer"]),
            '14-15' => array(14, 15, ['score' => "Advantage Novak Djokovic"]),
            '6-4' => array(6, 4, ['score' => "Roger Federer Win"]),
            '4-6' => array(4, 6, ['score' => "Novak Djokovic Win"]),
            '16-14' => array(16, 14, ['score' => "Roger Federer Win"]),
            '14-16' => array(14, 16, ['score' => "Novak Djokovic Win"]),
        );
    }

    public function testData()
    {
        $this->assertEquals($this->data(), $this->data());
    }

}