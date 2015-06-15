<?php 
//plugin made by Robozeri and Svile
namespace SkyWars;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\scheduler\Task;


use SkyWars\MiniGameBase;
use SkyWars\SkyWarsCommand;
@author robozeriandsvile
class Main extends PluginBase implements CommandExecutor
{
 public $commands;
 public $worldManager;
 public $gameKit;
 public $setup;
 public $controller; 
 public $profileprovider;
 public $playArenas = [];
 
 private $arena1;
 private $arena2;
 private $arena3;
 private $arena4;
 private $arena5;
 
  public function onLoad() 
  {
        $this->commands = new SkyWarsCommand ( $this );
	$this->worldManager = new SkyWarsWorldManager ( $this );
	$this->gameKit = new SkyWarsGameKit($this);
	$this->setup = new SKyWarsSetup($this);
	$this->profileprovider = new SKyWarsProvider ( $this );
	
  }
  public function onEnable
  {
  		$this->getServer()->getPluginManager()->registerEvents($this, $this);
        	$this->saveDefaultConfig();
            	$this->points = new Config($this->getDataFolder()."arena1.yml", Config::YAML);
	
  }
