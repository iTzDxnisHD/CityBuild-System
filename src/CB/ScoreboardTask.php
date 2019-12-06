<?php

namespace CB;

use pocketmine\scheduler\Task;

class ScoreBoardTask extends Task
{

    private $plugin;

    public function __construct(main $plugin)
    {
          $this->plugin = $plugin;
    }

    public function onRun(int $currentTick)
    {
        $this->plugin->onScore();
     }
}
