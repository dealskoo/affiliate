<?php

namespace Dealskoo\Affiliate\Menu;

use Nwidart\Menus\MenuItem;
use Nwidart\Menus\Presenters\Presenter;

class AffiliatePresenter extends Presenter
{
    /**
     * {@inheritdoc }.
     */
    public function getOpenTagWrapper()
    {
        return PHP_EOL . '<ul class="nav navbar-nav">' . PHP_EOL;
    }

    /**
     * {@inheritdoc }.
     */
    public function getCloseTagWrapper()
    {
        return PHP_EOL . '</ul>' . PHP_EOL;
    }

    public function getMenuWithoutDropdownWrapper($item)
    {
        return '<li' . $this->getActiveState($item) . '><a class="nav-link" href="' . $item->getUrl() . '" ' . $item->getAttributes() . '>' . $item->getIcon() . __($item->title) . '</a></li>' . PHP_EOL;
    }

    public function getMenuDropdownWrapper($item)
    {
        return '<li' . $this->getActiveState($item) . '><a class="dropdown-item" href="' . $item->getUrl() . '" ' . $item->getAttributes() . '>' . $item->getIcon() . __($item->title) . '</a></li>' . PHP_EOL;
    }

    public function getActiveState($item, $state = ' class="active nav-item"')
    {
        return $item->isActive() ? $state : ' class="nav-item"';
    }

    public function getActiveStateOnChild($item, $state = 'active')
    {
        return $item->hasActiveOnChild() ? $state : null;
    }


    public function getDividerWrapper()
    {
        return '<li class="divider"></li>';
    }

    /**
     * {@inheritdoc }.
     */
    public function getHeaderWrapper($item)
    {
        return '<li class="dropdown-header">' . __($item->title) . '</li>';
    }


    public function getMenuWithDropDownWrapper($item)
    {
        return '<li class="nav-item dropdown' . $this->getActiveStateOnChild($item, ' active') . '">
		          <a href="#" class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown">
					' . $item->getIcon() . __($item->title) . '<div class="arrow-down"></div>
			      </a>
			      <ul class="dropdown-menu">
			      	' . $this->getChildMenuItems($item) . '
			      </ul>
		      	</li>'
            . PHP_EOL;
    }

    public function getMultiLevelDropdownWrapper($item)
    {
        return '<li class="dropdown' . $this->getActiveStateOnChild($item, ' active') . '">
		          <a href="#" class="dropdown-item dropdown-toggle arrow-none" data-toggle="dropdown">
					' . $item->getIcon() . ' ' . __($item->title) . '
			      	<div class="arrow-down"></div>
			      </a>
			      <ul class="dropdown-menu">
			      	' . $this->getChildMenuItems($item) . '
			      </ul>
		      	</li>'
            . PHP_EOL;
    }

    public function getChildMenuItems(MenuItem $item)
    {
        $results = '';
        foreach ($item->getChilds() as $child) {
            if ($child->hidden()) {
                continue;
            }

            if ($child->hasSubMenu()) {
                $results .= $this->getMultiLevelDropdownWrapper($child);
            } elseif ($child->isHeader()) {
                $results .= $this->getHeaderWrapper($child);
            } elseif ($child->isDivider()) {
                $results .= $this->getDividerWrapper();
            } else {
                $results .= $this->getMenuDropdownWrapper($child);
            }
        }

        return $results;
    }
}
