<?php

/**
 * 求两个字符串的最长公共子串
 *
 * Class Lcst
 */
class Lcst
{
    protected $str1 = '';
    protected $str1Len = 0;
    protected $str2 = '';
    protected $str2Len = 0;
    protected $dp = [[]];
    protected $startPos = 0;
    protected $endPos = 0;
    protected $commonStr = '';

    public function __construct($str1, $str2)
    {
        $this->str1 = $str1;
        $this->str1Len = strlen($str1);
        $this->str2 = $str2;
        $this->str2Len = strlen($str2);
    }

    /**
     * 将两个字符串生成矩阵
     *
     */
    public function initDp()
    {
        for ($i = 0; $i < $this->str1Len; $i++) {
            $this->dp[$i][0] = intval($this->str1[$i] == $this->str2[0]);
        }

        for ($j = 1; $j < $this->str2Len; $j++) {
            $this->dp[0][$j] = intval($this->str2[$j] == $this->str1[0]);
        }

        for ($k = 1; $k < $this->str1Len; $k++) {
            for ($m = 1; $m < $this->str2Len; $m++) {
                if ($this->str1[$k] == $this->str2[$m]) {
                    $this->dp[$k][$m] = $this->dp[$k - 1][$m - 1] + 1;
                } else {
                    $this->dp[$k][$m] = 0;
                }
            }
        }
    }

    public function echoDp()
    {
        //输出表头
        echo "  ";
        for ($k = 0; $k < $this->str2Len; $k++) {
            echo $this->str2[$k] . " ";
        }
        echo "\r\n";

        //输出二维数组内容
        $arr = $this->dp;
        $len = count($arr);
        for ($i = 0; $i < $len; $i++) {
            echo $this->str1[$i] . " ";
            $childLen = count($arr[$i]);
            for ($j = 0; $j < $childLen; $j++) {
                echo $arr[$i][$j] . " ";
            }
            echo "\r\n";
        }
    }

    //获取二维数组形成的矩阵
    public function getDp()
    {
        return $this->dp;
    }

    public function calc()
    {
        $max = 0;
        for ($i = 0; $i < $this->str1Len; $i++) {
            for ($j = 0; $j < $this->str2Len; $j++) {
                if ($this->dp[$i][$j] > $max) {
                    $max = $this->dp[$i][$j];
                    $this->endPos = $i;
                }
            }
        }

        $this->startPos = $this->endPos - $max + 1;
        $this->commonStr = substr($this->str1, $this->startPos, $max);
    }

    /**
     * 输出公共子串
     *
     * @return string
     */
    public function getCommonStr()
    {
        return $this->commonStr;
    }

    /**
     * 输出子串的位置
     *
     * @return string
     */
    public function getPos()
    {
        return "start: $this->startPos  end: $this->endPos";
    }

    /**
     * 开始计算
     *
     */
    public function done()
    {
        $this->initDp();
        $this->calc();
        $this->echoDp();
        echo "str1 and str2 common str is: " . $this->getCommonStr() . "\r\n";
        echo "common str length is " . $this->getPos() . "\r\n";
    }
}

$str1 = 'afdesbcdeoofghireiwpmvlkgf';
$str2 = 'bebcdefoogifdsjlredslfd';
$l = new Lcst($str1, $str2);
$l->done();