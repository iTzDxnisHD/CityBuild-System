<?php

namespace CB\Commands;

use pocketmine\command\CommandSender;
use pocketmine\command\defaults\VanillaCommand;
use pocketmine\level\Level;
use pocketmine\Player;
use CB\main;

class GamemodeCommand extends VanillaCommand
{
    public $plugin;

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
        parent::__construct("gm", "Setze dich in Gamemode", "/gm");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof Player) {
            if ($sender->hasPermission("cb.gm")) {
                if ($args[0] === "1") {
                    $sender->setGamemode($sender::CREATIVE);
                    $sender->sendMessage($this->plugin->prefix . "Dein Gamemode wurde Geändert§7!");
                    return true;
                } else {
                    if ($args[0] === "2") {
                        $sender->setGamemode($sender::ADVENTURE);
                        $sender->sendMessage($this->plugin->prefix . "Dein Gamemode wurde Geändert§7!");
                        return true;
                    } else {
                        if ($args[0] === "3") {
                            $sender->setGamemode($sender::SPECTATOR);
                            $sender->sendMessage($this->plugin->prefix . "Dein Gamemode wurde Geändert§7!");
                            return true;
                        } else {
                            if ($args[0] === "0") {
                                $sender->setGamemode($sender::SURVIVAL);
                                $sender->sendMessage($this->plugin->prefix . "Dein Gamemode wurde Geändert§7!");
                                return true;
                            }
                        }
                    }
                }
            } else {
                $sender->sendMessage($this->plugin->prefix . "§cDu hast nicht die nötigen Berechtigung, um diesen Command Auszuführen§7!");
                return true;
            }
        }
        return true;
    }
}
