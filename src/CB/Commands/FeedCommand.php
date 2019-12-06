<?php

namespace CB\Commands;

use pocketmine\command\CommandSender;
use pocketmine\command\defaults\VanillaCommand;
use pocketmine\level\Level;
use pocketmine\Player;
use CB\main;

class FeedCommand extends VanillaCommand {
    public $plugin;

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
        parent::__construct("feed", "Setze dein Feed auf voll", "/feed");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if ($sender instanceof Player) {
            if ($sender->hasPermission("cb.feed")) {
                $sender->setFood(20);
                $sender->sendMessage($this->plugin->prefix. "Du hast dich Gefüttert§7!");
                return true;
        } else {
            $sender->sendMessage($this->plugin->prefix. "§cDu hast nicht die nötigen Berechtigung, um diesen Command Auszuführen§7!");
            return true;
        }
        }
    }
}
