<?php

namespace Itzdvbravo\BravoClan\Commands;

use Itzdvbravo\BravoClan\Commands\SubCommands\Accept;
use Itzdvbravo\BravoClan\Commands\SubCommands\Chat;
use Itzdvbravo\BravoClan\Commands\SubCommands\Create;
use Itzdvbravo\BravoClan\Commands\SubCommands\Delete;
use Itzdvbravo\BravoClan\Commands\SubCommands\Help;
use Itzdvbravo\BravoClan\Commands\SubCommands\Info;
use Itzdvbravo\BravoClan\Commands\SubCommands\Invite;
use Itzdvbravo\BravoClan\Commands\SubCommands\Kick;
use Itzdvbravo\BravoClan\Commands\SubCommands\Leave;
use Itzdvbravo\BravoClan\Commands\SubCommands\Members;
use Itzdvbravo\BravoClan\Commands\SubCommands\Sub;
use Itzdvbravo\BravoClan\Commands\SubCommands\Top;
use Itzdvbravo\BravoClan\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class Commands extends Command implements PluginIdentifiableCommand {

    /** @var Main  */
    private $plugin;
    /** @var Sub[] */
    public $commands = [];
    public $invite = [];

    public function __construct(Main $plugin){
        parent::__construct("clan", "Clan Commands");
        $this->plugin = $plugin;
        $this->registerAllSubCommands();
    }

    /**
     * @param CommandSender $player
     * @param string $label
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $player, string $label, array $args):bool {
        #For whoever is reviewing this plugin (poggit mods), using commands through console won't break anything
        #Checks if the name (player name) is in a clan, console can't create clans or accept invites.
        if (!isset($args[0])){
            $player->sendMessage(TextFormat::RED . "/clan help");
            return true;
        }

        if(isset($this->commands[strtolower($args[0])])){
            $sub = $this->commands[strtolower($args[0])];
            $sub->executeSub($player, $args, $sub->getName());
        } else {
            $player->sendMessage(TextFormat::RED . "Unknown clan command do /clan help");
        }


        return true;
    }

    public function registerAllSubCommands(){
        $this->registerSubCommand(new Create($this->plugin));
        $this->registerSubCommand(new Invite($this->plugin));
        $this->registerSubCommand(new Accept($this->plugin));
        $this->registerSubCommand(new Kick($this->plugin));
        $this->registerSubCommand(new Leave($this->plugin));
        $this->registerSubCommand(new Members($this->plugin));
        $this->registerSubCommand(new Delete($this->plugin));
        $this->registerSubCommand(new Info($this->plugin));
        $this->registerSubCommand(new Chat($this->plugin));
        $this->registerSubCommand(new Top($this->plugin));
        $this->registerSubCommand(new Help($this->plugin));
    }

    public function registerSubCommand(Sub $sub): void
    {
        $this->commands[$sub->getName()] = $sub;
    }

    /**
     * @return Plugin
     */
    public function getPlugin(): Plugin{
        return $this->plugin;
    }
}
