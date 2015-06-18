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

class Main extends PluginBase implements CommandExecutor
{
 	public $commands;
	public $arenaManager;
	public $gameKit;
	public $setup;
	public $controller;
	public $profileprovider;
	public $defenceManager;
	public $blocks;
	public $pos_display_flag;
	public $playArenas = [];	
	public $backupArenas = [];
	
	public $redTeam = [];
	public $blueTeam = [];

	public $arrowShooter = [];
	
	public $setupModeAction = "";
	public $setupModeData = "";
	public $homeLevel = null;
	public $gameMode = 0;	
	public $forceReset = true;
	
	public $npcs = [];
	public $npcsPositions = [];
	public $npcsPodium = [];
	public $statueManager;
	public $npcsSpawns = [];

	public $playerParticles = [];
	
	public function getHomeLevel() {
		return $this->homeLevel;
	}
	public function setHomeLevel($hlevel) {
		$this->homeLevel = $hlevel;
	}
	public function onLoad() {
		$this->commands = new SkyWarsCommand ( $this );
		$this->arenaManager = new ArenaManager ( $this );
		$this->gameKit = new SkyWarsGameKit($this);
		$this->setup = new SkyWarsSetup($this);
		$this->controller = new SkyWarsController($this);
		$this->profileprovider = new ProfileProvider ( $this );
	}
	public function onEnable() {
		$this->initConfigFile ();
		$this->enabled = true;
		$this->getServer ()->getPluginManager ()->registerEvents ( new SkyWarsListener ( $this ), $this );
		
		$this->arenaManager->loadArenas ();
		
		$this->statueManager = new StatueManager( $this );
		$this->statueManager->loadStatues ();
		
		if ($this->profileprovider != null) {
			$this->profileprovider->initlize ();
		}
		
		
		$this->initScheduler();
		
		$this->log ( TextFormat::GREEN . "- [SkyWars] has been enabled -!" );
	}
