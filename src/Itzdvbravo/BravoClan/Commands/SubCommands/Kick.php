<?php


namespace Itzdvbravo\BravoClan\Commands\SubCommands;


use Itzdvbravo\BravoClan\Main;
use pocketmine\command\CommandSender;

class Kick implements Sub{
    private $plugin;

    public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }

    public function getName(): string
    {
        return "kick";
    }

    /**
     * @inheritDoc
     */
    public function executeSub(CommandSender $player, array $args, string $name){
        if (!Main::$file->isInClan(strtolower($player->getName()))) {
            $player->sendMessage(Main::getInstance()->addColour(Main::getInstance()->messages->get("not-in-clan")));
        }  elseif (Main::$file->getClan(Main::$clan->player[strtolower($player->getName())])["leader"] !== strtolower($player->getName())){
            $player->sendMessage(Main::getInstance()->addColour(Main::getInstance()->messages->get("not-leader")));
        } else {
            if (empty($args[1])){
                $player->sendMessage("§eProvide a player to kick");
            } elseif(strtolower($args[1]) === strtolower($player->getName())) {
                $player->sendMessage("§eYou can't kick yourself");
            }else {
                if (Main::$file->isInClan(strtolower($args[1]))){
                    if (Main::$file->getMember(strtolower($args[1]))['clan'] !== Main::$file->getClan
                        (Main::$clan->player[strtolower($player->getName())])){
                        $player->sendMessage("§eThat player isn't in your clan");
                    } else {
                        $clan = Main::$file->getClan(Main::$file->getMember(strtolower($args[1]))["clan"]);
                        $member = Main::$file->getMember(strtolower($args[1]));
                        Main::$file->setKills($clan["clan"], $clan["kills"] - $member["kills"]);
                        Main::$file->setDeaths($clan["clan"], $clan["deaths"] - $member["deaths"]);
                        Main::$file->removeMember(strtolower($args[1]));
                        Main::$file->setTm($clan['clan'], $clan['tm'] - 1);
                        if ($this->plugin->isOnline($args[1])){
                            unset(Main::$clan->player[strtolower($args[1])]);
                        }
                        $player->sendMessage("§eThat player have been removed");
                    }
                } else {
                    $player->sendMessage("§eThat player isn't in any gang");
                }
            }
        }
    }
}