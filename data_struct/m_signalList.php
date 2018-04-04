<?php
/**
 * Created by PhpStorm.
 * User: evolution
 * Date: 16-11-23
 * Time: 上午10:39
 */

header("content-type:text/html;charset=UTF-8");

class LNode
{
    public $value;
    public $next;

    public function __construct()
    {
        $this->value = null;
        $this->next = null;
    }
}

class SignalList
{
    public $head;
    public $linkLen = 0;

    public function __construct()
    {
        $this->head = NULL;
    }

    /**
     * 链表长度加１
     */
    private function increateLinkLen()
    {
        $this->linkLen++;
    }

    /**
     * 链表长减1
     */
    private function decreateLinkLen()
    {
        $this->linkLen--;
    }

    /**
     * 获取链表长度
     *
     * @return int
     */
    public function getLinkLen()
    {
        return $this->linkLen;
    }

    /**
     * 多数据头插法
     */
    public function multiHeadInsert(Array $varr = [])
    {
        if (empty($varr)) {
            return false;
        } else {
            foreach ($varr as $value) {
                $this->headInsert($value);
            }
        }
    }

    /**
     * 单数据头插法
     *
     * @param $value
     */
    public function headInsert($value = '')
    {
        if (empty($value)) {
            return false;
        }
        $node = new LNode();
        $node->value = $value;
        $this->increateLinkLen();
        if (empty($this->head)) {
            $this->head = $node;
        } else {
            $node->next = $this->head;
            $this->head = $node;
        }
    }

    /**
     * 批量删除
     *
     * @param array $varr
     * @return bool
     */
    public function multiDelElem(Array $varr = [])
    {
        if (empty($varr)) {
            return false;
        } else {
            foreach ($varr as $value) {
                $this->delElem($value);
            }
        }
    }

    /**
     * 删除指定值的节点 (对象本身传递的就是引用)
     *
     * @param $value
     * @return bool
     */
    public function delElem($value)
    {
        //判断是否有头节点
        if ($this->linkLen < 1) {
            return false;
        }
        if ($this->head->value == $value) {
            $this->head = $this->head->next;
            $this->decreateLinkLen();
        } else {
            $thead = $this->head;
            while ($thead->next) {
                if ($thead->next->value == $value) {
                    $thead->next = $thead->next->next;
                    $this->decreateLinkLen();
                    break;
                } else {
                    $thead = $thead->next;
                }
            }
        }
    }

    public function updateLinkElem($oldValue, $newValue)
    {
        if($this->linkLen < 1){
            return false;
        }
        if ($this->head->value == $oldValue) {
            $this->head->value = $newValue;
        } else {
            $thead = $this->head;
            while ($thead->next) {
                if ($thead->next->value == $oldValue) {
                    $thead->next->value = $newValue;
                    break;
                } else {
                    $thead = $thead->next;
                }
            }
        }
    }

    /**
     * 获取指定位置的
     * @param $pos
     * @return bool
     */
    public function getNodeForPos($pos)
    {
        $linkLen = $this->getLinkLen();
        if ($pos > $linkLen || $pos < 1) {
            return false;
        } else {
            $j = 1;
            $thead = $this->head;
            while ($j < $pos) {
                $thead = $thead->next;
                $j++;
            }

            return $thead->value;
        }
    }

    /**
     * 获取链表内容
     * @return string
     */
    public function getLinkContent()
    {
        if ($this->linkLen > 0) {
            $result = [];
            $thead = $this->head;
            while (isset($thead->value)) {
                $result[] = $thead->value;
                $thead = $thead->next;
            }
            return implode(',', $result);
        } else {
            return '链表已无内容';
        }
    }
}

$linkObj = new SignalList();

//向链表中批量插入值
$linkObj->multiHeadInsert([1, 2, 3, 4, 5, 6]);
echo "插入后链表中的值：";
print_r($linkObj->getLinkContent());
echo "\r\n";

//获取链表中指定位置的值
echo "获取链表中指定位置的值：";
print_r($linkObj->getNodeForPos(5));
echo "\r\n";

//批量删除链表中的值
$linkObj->multiDelElem([5, 1]);
echo "删除链表中指定的值后：";
print_r($linkObj->getLinkContent());
echo "\r\n";

//修改链表中的值
$linkObj->updateLinkElem(6,60);
$linkObj->updateLinkElem(2,20);
echo "修改完链表中的值后：";
print_r($linkObj->getLinkContent());
echo "\r\n";