<?php

namespace CB;

use pocketmine\{
    Server,
    Player
};
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use CB\Commands\{
    HealCommand,
    FeedCommand,
    SpawnCommand,
    DayCommand,
    NightCommand,
    GamemodeCommand,
    PingCommand
};
use pocketmine\utils\TextFormat as f;
use pocketmine\utils\Config;
use pocketmine\scheduler\Task;
use pocketmine\network\mcpe\protocol\RemoveObjectivePacket;
use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;
use onebone\economyapi\EconomyAPI;

class main extends PluginBase implements Listener{
    
    public $prefix = "§l§3CityBuild §r§7» §f";
    
    public function onEnable(): void{
        $this->saveDefaultConfig();
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $this->config->getAll();
        $this->getScheduler()->scheduleRepeatingTask(new ScoreBoardTask($this), 20);
        $cmdmap = $this->getServer()->getCommandMap();
        $cmdmap->register("day", new DayCommand($this));
        $cmdmap->register("gm", new GamemodeCommand($this));
        $cmdmap->register("ping", new PingCommand($this));
        $cmdmap->register("day", new DayCommand($this));
        $cmdmap->register("gm", new GamemodeCommand($this));
        $cmdmap->register("ping", new PingCommand($this));
        $cmdmap->register("heal", new HealCommand($this));
        $cmdmap->register("feed", new FeedCommand($this));
        $cmdmap->register("spawn", new SpawnCommand($this));
        $cmdmap->register("night", new NightCommand($this));
    }
    
    public function setScoreboardEntry(Player $player, int $score, string $msg, string $objName)
    {
        $entry = new ScorePacketEntry();
        $entry->objectiveName = $objName;
        $entry->type = 3;
        $entry->customName = " $msg   ";
        $entry->score = $score;
        $entry->scoreboardId = $score;
        $pk = new SetScorePacket();
        $pk->type = 0;
        $pk->entries[$score] = $entry;
        $player->sendDataPacket($pk);
    }

    public function rmScoreboardEntry(Player $player, int $score)
    {
        $pk = new SetScorePacket();
        if (isset($pk->entries[$score])) {
            unset($pk->entries[$score]);
            $player->sendDataPacket($pk);
        }
    }

    public function createScoreboard(Player $player, string $title, string $objName, string $slot = "sidebar", $order = 0)
    {
        $pk = new SetDisplayObjectivePacket();
        $pk->displaySlot = $slot;
        $pk->objectiveName = $objName;
        $pk->displayName = $title;
        $pk->criteriaName = "dummy";
        $pk->sortOrder = $order;
        $player->sendDataPacket($pk);
    }

    public function rmScoreboard(Player $player, string $objName)
    {
        $pk = new RemoveObjectivePacket();
        $pk->objectiveName = $objName;
        $player->sendDataPacket($pk);
    }

    public function onScore()
    {
        $pl = $this->getServer()->getOnlinePlayers();
        foreach ($pl as $player) {
            $name = $player->getName();
            $this->rmScoreboard($player, "objektName");
            $money = EconomyAPI::getInstance()->myMoney($player);

            $this->createScoreboard($player, "§l§3CITYBUILD", "objektName");
            $this->setScoreboardEntry($player, 0, "   §e ", "objektName");
            $this->setScoreboardEntry($player, 1, f::GRAY . "» " . f::BOLD . f::YELLOW . "§7Name", "objektName");
            $this->setScoreboardEntry($player, 2, f::DARK_RED . "§8➥ §7" . $player->getDisplayName(), "objektName");
            $this->setScoreboardEntry($player, 3, " §a", "objektName");
            $this->setScoreboardEntry($player, 4, f::GRAY . "» " . f::BOLD . f::YELLOW . "§7Server ", "objektName");#»
            $this->setScoreboardEntry($player, 5, f::GRAY . "§8➥ §7CityBuild", "objektName");
            $this->setScoreboardEntry($player, 6, "   §c ", "objektName");
            $this->setScoreboardEntry($player, 7, f::GRAY . "» " . f::BOLD . f::YELLOW . "§7Online", "objektName");
            $this->setScoreboardEntry($player, 8, f::RED . "§8➥ §7" . count($this->getServer()->getOnlinePlayers()) . "§7/§7{$this->getServer()->getMaxPlayers()}", "objektName");
            $this->setScoreboardEntry($player, 9, "  §d    ", "objektName");
            $this->setScoreboardEntry($player, 10, f::GRAY . "» " . f::BOLD . f::YELLOW . "§7Money", "objektName");
            $this->setScoreboardEntry($player, 11, f::GRAY . "§8➥§7 $money", "objektName");
            $this->setScoreboardEntry($player, 12, "  §3    ", "objektName");
        }
    }
}
