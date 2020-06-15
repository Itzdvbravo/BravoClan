<?php


namespace Itzdvbravo\BravoClan\Commands\SubCommands;


use Itzdvbravo\BravoClan\Main;
use pocketmine\command\CommandSender;

class Help implements Sub{
    private $plugin;

    public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }

    /**
     * @inheritDoc
     */
    public function executeSub(CommandSender $player, array $args, string $name){
        $player->sendMessage("§e/clan create - create clan");
        $player->sendMessage("§e/clan invite - invite players to clan");
        $player->sendMessage("§e/clan accept - accept clan invitation");
        $player->sendMessage("§e/clan kick - kick players from clan");
        $player->sendMessage("§e/clan leave - leave your clan");
        $player->sendMessage("§e/clan delete - delete your clan");
        $player->sendMessage("§e/clan info - get clan info of your or other clans");
        $player->sendMessage("§e/clan members - get members info from your clan/other's clan");
        $player->sendMessage("§e/clan chat - join clan chat");
        $player->sendMessage("§e/clan top - get top 10 clans");
    }
}