<?php

namespace CB\Commands;

use pocketmine\command\CommandSender;
use pocketmine\command\defaults\VanillaCommand;
use pocketmine\level\Level;
use pocketmine\Player;
use CB\main;

class HealCommand extends VanillaCommand
{
    public $plugin;

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
        parent::__construct("heal", "Setze dein Leben auf voll", "/heal");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof Player) {
            if ($sender->hasPermission("cb.heal")) {
                $sender->setHealth($sender->getMaxHealth());
                $sender->sendMessage($this->plugin->prefix . "Du hast dich Gehealth§7!");
                return true;
            } else {
                $sender->sendMessage($this->plugin->prefix . "§cDu hast nicht die nötigen Berechtigung, um diesen Command Auszuführen§7!");
                return true;
            }
        }
        return true;
    }
}
