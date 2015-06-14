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
  	$this->initConfigFile ();
		$this->enabled = true;
		$this->getServer ()->getPluginManager ()->registerEvents ( new SkyWarsWarsListener ( $this ), $this );
		
		$this->worldManager->loadworlds ();
		
		$this->statueManager = new StatueManager( $this );
		$this->statueManager->loadStatues ();
		
		if ($this->profileprovider != null) {
			$this->profileprovider->initlize ();
  	$this->initScheduler();
		
		$this->log ( TextFormat::GREEN . "- SKyWars Enable -" );
		
       
        $this->pmsg = " Click a sign to start playing! For use / sw info or / sw help. ";
       
        $this->pmc = 0;

        $this->getServer()->getScheduler()->scheduleRepeatingTask(new CallbackTask(array($this, "popup")),3); 


  	
  }
  private function initConfigFile() {
		try {
			if (! file_exists ( $this->getDataFolder () )) {
				@mkdir ( $this->getDataFolder (), 0777, true );
				file_put_contents ( $this->getDataFolder () . "config.yml", $this->getResource ( "config.yml" ) );
			}
			$this->saveDefaultConfig ();
			$this->reloadConfig ();
			$this->getConfig ()->getAll ();
		} catch ( \Exception $e ) {
			$this->getLogger ()->error ( $e->getMessage ("Error in config please reset plugin") );
		}
	}
	private function initScheduler() {
		// 
		$wait_time = 10 * $this->getServer ()->getTicksPerSecond ();
		$worldResetTask = new PlaySkyWarsWarsTask( $this );
		$this->getServer ()->getScheduler ()->scheduleRepeatingTask ( $skywarsResetTask,60 );

		$particleTask = new UpdatePlayerParticleTask($this);
		$this->getServer ()->getScheduler ()->scheduleRepeatingTask ( $particleTask,30);
	}
  public function onCommand(CommandSender $sender, Command $command, $label, array $args) {
		$this->commands->onCommand ( $sender, $command, $label, $args );
  public function onDisable
  {
                $this->log ( TextFormat::RED . "- SKyWars Disable -" ); 
  }
}
  public function popup {
  	$tn = substr($this->pmsg,1);
        $tc = substr($this->pmsg,1,1);
       
        $this->pmsg = $tn.$tc;
       
        foreach(Server::getInstance()->getOnlinePlayers() as $ppp){
           
            if($ppp->getLevel() == $this->lobby){
           
                $ppp->sendPopup(str_repeat("§4#",25) . "\n§e   " . substr($this->pmsg,0,25));
           
            }
        }
       
        $this->pmc++;
  }
private function log($msg) {
		$this->getLogger ()->info ( $msg );
	}

