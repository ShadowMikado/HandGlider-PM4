<?php


namespace ShadowMikado\HandGlider;


use pocketmine\entity\effect\VanillaEffects;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\item\Item;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use ShadowMikado\HandGlider\Effects\MyEffectInstance;
use ShadowMikado\HandGlider\Events\HandGlider;



class Main extends PluginBase
{
    public static Main $main;

    public Config $config;

    /**
     * @var Main
     */

    public function onLoad(): void
    {
        $this->getServer()->getLogger()->info("Starting HandGlider Plugin...");

    }

    protected function onEnable(): void
    {
        $this->getServer()->getLogger()->info("HandGlider Plugin Started");
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents(new HandGlider(), $this);
        self::$main = $this;
        $this->saveResource("config.yml");
    }

    public static function getInstance(): Main
    {
        return self::$main;
    }


    public function onDisable(): void
    {
        $this->getServer()->getLogger()->info("HandGlider Plugin Stopped");
    }





}