<?php

namespace ShadowMikado\HandGlider\Events;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\item\ItemFactory;
use pocketmine\player\Player;
use ShadowMikado\HandGlider\Main;

class HandGliderListener implements Listener
{
    private Main $main;


    public function __construct(Main $main)
    {
        $this->main = $main;
    }

    public function getItemHeld(PlayerItemHeldEvent $event)
    {
        $this->main->checkHeldItem($event->getPlayer(), $event->getItem());
    }


    public function QuitEvent(PlayerQuitEvent $event)
    {
        $player = $event->getPlayer();
        $this->main->checkHeldItem($player, ItemFactory::air());
    }

    public function Damaged(EntityDamageEvent $event)
    {
        $player = $event->getEntity();
        $cause = $event->getCause();
        if (!($player instanceof Player)) return;
        if ($cause === EntityDamageEvent::CAUSE_FALL and $this->main->isOnHandGlider($player)) {
            $event->cancel();
        }
    }

    public function JoinEvent(PlayerJoinEvent $event)
    {
        $player = $event->getPlayer();
        $this->main->checkHeldItem($player, $player->getInventory()->getItemInHand());
    }

}