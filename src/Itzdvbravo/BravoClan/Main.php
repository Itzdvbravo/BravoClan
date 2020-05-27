<?php

namespace Itzdvbravo\BravoClan;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Plugin\PluginBase;
use pocketmine\Server;

class Main extends PluginBase{
    public static $db;
    public static $file;
    public static $clan;
    public static $cmd;

    public function onEnable(){
        self::$db = new \SQLite3($this->getDataFolder()."clans.db");
        self::$db->exec("CREATE TABLE IF NOT EXISTS clans(clan TEXT PRIMARY KEY COLLATE NOCASE, leader TEXT COLLATE NOCASE, level INT, xp INT, nex INT, kills INT, deaths INT, tm INT, maxtm INT)");
        self::$db->exec("CREATE TABLE IF NOT EXISTS members(clan TEXT COLLATE NOCASE, member PRIMARY KEY COLLATE NOCASE, kills INT, deaths INT)");
        self::$file = new Database($this);
        self::$clan = new Clan($this);
        self::$cmd = new Commands($this);
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
    }
    public function onCommand(CommandSender $player, Command $cmd, string $label, array $args): bool{
        Main::$cmd->command($player, $cmd, $label, $args);
        return true;
    }
    public function isOnline($string):bool {
        $player = Server::getInstance()->getPlayer($string);
        if ($player === Null){
            return false;
        } else {
            return true;
        }
    }
    public function getPlayerByString($string){
        return Server::getInstance()->getPlayer($string);
    }
}