<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    private $P1point = 0;
    private $P2point = 0;
    private $P1res = "";
    private $P2res = "";
    private $player1Name = "Roger Federer";
    private $player2Name = "Novak Djokovic";

    /**
     * @Route("/", name="homepage")
     */
    public function getScoreAction()
    {
        $this->P1point = $this->get('session')->get('P1points');
        $this->P2point = $this->get('session')->get('P2points');

        $score = "";
        if ($this->P1point == $this->P2point && $this->P1point < 4) {
            if ($this->P1point == 0) {
                $score = "Love";
            }
            if ($this->P1point == 1) {
                $score = "Fifteen";
            }
            if ($this->P1point == 2) {
                $score = "Thirty";
            }
            $score .= "-All";
        }
        if ($this->P1point == $this->P2point && $this->P1point >= 3) {
            $score = "Deuce";
        }
        if ($this->P1point > 0 && $this->P2point == 0) {
            if ($this->P1point == 1) {
                $this->P1res = "Fifteen";
            }
            if ($this->P1point == 2) {
                $this->P1res = "Thirty";
            }
            if ($this->P1point == 3) {
                $this->P1res = "Forty";
            }
            $this->P2res = "Love";
            $score = "{$this->P1res}-{$this->P2res}";
        }
        if ($this->P2point > 0 && $this->P1point == 0) {
            if ($this->P2point == 1) {
                $this->P2res = "Fifteen";
            }
            if ($this->P2point == 2) {
                $this->P2res = "Thirty";
            }
            if ($this->P2point == 3) {
                $this->P2res = "Forty";
            }
            $this->P1res = "Love";
            $score = "{$this->P1res}-{$this->P2res}";
        }
        if ($this->P1point > $this->P2point && $this->P1point < 4) {
            if ($this->P1point == 2) {
                $this->P1res = "Thirty";
            }
            if ($this->P1point == 3) {
                $this->P1res = "Forty";
            }
            if ($this->P2point == 1) {
                $this->P2res = "Fifteen";
            }
            if ($this->P2point == 2) {
                $this->P2res = "Thirty";
            }
            $score = "{$this->P1res}-{$this->P2res}";
        }
        if ($this->P2point > $this->P1point && $this->P2point < 4) {
            if ($this->P2point == 2) {
                $this->P2res = "Thirty";
            }
            if ($this->P2point == 3) {
                $this->P2res = "Forty";
            }
            if ($this->P1point == 1) {
                $this->P1res = "Fifteen";
            }
            if ($this->P1point == 2) {
                $this->P1res = "Thirty";
            }
            $score = "{$this->P1res}-{$this->P2res}";
        }
        if ($this->P1point > $this->P2point && $this->P2point >= 3) {
            $score = "Advantage Roger Federer";
        }
        if ($this->P2point > $this->P1point && $this->P1point >= 3) {
            $score = "Advantage Novak Djokovic";
        }
        if ($this->P1point >= 4 && $this->P2point >= 0 && ($this->P1point - $this->P2point) >= 2) {
            $score = "Roger Federer Win";
        }
        if ($this->P2point >= 4 && $this->P1point >= 0 && ($this->P2point - $this->P1point) >= 2) {
            $score = "Novak Djokovic Win";
        }

        return $this->render('default/index.html.twig', [
            'score' => $score,
        ]);
    }

    private function SetP1Score($number)
    {
        for ($i = 0; $i < $number; $i++) {
            $this->P1Score();
        }
    }

    private function SetP2Score($number)
    {
        for ($i = 0; $i < $number; $i++) {
            $this->P2Score();
        }
    }

    private function P1Score()
    {
        $this->P1point++;
    }

    private function P2Score()
    {
        $this->P2point++;
    }

    /**
     * @Route("/play/{player}", name="play")
     */
    public function wonPointAction($player)
    {
        $this->P1point = $this->get('session')->get('P1points');
        $this->P2point = $this->get('session')->get('P2points');

        if ($player == "Roger Federer") {
            $this->P1Score();
        } else {
            $this->P2Score();
        }
        $this->get('session')->set('P1points', $this->P1point);
        $this->get('session')->set('P2points', $this->P2point);

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/reset", name="reset")
     */
    public function resetAction()
    {
        $this->get('session')->clear();

        return $this->redirectToRoute('homepage');
    }
}
