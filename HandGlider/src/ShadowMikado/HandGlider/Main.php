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
use ShadowMikado\HandGlider\Events\HandGliderListener;

//use ShadowMikado\HandGlider\Items\HandGlider;


class Main extends PluginBase
{

    private array $playerOnHandGlider = [];


    protected function onEnable(): void
    {
        $this->getServer()->getLogger()->info("HandGlider lancé avec succès");
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents(new HandGliderListener($this), $this);
    }


    public function isOnHandGlider(Player $player): bool
    {
        return isset($this->playerOnHandGlider[$player->getName()]);
    }


    public function checkHeldItem(Player $player, Item $item)
    {
        $playername = $player->getName();
        $playereffect = $player->getEffects();
        $handglider = $this->getConfig()->get('HandGlider');
        if ($item->getId() . ':' . $item->getMeta() === $handglider) {
            $effect = new MyEffectInstance(VanillaEffects::LEVITATION(), 100 * 99999, -4, false);
            $playereffect->add($effect);
            $this->playerOnHandGlider[$playername] = true;
        } elseif ($this->isOnHandGlider($player)) {
            $playereffect->remove(VanillaEffects::LEVITATION());
            $player->resetFallDistance();
            unset($this->playerOnHandGlider[$playername]);
        }
    }


    public function onDisable(): void
    {
        $this->getServer()->getLogger()->info("HandGlider arrété avec succès");
    }
}