<?php

namespace CB\Commands;

use pocketmine\command\CommandSender;
use pocketmine\command\defaults\VanillaCommand;
use pocketmine\level\Level;
use pocketmine\Player;
use CB\main;

class NightCommand extends VanillaCommand {
    public $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
        parent::__construct("night", "Setze die Zeit auf Nacht", "/night", ["nacht"]);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if ($sender instanceof Player) {
            if ($sender->hasPermission("cb.night")) {
                $sender->getLevel()->setTime(1000);
                $sender->sendMessage($this->plugin->prefix. "Zeit wurde auf Nacht Gestellt§7!");
                return true;
        } else {
            $sender->sendMessage($this->plugin->prefix. "§cDu hast nicht die nötigen Berechtigung, um diesen Command Auszuführen§7!");
            return true;
        }
        }
    }
}
