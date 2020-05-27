<?php

namespace Itzdvbravo\BravoClan;

use Itzdvbravo\BravoClan\Main;

use pocketmine\Player;

class Database{
    private $plugin;

    public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }
    public function setClan($clan, $leader){
        $leader = strtolower($leader);
        $dtb = Main::$db->prepare("INSERT OR REPLACE INTO clans (clan, leader, level, xp, nex, kills, deaths, tm, maxtm) VALUES (:clan, :leader, :level, :xp, :nex, :kills, :deaths, :tm, :maxtm)");
        $dtb->bindValue(":clan", $clan, SQLITE3_TEXT);
        $dtb->bindValue(":leader", $leader, SQLITE3_TEXT);
        $dtb->bindvalue(":level", 1, SQLITE3_INTEGER);
        $dtb->bindvalue(":xp", 0, SQLITE3_INTEGER);
        $dtb->bindvalue(":nex", 100, SQLITE3_INTEGER);
        $dtb->bindvalue(":kills", 0, SQLITE3_INTEGER);
        $dtb->bindvalue(":deaths", 0, SQLITE3_INTEGER);
        $dtb->bindvalue(":tm", 0, SQLITE3_INTEGER);
        $dtb->bindValue(":maxtm", 2, SQLITE3_INTEGER);
        $dtb->execute();
        $dtb->close();
        $this->setMember($clan, $leader);
    }
    public function getClan($clan){
        $dtb = Main::$db->prepare("SELECT * FROM clans WHERE clan =:clan;");
        $dtb->bindValue(":clan", $clan);
        $end = $dtb->execute();
        $array = $end->fetchArray(SQLITE3_ASSOC);
        $clan = $array["clan"];
        $leader = $array["leader"];
        $lvl = $array["level"];
        $xp = $array["xp"];
        $nex = $array["nex"];
        $kills = $array["kills"];
        $deaths = $array["deaths"];
        $tm = $array["tm"];
        $maxtm = $array["maxtm"];
        $dtb->close();
        return array("clan" => $clan, "leader" => $leader, "lvl" => $lvl, "xp" => $xp,
            "nex" => $nex, "kills" => $kills, "deaths" => $deaths, "tm" => $tm, "maxtm" => $maxtm);
    }
    public function removeClan($clan){
        $dtb = Main::$db->prepare("DELETE FROM clans WHERE clan=:clan;");
        $dtb->bindValue(":clan", $clan);
        $dtb->execute();
        $dtb->close();
        $dtb = Main::$db->prepare("DELETE FROM members WHERE clan=:clan;");
        $dtb->bindValue(":clan", $clan);
        $dtb->execute();
        $dtb->close();
    }
    public function setMember($clan, $member){
        strtolower($member);
        $dtb = Main::$db->prepare("INSERT OR REPLACE INTO members (clan, member, kills, deaths) VALUES (:clan, :member, :kills, :deaths)");
        $dtb->bindValue(":clan", $clan, SQLITE3_TEXT);
        $dtb->bindValue(":member", $member, SQLITE3_TEXT);
        $dtb->bindValue(":kills", 0, SQLITE3_INTEGER);
        $dtb->bindValue(":deaths", 0, SQLITE3_INTEGER);
        $dtb->execute();
        $dtb->close();
    }
    public function getMember($member){
        strtolower($member);
        $dtb = Main::$db->prepare("SELECT * FROM members WHERE member =:member;");
        $dtb->bindValue(":member", $member);
        $end = $dtb->execute();
        $array = $end->fetchArray(SQLITE3_ASSOC);
        $clan = $array["clan"];
        $kills = $array["kills"];
        $deaths = $array["deaths"];
        $dtb->close();
        return array("clan" => $clan, "kills" => $kills, "deaths" => $deaths);
    }
    public function removeMember($member){
        strtolower($member);
        $dtb = Main::$db->prepare("DELETE FROM members WHERE member=:member;");
        $dtb->bindValue(":member", $member);
        $dtb->execute();
        $dtb->close();
    }
    public function setLevel($clan, $level){
        $dtb = Main::$db->prepare("UPDATE clans SET level=:level WHERE clan=:clan;");
        $dtb->bindValue(":clan", $clan);
        $dtb->bindValue(":level", $level);
        $dtb->execute();
        $dtb->close();
    }
    public function setXp($clan, $xp){
        $dtb = Main::$db->prepare("UPDATE clans SET xp=:xp WHERE clan=:clan;");
        $dtb->bindValue(":clan", $clan);
        $dtb->bindValue(":xp", $xp);
        $dtb->execute();
        $dtb->close();
    }
    public function setNex($clan, $nex){
        $dtb = Main::$db->prepare("UPDATE clans SET nex=:nex WHERE clan=:clan;");
        $dtb->bindValue(":clan", $clan);
        $dtb->bindValue(":nex", $nex);
        $dtb->execute();
        $dtb->close();
    }
    public function setKills($clan, $kills){
        $dtb = Main::$db->prepare("UPDATE clans SET kills=:kills WHERE clan=:clan;");
        $dtb->bindValue(":clan", $clan);
        $dtb->bindValue(":kills", $kills);
        $dtb->execute();
        $dtb->close();
    }
    public function setDeaths($clan, $deaths){
        $dtb = Main::$db->prepare("UPDATE clans SET deaths=:deaths WHERE clan=:clan;");
        $dtb->bindValue(":clan", $clan);
        $dtb->bindValue(":deaths", $deaths);
        $dtb->execute();
        $dtb->close();
    }
    public function setTm($clan, $tm){
        $dtb = Main::$db->prepare("UPDATE clans SET tm=:tm WHERE clan=:clan;");
        $dtb->bindValue(":clan", $clan);
        $dtb->bindValue(":tm", $tm);
        $dtb->execute();
        $dtb->close();
    }
    public function setMaxTm($clan, $maxtm){
        $dtb = Main::$db->prepare("UPDATE clans SET maxtm=:maxtm WHERE clan=:clan;");
        $dtb->bindValue(":clan", $clan);
        $dtb->bindValue(":maxtm", $maxtm);
        $dtb->execute();
        $dtb->close();
    }
    public function setMemberKills($member, $kills){
        $member = strtolower($member);
        $dtb = Main::$db->prepare("UPDATE members SET kills=:kills WHERE member=:member;");
        $dtb->bindValue(":member", $member);
        $dtb->bindValue(":kills", $kills);
        $dtb->execute();
        $dtb->close();
    }
    public function setMemberDeaths($member, $deaths){
        $member = strtolower($member);
        $dtb = Main::$db->prepare("UPDATE members SET deaths=:deaths WHERE member=:member;");
        $dtb->bindValue(":member", $member);
        $dtb->bindValue(":deaths", $deaths);
        $dtb->execute();
        $dtb->close();
    }
    public function getMembersByClan($clan){
        $tw = Main::$db->query("SELECT * FROM members WHERE clan ='$clan';");
        $counter = 0;
        while ($resultAr = $tw->fetchArray(SQLITE3_ASSOC)) {
            if ($this->getClan($clan)["tm"] === 0){
                return Null;
            } else {
                $member = $resultAr['member'];
                $data[] = "$member";
            }
        }
        return $data;
    }
    public function clanExist($clan):bool {
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
    public function clanMembers($clan){
        $tw = Main::$db->query("SELECT * FROM members WHERE clan ='$clan';");
        while ($resultAr = $tw->fetchArray(SQLITE3_ASSOC)) {
            $data[] = "{$resultAr['member']}";
        }
        return $data;
    }
    public function isInClan($player):bool {
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