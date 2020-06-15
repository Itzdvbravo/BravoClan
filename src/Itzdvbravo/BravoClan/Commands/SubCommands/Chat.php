<?php


namespace Itzdvbravo\BravoClan\Commands\SubCommands;


use Itzdvbravo\BravoClan\Main;
use pocketmine\command\CommandSender;

class Chat implements Sub{
    private $plugin;

    public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }

    /**
     * @inheritDoc
     */
    public function executeSub(CommandSender $player, array $args, string $name){
        if (!Main::$file->isInClan(strtolower($player->getName()))){
            $player->sendMessage(Main::getInstance()->addColour(Main::getInstance()->messages->get("not-in-clan")));
        } else {
            if (array_key_exists(strtolower($player->getName()), Main::$clan->chat)){
                unset(Main::$clan->chat[strtolower($player->getName())]);
                $player->sendMessage("§eYou have left the clan chat");
            } else {
                $clan = Main::$file->getMember(strtolower($player->getName()))['clan'];
                Main::$clan->chat[strtolower($player->getName())] = $clan;
                $player->sendMessage("§aYou have joined the clan chat");
            }
        }
    }
}