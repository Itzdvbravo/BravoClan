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
    public function onClanMemberKill($clan, Player $player){
        $name = $clan['clan'];
        $lvl = $clan['lvl'];
        $nex = $clan['nex'];
        $xp = $clan['xp'];
        $kills = $clan['kills'];
        $cfg = new Config($this->plugin->getDataFolder()."config.yml", Config::YAML);
        $plusxp = $cfg->get("xp_onkill");
        if ($xp + $plusxp > $nex){
            $newlvl = $lvl + 1;
            $newxp = $xp + $plusxp - $nex;
            $nnex = $nex + $cfg->get("xp_perlvl");
            Main::$file->setLevel($name, $newlvl);
            Main::$file->setXp($name, $newxp);
            Main::$file->setNex($name, $nnex);
        } else{
            $newxp = $xp + $plusxp;
            Main::$file->setXp($name, $newxp);
        }
        Main::$file->setKills($name, $kills + 1);
        $mkill = Main::$file->getMember(strtolower($player->getName()))["kills"] + 1;
        Main::$file->setMemberKills(strtolower($player->getName()), $mkill);
        $cfg->save();
    }
    public function onClanMemberDeath($clan, Player $player){
        $name = $clan['clan'];
        $lvl = $clan['lvl'];
        $nex = $clan['nex'];
        $xp = $clan['xp'];
        $deaths = $clan['deaths'];
        $mxtm = $clan['maxtm'];
        $cfg = new Config($this->plugin->getDataFolder()."config.yml", Config::YAML);
        $minusxp = $cfg->get("xp_ondeath");
        Main::$file->setDeaths($name, $deaths + 1);
        $mdeaths = Main::$file->getMember(strtolower($player->getName()))["deaths"] + 1;
        Main::$file->setMemberDeaths(strtolower($player->getName()), $mdeaths);
        if ($xp === 0 && $lvl === 1){
            return;
        } elseif($xp - $minusxp < 0) {
            if ($lvl === 1){
                $newxp = 0;
                Main::$file->setXp($name, $newxp);
            } else {
                $newlvl = $lvl + 1;
                $nnex = $nex - $cfg->get("xp_perlvl");
                $newxp = $nnex + $xp - $minusxp;

                Main::$file->setLevel($name, $newlvl);
                Main::$file->setXp($name, $newxp);
                Main::$file->setNex($name, $nnex);
                if ($newlvl % 5 === 0) {
                    $newmt = $mxtm + 2;
                    Main::$file->setMaxTm($name, $newmt);
                }
            }
        } else {
            $newxp = $xp - $minusxp;
            Main::$file->setXp($name, $newxp);
        }
        $cfg->save();
    }
}