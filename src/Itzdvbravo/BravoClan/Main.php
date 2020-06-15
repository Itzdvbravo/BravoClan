<?php

namespace Itzdvbravo\BravoClan;

use Itzdvbravo\BravoClan\Commands\Commands;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

class Main extends PluginBase{
    public static $db;
    /** @var Database */
    public static $file;
    /** @var Clan */
    public static $clan;
    /** @var Commands */
    public static $cmd;
    /** @var Main*/
    public static $instance = null;
    public $messages;

    public function onLoad(){
        self::$instance = $this;
        $this->saveDefaultConfig();
        $this->saveResource("messages.yml");
        $this->messages = new Config($this->getDataFolder()."messages.yml");
    }

    public function onEnable(){
        self::$db = new \SQLite3($this->getDataFolder()."clans.db");
        self::$db->exec("CREATE TABLE IF NOT EXISTS clans(clan TEXT PRIMARY KEY COLLATE NOCASE, leader TEXT COLLATE NOCASE, level INT, xp INT, nex INT, kills INT, deaths INT, tm INT, maxtm INT)");
        self::$db->exec("CREATE TABLE IF NOT EXISTS members(clan TEXT COLLATE NOCASE, member PRIMARY KEY COLLATE NOCASE, kills INT, deaths INT)");
        self::$file = new Database($this);
        self::$clan = new Clan($this);
        self::$cmd = new Commands($this);
        $this->getServer()->getCommandMap()->register("BravoClan", self::$cmd);
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
     * @param string $member
     * @return string
     */
    public function scorehudAddon(string $member)
    {
        if (self::$file->isInClan($member)) {
            strtolower($member);
            $dtb = Main::$db->prepare("SELECT clan FROM members WHERE member =:member;");
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
        if ($this->getConfig()->get("version") < 0.6){
            $this->getConfig()->set("version", 0.6);
            $w = ["DEFAULT"];
            $this->getConfig()->set("pvp-world", $w);
        }
    }

    public function addColour(string $string){
        /*
         * Some people lengthen the code here so a quick tip
         * STOP USING "$string = str_replace("&4", TextFormat::RED, $string);", stuff like this
         * I have seen this in some plugins so STOP.
         */
        $string = str_replace("&", TextFormat::ESCAPE, $string);
        return $string;
    }

    /**
     * @param Player $player
     * @return bool
     */
    public function inPvpWorld(Player $player):bool {
        $array = $this->getConfig()->get("pvp-world");
        if (empty($array)){
            return true;
        }
        if (in_array("DEFAULT", $array)){
            return true;
        }
        if (in_array($player->getLevel()->getName(), $array)){
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return Main|null
     */
    public static function getInstance(){
        return self::$instance;
    }
}