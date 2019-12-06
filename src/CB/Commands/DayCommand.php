<?php

namespace CB\Commands;

use pocketmine\command\CommandSender;
use pocketmine\command\defaults\VanillaCommand;
use pocketmine\level\Level;
use pocketmine\Player;
use CB\main;

class DayCommand extends VanillaCommand {
    public $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
        parent::__construct("day", "Setze die Zeit auf Tag", "/day", ["tag"]);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if ($sender instanceof Player) {
            if ($sender->hasPermission("cb.day")) {
                $sender->getLevel()->setTime(6000);
                $sender->sendMessage($this->plugin->prefix. "Zeit wurde auf Tag Gestellt§7!");
                return true;
        } else {
            $sender->sendMessage($this->plugin->prefix. "§cDu hast nicht die nötigen Berechtigung, um diesen Command Auszuführen§7!");
            return true;
        }
        }
    }
}
