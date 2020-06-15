<?php


namespace Itzdvbravo\BravoClan\Commands\SubCommands;


use Itzdvbravo\BravoClan\Main;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class Create implements Sub{
    private $plugin;

    public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }

    /**
     * @inheritDoc
     */
    public function executeSub(CommandSender $player, array $args, string $name){
        if (!$player instanceof Player){
            $player->sendMessage(TextFormat::RED."Please use this command in game");
            return;
        }
        if (Main::$file->isInClan(strtolower($player->getName()))){
            $player->sendMessage(Main::getInstance()->addColour(Main::getInstance()->messages->get("not-in-clan")));
        } else {
            if (empty($args[1])){
                $player->sendMessage("§eProvide Clan Name");
            } elseif (!ctype_alpha("{$args[1]}")){
                $player->sendMessage("§4Clan name is invalid, it should contain letters only");
            }else{
                if (Main::$file->clanExist($args[1])){
                    $player->sendMessage("§4Clan name already exists");
                } elseif (strlen($args[1]) > 13){
                    $player->sendMessage("§eclan name can't be longer than 13 characters");
                } else {
                    Main::$file->setClan($args[1], $player->getName());
                    Main::$clan->player[strtolower($player->getName())] = $args[1];
                    $player->sendMessage("§aClan have been created, do /clan info");
                }
            }
        }
    }
}