<?php

namespace Itzdvbravo\BravoClan;

use Itzdvbravo\BravoClan\Main;
use Itzdvbravo\BravoClan\Database;
use pocketmine\Player;
use pocketmine\utils\Config;

class Clan{
    private $plugin;
    public $player = [];
    public $chat = [];


    public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }

    /**
     *@param $clan
     *@param Player $player
     */
    public function onClanMemberKill($clan, Player $player){
        $name = $clan['clan'];
        $lvl = $clan['lvl'];
        $nex = $clan['nex'];
        $xp = $clan['xp'];
        $kills = $clan['kills'];
        $maxtm = $clan["maxtm"];

        $cfg = new Config($this->plugin->getDataFolder()."config.yml", Config::YAML);
        $plusxp = $cfg->get("xp_onkill");

        Main::$file->setKills($name, $kills + 1);
        Main::$file->setMemberKills(strtolower($player->getName()), Main::$file->getMember(strtolower($player->getName()))["kills"] + 1);

        if ($xp + $plusxp > $nex){
            $lvl += 1;
            $xp += $plusxp - $nex;
            $nex += $cfg->get("xp_perlvl");
            $maxtm = $lvl % 5 === 0 ? $maxtm + 2 : $maxtm;
        } else {
            $xp += $plusxp;
        }
        Main::$file->setLevel($name, $lvl);
        Main::$file->setXp($name, $xp);
        Main::$file->setNex($name, $nex);
        Main::$file->setMaxTm($name, $maxtm);
        $cfg->save();
    }

    /**
     *@param $clan
     *@param Player $player
     */
    public function onClanMemberDeath($clan, Player $player){
        $name = $clan['clan'];
        $lvl = $clan['lvl'];
        $nex = $clan['nex'];
        $xp = $clan['xp'];
        $deaths = $clan['deaths'];

        $cfg = new Config($this->plugin->getDataFolder()."config.yml", Config::YAML);
        $minusxp = $cfg->get("xp_ondeath");

        Main::$file->setDeaths($name, $deaths + 1);
        Main::$file->setMemberDeaths(strtolower($player->getName()), Main::$file->getMember(strtolower($player->getName()))["deaths"] + 1);

        if ($xp === 0 && $lvl === 1) return;
        if ($xp - $minusxp < 0){
            if ($lvl === 1) {
                $xp = 0;
            } else {
                $lvl -= 1;
                $nex -= $cfg->get("xp_perlvl");
                $xp += $nex - $minusxp;
            }
        } else {
            $xp -= $minusxp;
        }
        Main::$file->setLevel($name, $lvl);
        Main::$file->setXp($name, $xp);
        Main::$file->setNex($name, $nex);
        $cfg->save();
    }
}