<?php


namespace Itzdvbravo\BravoClan\Commands\SubCommands;


use Itzdvbravo\BravoClan\Main;
use pocketmine\command\CommandSender;

class Delete implements Sub{
    private $plugin;

    public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }

    public function getName(): string
    {
        return "delete";
    }

    /**
     * @inheritDoc
     */
    public function executeSub(CommandSender $player, array $args, string $name){
        if (!Main::$file->isInClan(strtolower($player->getName()))) {
            $player->sendMessage(Main::getInstance()->addColour(Main::getInstance()->messages->get("not-in-clan")));
        } elseif (Main::$file->getClan(Main::$clan->player[strtolower($player->getName())])["leader"] !== strtolower($player->getName())){
            $player->sendMessage(Main::getInstance()->addColour(Main::getInstance()->messages->get("not-leader")));
        } else {
            $clan = Main::$file->getClan(Main::$clan->player[strtolower($player->getName())]);
            Main::$file->removeClan($clan['clan']);
            $player->sendMessage("§4Your clan have been deleted");
        }
    }
}