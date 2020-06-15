<?php


namespace Itzdvbravo\BravoClan\Commands\SubCommands;


use Itzdvbravo\BravoClan\Main;
use pocketmine\command\CommandSender;
use pocketmine\Server;

class Invite implements Sub{
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
        } elseif (Main::$file->getClan(Main::$clan->player[strtolower($player->getName())])["leader"] !== strtolower($player->getName())){
            $player->sendMessage(Main::getInstance()->addColour(Main::getInstance()->messages->get("not-leader")));
        } else {
            if (empty($args[1])){
                $player->sendMessage("§4Provide a player to invite");
            } elseif (!$this->plugin->isOnline($args[1])){
                $player->sendMessage("§ePlayer not found");
            } else {
                $person = Server::getInstance()->getPlayer($args[1]);
                if (Main::$file->isInClan(strtolower($person->getName()))){
                    $player->sendMessage("§eThat player is already in a clan");
                } elseif (Main::$file->getClan(Main::$clan->player[strtolower($player->getName())])["tm"] >
                    Main::$file->getClan(Main::$clan->player[strtolower($player->getName())])["maxtm"]){
                    $player->sendMessage("§4You can't add more ppl in the clan, levelup to get more space");
                } else {
                    if (array_key_exists("{$person->getName()}", Main::$cmd->invite)){
                        if (Main::$cmd->invite[strtolower($person->getName())][0] + 30 <= time()){
                            unset(Main::$cmd->invite[strtolower($person->getName())]);
                        } else {
                            $time = Main::$cmd->invite[strtolower($person->getName())][0] + 30 - time();
                            $player->sendMessage("§eYou can invite {$person->getName()} after {$time} seconds");
                            return;
                        }
                    }
                    $clan = Main::$file->getClan(Main::$clan->player[strtolower($player->getName())])["clan"];
                    $person->sendMessage("§eYou have been invited to {$clan} by {$player->getName()}, Do /clan accept,will last for 30 seconds");
                    Main::$cmd->invite[strtolower($person->getName())] = [time(), $clan];
                    $player->sendMessage("§e{$person->getName()} has been invited, you can invite him again after 30 seconds");
                }
            }
        }
    }
}