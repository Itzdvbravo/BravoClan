<?php


namespace Itzdvbravo\BravoClan\Commands\SubCommands;


use Itzdvbravo\BravoClan\Main;
use pocketmine\command\CommandSender;

class Accept implements Sub{
    private $plugin;

    public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }

    public function getName(): string
    {
        return "accept";
    }

    /**
     * @inheritDoc
     */
    public function executeSub(CommandSender $player, array $args, string $name){
        if (Main::$file->isInClan(strtolower($player->getName()))) {
            $player->sendMessage(Main::getInstance()->addColour(Main::getInstance()->messages->get("already-in-clan")));
        } elseif (!array_key_exists(strtolower($player->getName()), Main::$cmd->invite)){
            $player->sendMessage(Main::getInstance()->addColour(Main::getInstance()->messages->get("no-invites")));
        } else {
            if (Main::$cmd->invite[strtolower($player->getName())][0] + 30 <= time()){
                $player->sendMessage(Main::getInstance()->addColour(Main::getInstance()->messages->get("invitation-expired")));
                unset(Main::$cmd->invite[strtolower($player->getName())]);
            } else {
                $clan = Main::$file->getClan(Main::$cmd->invite[strtolower($player->getName())][1]);
                if ($clan["tm"] > $clan["maxtm"]) {
                    $player->sendMessage(Main::getInstance()->addColour(Main::getInstance()->messages->get("accept-but-no-space")));
                } else {
                    Main::$file->setMember($clan["clan"], $player->getName());
                    Main::$file->setTm($clan["clan"], $clan["tm"] + 1);
                    Main::$clan->player[strtolower($player->getName())] = $clan["clan"];
                    $player->sendMessage("§eYou have joined {$clan['clan']}\n§aLeader §f- §e{$clan['leader']} §aTotal Members §f- §e{$clan['tm']}");
                }
            }
        }
    }
}