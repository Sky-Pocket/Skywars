<?php

namespace SkyWars;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\level\Position;
use pocketmine\level\Level;
use pocketmine\level\Explosion;
use pocketmine\event\block\BlockEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityMoveEvent;
use pocketmine\event\entity\EntityMotionEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\math\Vector3 as Vector3;
use pocketmine\math\Vector2 as Vector2;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerRespawnEvent;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\network\protocol\AddMobPacket;
use pocketmine\network\protocol\AddEntityPacket;
use pocketmine\network\protocol\UpdateBlockPacket;
use pocketmine\block\Block;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\protocol\DataPacket;
use pocketmine\network\protocol\Info;
use pocketmine\network\protocol\LoginPacket;
use pocketmine\entity\FallingBlock;
use pocketmine\command\defaults\TeleportCommand;
use pocketmine\event\block\SignChangeEvent;
use pocketmine\item\ItemBlock;
use pocketmine\item\Item;
class SkyWarsCommand extends MiniGamesBase 
{
public function __construct(TurfWarsPlugIn $plugin) {
		parent::__construct ( $plugin );
	}
	
	/**
	 * onCommand
	 *
	 * @param CommandSender $sender        	
	 * @param Command $command        	
	 * @param unknown $label        	
	 * @param array $args        	
	 * @return boolean
	 */
	public function onCommand(CommandSender $sender, Command $command, $label, array $args) {
		// check command names
		if (((strtolower ( $command->getName () ) == "skywars" || strtolower ( $command->getName () ) == "sw")) && isset ( $args [0] )) {
			try {
				$output = "";
				if (! $sender instanceof Player) {
					$output .= "Commands only available in-game play.\n";
					$sender->sendMessage ( $output );
					return;
				}
				//particle 
				if (strtolower ( $args [0] ) == "particle") {
					if (count ( $args ) != 2) {
						$output = "[SkyWars] Usage: /sw particle [particle name].\n";
						$sender->sendMessage ( $output );
						return;
					}
					if ($sender instanceof Player) {
						if ($args [1] == "clear") {
							unset ( $this->plugin->playerParticles [$sender->getName ()] );
							$output = "[SkyWars] Cleared been particle]\n";
						} else {
							$particle = MagicUtil::getParticle ( $args [1], $sender->getPosition (), 1, 1, 1, null );
							if ($particle == null) {
								$output = "[SkyWars]particle name [" . $args [1] . "] not found! \n";
								$sender->sendMessage ( $output );
								return;
							}
							$this->plugin->playerParticles [$sender->getName ()] = $args [1];
							$output = "[SkyWars] Player set to [" . $args [1] . "]\n";
							$sender->sendMessage ( $output );
						}
						return;
					}
				}
				
				if (strtolower ( $args [0] ) == "list") {
					foreach ( $this->getPlugin ()->playArenas as $arena ) {
						$sender->sendMessage ( $arena->name );
					}
				}
				// $playerParticles
				if (strtolower ( $args [0] ) == "shop") {
					$output = ".\n";
						$sender->sendMessage ( $output );
					
					if (count ( $args ) != 2) {
						$output = "[SkyWars] Usage: /sw shop .\n";
						$sender->sendMessage ( $output );
						return;
				
		}
	}
}
}
