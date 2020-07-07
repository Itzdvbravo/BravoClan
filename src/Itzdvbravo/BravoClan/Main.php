<?php

namespace Itzdvbravo\BravoClan;

use Itzdvbravo\BravoClan\Commands\Commands;
use pocketmine\block\Fallable;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use SQLite3;

class Main extends PluginBase{
    public static $db;
    /** @var Database */
    public static $file;
    /** @var Clan */
    public static $clan;
    /** @var Commands */
    public static $cmd;
    /** @var Main|null*/
    public static $instance = null;
    /** @var Config */
    public $messages;

    public function onLoad(){
        self::$instance = $this;
        $this->saveDefaultConfig();
        $this->saveResource("messages.yml");
        $this->messages = new Config($this->getDataFolder()."messages.yml");
    }

    public function onEnable(){
        self::$db = new SQLite3($this->getDataFolder()."clans.db");
        self::$db->exec("CREATE TABLE IF NOT EXISTS clans(clan TEXT PRIMARY KEY COLLATE NOCASE, leader TEXT COLLATE NOCASE, level INT, xp INT, nex INT, kills INT, deaths INT, tm INT, maxtm INT)");
        self::$db->exec("CREATE TABLE IF NOT EXISTS members(clan TEXT COLLATE NOCASE, member PRIMARY KEY COLLATE NOCASE, kills INT, deaths INT)");
        self::$file = new Database();
        self::$clan = new Clan();
        self::$cmd = new Commands($this);
        $this->getServer()->getCommandMap()->register("BravoClan", self::$cmd);
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
        $this->cfgVersion();
    }

    /**
     * @param string $string
     * @return bool
     */
    public function isOnline(string $string):bool {
        $player = Server::getInstance()->getPlayer($string);
        return isset($player);
    }

    /**
     * @param string $member
     * @return string
     */
    public function scorehudAddon(string $member){
        if (self::$file->isInClan($member)) {
            strtolower($member);
            $clan = Main::$file->getMember($member)["clan"];
            return "$clan";
        } else {
            return "Clanless";
        }
    }

    private function cfgVersion(){
        if ($this->getConfig()->get("version") < 1.0){
            Server::getInstance()->getLogger()->critical("The config version isn't compatible");
            Server::getInstance()->getPluginManager()->disablePlugin($this);
        }
    }

    public function addColour(string $string){
        $string = str_replace("&", TextFormat::ESCAPE, $string);
        return $string;
    }

    /**
     * @param Player $player
     * @return bool
     */
    public function inPvpWorld(Player $player):bool {
        $array = $this->getConfig()->get("pvp-world");
        if (!isset($array)){
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