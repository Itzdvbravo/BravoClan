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
    private $plugin;
    public $commands = [];
    public $invite = [];

    public function __construct(Main $plugin){
        parent::__construct("clan", "Clan Commands");
        $this->plugin = $plugin;
        $this->registerCMD();
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
        if (empty($args[0])){
            $player->sendMessage(TextFormat::RED."/clan help");
            return true;
        }
        switch ($args[0]){
            #Array are the same (No array_shift($args) or something like that so don't get confused)
            default:
                $player->sendMessage(TextFormat::RED."Unknown clan command do /clan help");
                break;
            case "create":
                $this->commands["create"]->executeSub($player, $args, "create");
                break;
            case "invite":
                $this->commands["invite"]->executeSub($player, $args, "invite");
                break;
            case "accept":
                $this->commands["accept"]->executeSub($player, $args, "accept");
                break;
            case "kick":
                $this->commands["kick"]->executeSub($player, $args, "kick");
                break;
            case "leave":
                $this->commands["leave"]->executeSub($player, $args, "leave");
                break;
            case "members":
                $this->commands["members"]->executeSub($player, $args, "members");
                break;
            case "remove":
            case "delete":
            case "del":
                $this->commands["delete"]->executeSub($player, $args, "delete");
                break;
            case "info":
                $this->commands["info"]->executeSub($player, $args, "info");
                break;
            case "chat":
                $this->commands["chat"]->executeSub($player, $args, "chat");
                break;
            case "top":
                $this->commands["top"]->executeSub($player, $args, "top");
                break;
            case "help":
                $this->commands["help"]->executeSub($player, $args, "help");
                break;
            }
        return true;
    }

    public function registerCMD(){
        $this->commands["create"] = new Create($this->plugin);
        $this->commands["invite"] = new Invite($this->plugin);
        $this->commands["accept"] = new Accept($this->plugin);
        $this->commands["kick"] = new Kick($this->plugin);
        $this->commands["leave"] = new Leave($this->plugin);
        $this->commands["members"] = new Members($this->plugin);
        $this->commands["delete"] = new Delete($this->plugin);
        $this->commands["info"] = new Info($this->plugin);
        $this->commands["chat"] = new Chat($this->plugin);
        $this->commands["top"] = new Top($this->plugin);
        $this->commands["help"] = new Help($this->plugin);
    }

    /**
     * @return Plugin
     */
    public function getPlugin(): Plugin{
        return $this->plugin;
    }
}
