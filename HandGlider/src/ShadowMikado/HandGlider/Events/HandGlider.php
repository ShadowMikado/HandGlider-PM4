<?php

namespace ShadowMikado\HandGlider\Events;

use pocketmine\entity\effect\VanillaEffects;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\item\ItemFactory;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use ShadowMikado\HandGlider\Effects\MyEffectInstance;
use ShadowMikado\HandGlider\Main;

class HandGlider implements Listener
{

    public function hasHandGlider(PlayerItemHeldEvent $event)
    {
        $cfg = new Config(Main::getInstance()->getDataFolder() . "config.yml", Config::YAML);
        $item = $event->getItem();
        $player = $event->getPlayer();
        $playereffect = $player->getEffects();

        if ($item->getId() === $cfg->get("Hand Glider Id") and $item->getMeta() === $cfg->get("Hand Glider Meta")) {
            $effect = new MyEffectInstance(VanillaEffects::LEVITATION(), 100 * 99999, -4, false);
            $playereffect->add($effect);
        } else {
            $player->getEffects()->remove(VanillaEffects::LEVITATION());
        }

    }


    public function onQuit(PlayerQuitEvent $event) {
        $cfg = new Config(Main::getInstance()->getDataFolder() . "config.yml", Config::YAML);
        $player = $event->getPlayer();
        if($player->getInventory()->getItemInHand()->getId() === $cfg->get("Hand Glider Id") and $player->getInventory()->getItemInHand()->getMeta() === $cfg->get("Hand Glider Meta")) {
            $player->getEffects()->remove(VanillaEffects::LEVITATION());
        }
    }

    public function onDamaged(EntityDamageEvent $event) {
        $cfg = new Config(Main::getInstance()->getDataFolder() . "config.yml", Config::YAML);
        $player = $event->getEntity();
        $cause = $event->getCause();
        if (!($player instanceof Player)) return;
        if ($cause === EntityDamageEvent::CAUSE_FALL and $player->getInventory()->getItemInHand()->getId() === $cfg->get("Hand Glider Id") and $player->getInventory()->getItemInHand()->getMeta() === $cfg->get("Hand Glider Meta")) {
            $event->cancel();
        }
    }
}