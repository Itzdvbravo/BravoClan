<?php

namespace Itzdvbravo\BravoClan;

use Itzdvbravo\BravoClan\Main;

use pocketmine\Player;
use pocketmine\utils\Config;

class Database{
    private $plugin;

    public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }

    /**
     * @param string $clan
     * @param $leader
     */
    public function setClan(string $clan, string $leader){
        $leader = strtolower($leader);
        $cfg = new Config($this->plugin->getDataFolder()."config.yml");
        $dtb = Main::$db->prepare("INSERT OR REPLACE INTO clans (clan, leader, level, xp, nex, kills, deaths, tm, maxtm) VALUES (:clan, :leader, :level, :xp, :nex, :kills, :deaths, :tm, :maxtm)");
        $dtb->bindValue(":clan", $clan, SQLITE3_TEXT);
        $dtb->bindValue(":leader", $leader, SQLITE3_TEXT);
        $dtb->bindvalue(":level", 1, SQLITE3_INTEGER);
        $dtb->bindvalue(":xp", 0, SQLITE3_INTEGER);
        $dtb->bindvalue(":nex", $cfg->get("lvl_2_xp"), SQLITE3_INTEGER);
        $dtb->bindvalue(":kills", 0, SQLITE3_INTEGER);
        $dtb->bindvalue(":deaths", 0, SQLITE3_INTEGER);
        $dtb->bindvalue(":tm", 0, SQLITE3_INTEGER);
        $dtb->bindValue(":maxtm", $cfg->get("starting_member_limit"), SQLITE3_INTEGER);
        $dtb->execute();
        $dtb->close();
        $cfg->save();
        $this->setMember($clan, $leader);
    }

    /**
     * @param string $clan
     * @return array
     */
    public function getClan(string $clan){
        $dtb = Main::$db->prepare("SELECT * FROM clans WHERE clan =:clan;");
        $dtb->bindValue(":clan", $clan);
        $end = $dtb->execute();
        $array = $end->fetchArray(SQLITE3_ASSOC);
        $dtb->close();
        return $array;
    }

    /**
     * @param string $clan
     */
    public function removeClan(string $clan){
        $dtb = Main::$db->prepare("DELETE FROM clans WHERE clan=:clan;");
        $dtb->bindValue(":clan", $clan);
        $dtb->execute();
        $dtb->close();
        $dtb = Main::$db->prepare("DELETE FROM members WHERE clan=:clan;");
        $dtb->bindValue(":clan", $clan);
        $dtb->execute();
        $dtb->close();
    }

    /**
     * @param string $clan
     * @param string $member
     */
    public function setMember(string $clan, string $member){
        strtolower($member);
        $dtb = Main::$db->prepare("INSERT OR REPLACE INTO members (clan, member, kills, deaths) VALUES (:clan, :member, :kills, :deaths)");
        $dtb->bindValue(":clan", $clan, SQLITE3_TEXT);
        $dtb->bindValue(":member", $member, SQLITE3_TEXT);
        $dtb->bindValue(":kills", 0, SQLITE3_INTEGER);
        $dtb->bindValue(":deaths", 0, SQLITE3_INTEGER);
        $dtb->execute();
        $dtb->close();
    }

    /**
     * @param string $member
     * @return array
     */
    public function getMember(string $member){
        strtolower($member);
        $dtb = Main::$db->prepare("SELECT * FROM members WHERE member =:member;");
        $dtb->bindValue(":member", $member);
        $end = $dtb->execute();
        $array = $end->fetchArray(SQLITE3_ASSOC);
        $dtb->close();
        return $array;
    }

    /**
     * @param string $member
     */
    public function removeMember(string $member){
        strtolower($member);
        $dtb = Main::$db->prepare("DELETE FROM members WHERE member=:member;");
        $dtb->bindValue(":member", $member);
        $dtb->execute();
        $dtb->close();
    }

    /**
     * @param string $clan
     * @param int $level
     */
    public function setLevel(string $clan, int $level){
        $dtb = Main::$db->prepare("UPDATE clans SET level=:level WHERE clan=:clan;");
        $dtb->bindValue(":clan", $clan);
        $dtb->bindValue(":level", $level);
        $dtb->execute();
        $dtb->close();
    }

    /**
     * @param string $clan
     * @param int $xp
     */
    public function setXp(string $clan, int $xp){
        $dtb = Main::$db->prepare("UPDATE clans SET xp=:xp WHERE clan=:clan;");
        $dtb->bindValue(":clan", $clan);
        $dtb->bindValue(":xp", $xp);
        $dtb->execute();
        $dtb->close();
    }

    /**
     * @param string $clan
     * @param int $nex
     */
    public function setNex(string $clan, int $nex){
        $dtb = Main::$db->prepare("UPDATE clans SET nex=:nex WHERE clan=:clan;");
        $dtb->bindValue(":clan", $clan);
        $dtb->bindValue(":nex", $nex);
        $dtb->execute();
        $dtb->close();
    }

    /**
     * @param string $clan
     * @param int $kills
     */
    public function setKills(string $clan, int $kills){
        $dtb = Main::$db->prepare("UPDATE clans SET kills=:kills WHERE clan=:clan;");
        $dtb->bindValue(":clan", $clan);
        $dtb->bindValue(":kills", $kills);
        $dtb->execute();
        $dtb->close();
    }

    /**
     * @param string $clan
     * @param int $deaths
     */
    public function setDeaths(string $clan, int $deaths){
        $dtb = Main::$db->prepare("UPDATE clans SET deaths=:deaths WHERE clan=:clan;");
        $dtb->bindValue(":clan", $clan);
        $dtb->bindValue(":deaths", $deaths);
        $dtb->execute();
        $dtb->close();
    }

    /**
     * @param string $clan
     * @param int $tm
     */
    public function setTm(string $clan, int $tm){
        $dtb = Main::$db->prepare("UPDATE clans SET tm=:tm WHERE clan=:clan;");
        $dtb->bindValue(":clan", $clan);
        $dtb->bindValue(":tm", $tm);
        $dtb->execute();
        $dtb->close();
    }

    /**
     * @param string $clan
     * @param int $maxtm
     */
    public function setMaxTm(string $clan, int $maxtm){
        $dtb = Main::$db->prepare("UPDATE clans SET maxtm=:maxtm WHERE clan=:clan;");
        $dtb->bindValue(":clan", $clan);
        $dtb->bindValue(":maxtm", $maxtm);
        $dtb->execute();
        $dtb->close();
    }

    /**
     * @param string $member
     * @param int $kills
     */
    public function setMemberKills(string $member, int $kills){
        $member = strtolower($member);
        $dtb = Main::$db->prepare("UPDATE members SET kills=:kills WHERE member=:member;");
        $dtb->bindValue(":member", $member);
        $dtb->bindValue(":kills", $kills);
        $dtb->execute();
        $dtb->close();
    }

    /**
     * @param string $member
     * @param int $deaths
     */
    public function setMemberDeaths(string $member, int $deaths){
        $member = strtolower($member);
        $dtb = Main::$db->prepare("UPDATE members SET deaths=:deaths WHERE member=:member;");
        $dtb->bindValue(":member", $member);
        $dtb->bindValue(":deaths", $deaths);
        $dtb->execute();
        $dtb->close();
    }

    /**
     * @param string $clan
     * @return bool
     */
    public function clanExist(string $clan):bool {
        $result = Main::$db->prepare("SELECT clan FROM clans WHERE clan =:clan;");
        $result->bindValue(":clan", $clan, SQLITE3_TEXT);
        $end = $result->execute();
        $array = $end->fetchArray(SQLITE3_ASSOC);
        $result->close();
        if (empty($array)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @param string $clan
     * @return mixed
     */
    public function clanMembers(string $clan){
        $tw = Main::$db->query("SELECT * FROM members WHERE clan ='$clan';");
        while ($resultAr = $tw->fetchArray(SQLITE3_ASSOC)) {
            $data[] = "{$resultAr['member']}";
        }
        return $data;
    }

    /**
     * @param string $player
     * @return bool
     */
    public function isInClan(string $player):bool {
        $result = Main::$db->prepare("SELECT member FROM members WHERE member =:member;");
        $result->bindValue(":member", $player, SQLITE3_TEXT);
        $end = $result->execute();
        $array = $end->fetchArray(SQLITE3_ASSOC);
        $result->close();
        if (empty($array)) {
            return false;
        } else {
            return true;
        }
    }
}