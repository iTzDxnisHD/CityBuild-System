<?php

namespace CB\Commands;

use pocketmine\command\CommandSender;
use pocketmine\command\defaults\VanillaCommand;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\level\Level;
use CB\main;
use pocketmine\utils\Config;

class SpawnCommand extends VanillaCommand {

    public $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
        parent::__construct("spawn", "Teleportiere dich zum Spawn", "/spawn");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof Player) {
            if ($this->plugin->config instanceof Config) {
                if ($sender->hasPermission("cb.spawn")) {
                    $sender->teleport($this->plugin->getServer()->getDefaultLevel()->getSafeSpawn());
                    return true;
                } else {
                    $sender->sendMessage($this->plugin->prefix . "§cDu hast nicht die nötigen Berechtigung, um diesen Command Auszuführen§7!");
                    return true;
                }
            }
        }
        return true;
    }
}
