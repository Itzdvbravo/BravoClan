<?php


namespace Itzdvbravo\BravoClan\Commands\SubCommands;


use Itzdvbravo\BravoClan\Main;
use pocketmine\command\CommandSender;

class Members implements Sub{
    private $plugin;

    public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }

    public function getName(): string
    {
        return "members";
    }

    /**
     * @inheritDoc
     */
    public function executeSub(CommandSender $player, array $args, string $name){
        if (empty($args[1])) {
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
        $m = Main::$file->clanMembers($clan['clan']);
        foreach ($m as $person){
            $info = Main::$file->getMember($person);
            if ($this->plugin->isOnline($person)){
                $player->sendMessage("§e{$person} [{$info['kills']}/{$info['deaths']}] [§aON§e]");
            } else {
                $player->sendMessage("§e{$person} [{$info['kills']}/{$info['deaths']}] [§4OFF§e]");
            }
        }
    }
}