<?php
/**
 * Created by PhpStorm.
 * User: zhanhong01
 * Date: 2019/1/17
 * Time: 14:40
 */
use Phalcon\Cli\Task;
use App\Models\Contents\Rooms;

class TestTask extends Task
{
    public function mainAction()
    {
        echo "fuck";exit;
    }

    /**
     * @param array $params
     */
    public function testAction(array $params)
    {
        $nickname = Rooms::findFirst(13)->nickname;
        echo sprintf('hello %s',$nickname);

        echo PHP_EOL;

        echo sprintf('best regards, %s', $params[1]);

        echo PHP_EOL;
    }
}