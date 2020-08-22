<?php

namespace Itzdvbravo\BravoClan;

use Itzdvbravo\BravoClan\Main;
use Itzdvbravo\BravoClan\Database;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;

class EventListener implements Listener{

    public function onChat(PlayerChatEvent $event){
        #Adding all the checks just incase the player gets kicked/leaves the clan.
        $player = $event->getPlayer();
        if (!array_key_exists(strtolower($player->getName()), Main::$clan->chat)) return;
        $msg = $event->getMessage();
        $event->setCancelled(true);
        $clan = Main::$file->getClan(Main::$clan->chat[strtolower($player->getName())]);
        $minfo = Main::$file->getMember(strtolower($player->getName()));
        if (!Main::$file->isInClan(strtolower($player->getName())) or $clan['clan'] !== $minfo['clan']){
            unset(Main::$clan->chat[strtolower($player->getName())]);
            return;
        }
        $members = Main::$file->clanMembers($clan['clan']);
        foreach ($members as $member) {
            if (Main::getInstance()->isOnline($member)) {
                $getm = Server::getInstance()->getPlayer($member);
                $rank = $clan['leader'] === strtolower($player->getName()) ? "leader" : "member";
                $getm->sendMessage("§o§e[{$clan['clan']}] §a[$rank] §5{$player->getName()} §a-> §e{$msg}");
            }
        }
    }

    public function onDamage(EntityDamageEvent $event){
        if ($event instanceof EntityDamageByEntityEvent){
            $player = $event->getEntity();
            $hitter = $event->getDamager();
            if ($player instanceof Player && $hitter instanceof Player){
                if (!Main::getInstance()->inPvpWorld($player)){
                    return;
                }
                if (Main::$file->isInClan(strtolower($player->getname())) && Main::$file->isInClan(strtolower($hitter->getname()))) {
                    if (Main::$clan->player[strtolower($player->getName())] === Main::$clan->player[strtolower($hitter->getName())]) {
                        $event->setCancelled(true);
                    }
                }
            }
        }
    }
    public function onJoin(PlayerJoinEvent $event){
        $player = $event->getPlayer();
        if (Main::$file->isInClan(strtolower($player->getname()))){
            $clan = Main::$file->getClan(Main::$file->getMember(strtolower($player->getName()))['clan']);
            Main::$clan->player[strtolower($player->getName())] = $clan["clan"];
        }
    }

    public function onLeave(PlayerQuitEvent $event){
        $player = $event->getPlayer();
        if (Main::$file->isInClan(strtolower($player->getname()))) {
            unset(Main::$clan->player[strtolower($player->getName())]);
        }
    }

    public function onKill(PlayerDeathEvent $event){
        $player = $event->getPlayer();
        if ($player instanceof Player) {
            if (!Main::getInstance()->inPvpWorld($player)){
                return;
            }
            $cause = $player->getLastDamageCause();
            if ($cause instanceof EntityDamageByEntityEvent) {
                $killer = $cause->getDamager();
                if ($killer instanceof Player) {
                    if (Main::$file->isInClan(strtolower($killer->getname()))) {
                        $clan = Main::$file->getClan(Main::$clan->player[strtolower($killer->getName())]);
                        Main::$clan->onClanMemberKill($clan, $killer);
                    }
                    if (Main::$file->isInClan(strtolower($player->getname()))) {
                        $clan = Main::$file->getClan(Main::$clan->player[strtolower($player->getName())]);
                        Main::$clan->onClanMemberDeath($clan, $player);
                    }
                }
            }
        }
    }
}
