<?php
namespace App\Models;

use Lib\Db\Db;
use Lib\Db\Model;

class Score extends Model
{
    const POSITION = 0;
    const NAME = 1;
    const THRU = 2;
    const ROUND_1 = 3;
    const ROUND_2 = 4;
    const ROUND_3 = 5;
    const ROUND_4 = 6;
    const TOTAL = 7;
    protected $score;

    public function __construct($score = [])
    {
        $this->score = $score;
    }

    public function getGolfer()
    {
        return $this->score[self::NAME];
    }

    public function getRound($i)
    {
        switch ($i) {
            case '1':
                return $this->score[self::ROUND_1];
                break;
            case '2':
                return $this->score[self::ROUND_2];
                break;
            case '3':
                return $this->score[self::ROUND_3];
                break;
            case '4':
                return $this->score[self::ROUND_4];
                break;
            
            default:
                break;
        }
    }

    public function getThru()
    {
        return $this->score[self::THRU];
    }
}