<?php


namespace Itzdvbravo\BravoClan\Commands\SubCommands;


use Itzdvbravo\BravoClan\Main;
use pocketmine\command\CommandSender;

class Top implements Sub{
    private $plugin;

    public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }

    public function getName(): string
    {
        return "top";
    }

    /**
     * @inheritDoc
     */
    public function executeSub(CommandSender $player, array $args, string $name){
        $top = Main::$db->query("SELECT clan FROM clans ORDER BY level DESC LIMIT 10");
        $counter = 0;
        $player->sendMessage("§e+=TOP 10 Gangs=+");
        while ($resultAr = $top->fetchArray(SQLITE3_ASSOC)) {
            $counter += 1;
            $clan = Main::$file->getClan($resultAr['clan']);
            $player->sendMessage("§e{$counter} -> {$clan['clan']} with {$clan['lvl']} Level §6{$clan['xp']}/{$clan['nex']}");
        }
    }
}