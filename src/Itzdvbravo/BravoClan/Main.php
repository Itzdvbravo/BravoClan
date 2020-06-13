<?php

namespace Itzdvbravo\BravoClan;

use pocketmine\Player;
use pocketmine\Plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;

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
        $this->getServer()->getCommandMap()->register("clan", self::$cmd);
        $this->config();
        $this->cfgVersion();
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
    }

    /**
     * @param $string
     * @return bool
     */
    public function isOnline($string):bool {
        $player = Server::getInstance()->getPlayer($string);
        if ($player === Null){
            return false;
        } else {
            return true;
        }
    }

    /**
     * @param $string
     * @return \pocketmine\Player|null
     */
    public function getPlayerByString($string){
        return Server::getInstance()->getPlayer($string);
    }

    public function config(){
        if (!file_exists($this->getDataFolder()."config.yml")) {
            $this->saveResource("config.yml");
        }
    }

    /**
     * @param $member
     * @return string
     */
    public function scorehudAddon($member)
    {
        if (self::$file->isInClan($member)) {
            strtolower($member);
            $dtb = Main::$db->prepare("SELECT * FROM members WHERE member =:member;");
            $dtb->bindValue(":member", $member);
            $end = $dtb->execute();
            $array = $end->fetchArray(SQLITE3_ASSOC);
            $clan = $array["clan"];
            $dtb->close();
            return "$clan";
        } else {
            return "Clanless";
        }
    }

    public function cfgVersion(){
        $cfg = new Config($this->getDataFolder()."config.yml", Config::YAML);
        var_dump($cfg->get("version"));
        if ($cfg->get("version") < 0.2){
            $this->getLogger()->info("Config file version isn't the working version for this plugin version");
        }
    }

    /**
     * @param Player $player
     * @return bool
     */
    public function inPvpWorld(Player $player):bool {
        $cfg = new Config($this->getDataFolder()."config.yml", Config::YAML);
        $array = $cfg->get("pvp-world");
        if (empty($array)){
            return true;
        }
        foreach ($array as $allowed){
            if ($allowed === "DEFAULT"){
                return true;
            } else {
                $list[] = $allowed;
            }
        }
        if (in_array($player->getLevel()->getName(), $list)){
            return true;
        } else {
            return false;
        }
    }
}