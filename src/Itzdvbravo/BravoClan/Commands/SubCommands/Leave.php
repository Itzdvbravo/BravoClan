<?php


namespace Itzdvbravo\BravoClan\Commands\SubCommands;


use Itzdvbravo\BravoClan\Main;
use pocketmine\command\CommandSender;

class Leave implements Sub{
    private $plugin;

    public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }

    public function getName(): string
    {
        return "leave";
    }

    /**
     * @inheritDoc
     */
    public function executeSub(CommandSender $player, array $args, string $name){
        if (!Main::$file->isInClan(strtolower($player->getName()))) {
            $player->sendMessage(Main::getInstance()->addColour(Main::getInstance()->messages->get("not-in-clan")));
        }  elseif (Main::$file->getClan(Main::$file->getMember(strtolower($player->getName()))["clan"])["leader"] === strtolower($player->getName())){
            $player->sendMessage("§eYou cannot leave your clan, as you are the leader, do /clan delete to delete");
        } else {
            $clan = Main::$file->getClan(Main::$file->getMember(strtolower($player->getName()))["clan"]);
            $member = Main::$file->getMember($player->getName());
            Main::$file->removeMember($player->getName());
            Main::$file->setKills($clan["clan"], $clan["kills"] - $member["kills"]);
            Main::$file->setDeaths($clan["clan"], $clan["deaths"] - $member["deaths"]);
            Main::$file->setTm($clan['clan'], $clan['tm'] - 1);
            unset(Main::$clan->player[strtolower($player->getName())]);
            $player->sendMessage("§eLeft the clan");
        }
    }
}