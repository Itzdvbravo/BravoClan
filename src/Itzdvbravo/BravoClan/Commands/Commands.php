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

    /** @var Sub[] */
    public $commands = [];
    public $invite = [];

    public function __construct(Main $plugin){
        parent::__construct("clan", "Clan Commands");
        $this->registerAllSubCommands();
    }

    /**
     * @param CommandSender $player
     * @param string $label
     * @param array $args
     * @return bool
     */
    public function execute(CommandSender $player, string $label, array $args):bool {
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

    private function registerAllSubCommands(){
        $this->registerSubCommand(new Create(Main::getInstance()));
        $this->registerSubCommand(new Invite(Main::getInstance()));
        $this->registerSubCommand(new Accept(Main::getInstance()));
        $this->registerSubCommand(new Kick(Main::getInstance()));
        $this->registerSubCommand(new Leave(Main::getInstance()));
        $this->registerSubCommand(new Members(Main::getInstance()));
        $this->registerSubCommand(new Delete(Main::getInstance()));
        $this->registerSubCommand(new Info(Main::getInstance()));
        $this->registerSubCommand(new Chat(Main::getInstance()));
        $this->registerSubCommand(new Top(Main::getInstance()));
        $this->registerSubCommand(new Help(Main::getInstance()));
    }

    private function registerSubCommand(Sub $sub): void
    {
        $this->commands[$sub->getName()] = $sub;
    }

    /**
     * @return Plugin
     */
    public function getPlugin(): Plugin{
        return Main::getInstance();
    }
}