<?php

namespace CB\Commands;

use pocketmine\command\CommandSender;
use pocketmine\command\defaults\VanillaCommand;
use pocketmine\Player;
use CB\main;

class PingCommand extends VanillaCommand
{
    public $plugin;

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
        parent::__construct("ping", "Sehe dein Ping", "/ping");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof Player) {
            if ($sender->hasPermission("cb.ping")) {
                $sender->sendMessage($this->plugin->prefix . "Dein Ping " . $sender->getPing() . "§7!");
                return true;
            } else {
                $sender->sendMessage($this->plugin->prefix . "§cDu hast nicht die nötigen Berechtigung, um diesen Command Auszuführen§7!");
                return true;
            }
        }
        return true;
    }
}
