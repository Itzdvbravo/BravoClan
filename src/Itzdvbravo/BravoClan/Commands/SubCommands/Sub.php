<?php

namespace Itzdvbravo\BravoClan\Commands\SubCommands;

use pocketmine\command\CommandSender;

/**
 * Interface Sub
 * @package Itzdvbravo\BravoClan\Commands\SubCommands
 */
interface Sub{

    public function getName(): string;

    /**
     *
     * @api
     *
     * @param CommandSender $player
     * @param array $args
     * @param string $name
     * @return mixed
     */
    public function executeSub(CommandSender $player, array $args, string $name);
    #Saw it in MultiWorld plugin By czechpmdevs for it, thought it would be cleaner this way
}