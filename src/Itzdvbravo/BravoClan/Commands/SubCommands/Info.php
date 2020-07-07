<?php

namespace Itzdvbravo\BravoClan\Commands\SubCommands;


use Itzdvbravo\BravoClan\Main;
use pocketmine\command\CommandSender;

class Info implements Sub{
    private $plugin;

    public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }

    public function getName(): string
    {
        return "info";
    }

    /**
     * @inheritDoc
     */
    public function executeSub(CommandSender $player, array $args, string $name){
        if (empty($args[1])){
            if (!Main::$file->isInClan(strtolower($player->getName()))) {
                $player->sendMessage("§eYou aren't in a clan, you can provide a clan to get info of");
                return;
            } else {
                $clan = Main::$file->getClan(Main::$clan->player[strtolower($player->getName())]);
            }
        } else {
            if (!Main::$file->clanExist($args[1])){
                $player->sendMessage("§eClan not found");
                return;
            } else {
                $clan = Main::$file->getClan($args[1]);
            }
        }
        $player->sendMessage("§e<<<<<<<<<<<<<<<{$clan['clan']}>>>>>>>>>>>>>>");
        $player->sendMessage("§eLeader: {$clan['leader']}");
        $player->sendMessage("§eMembers: {$clan['tm']}/{$clan['maxtm']}");
        $player->sendMessage("§eLevel: {$clan['lvl']}");
        $player->sendMessage("§eXP: {$clan['xp']}/{$clan['nex']}");
        $player->sendMessage("§eKDR: {$clan['kills']}/{$clan['deaths']}");
        $player->sendMessage("§e--------------------------------------------");
    }
}