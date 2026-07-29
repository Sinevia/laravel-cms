<?php

namespace Sinevia\Cms\Tests\Models;

use Sinevia\Cms\Models\Menu;
use Sinevia\Cms\Models\MenuItem;
use Sinevia\Cms\Tests\TestCase;

class MenuTest extends TestCase
{
    public function test_menu_can_be_created(): void
    {
        $menu = new Menu();
        $menu->Id = 'test-menu-id-000001';
        $menu->Status = 'Draft';
        $menu->Title = 'Test Menu';
        $menu->save();

        $this->assertDatabaseHas('snv_cms_menu', [
            'Id' => 'test-menu-id-000001',
            'Status' => 'Draft',
            'Title' => 'Test Menu',
        ]);
    }

    public function test_menu_can_be_found_by_id(): void
    {
        $menu = new Menu();
        $menu->Id = 'find-menu-id-0000001';
        $menu->Status = 'Published';
        $menu->Title = 'Find Me Menu';
        $menu->save();

        $found = Menu::find('find-menu-id-0000001');
        $this->assertNotNull($found);
        $this->assertEquals('Find Me Menu', $found->Title);
    }

    public function test_menu_status_constants(): void
    {
        $this->assertEquals('Draft', Menu::STATUS_DRAFT);
        $this->assertEquals('Published', Menu::STATUS_PUBLISHED);
        $this->assertEquals('Unpublished', Menu::STATUS_UNPUBLISHED);
        $this->assertEquals('Deleted', Menu::STATUS_DELETED);
    }

    public function test_menu_menuitems_relationship(): void
    {
        $menu = new Menu();
        $menu->Id = 'menu-items-rel-00001';
        $menu->Status = 'Published';
        $menu->Title = 'Menu With Items';
        $menu->save();

        $item1 = new MenuItem();
        $item1->Id = 'menuitem-rel-0000001';
        $item1->MenuId = $menu->Id;
        $item1->Title = 'Home';
        $item1->Url = '/';
        $item1->save();

        $item2 = new MenuItem();
        $item2->Id = 'menuitem-rel-0000002';
        $item2->MenuId = $menu->Id;
        $item2->Title = 'About';
        $item2->Url = '/about';
        $item2->save();

        $this->assertCount(2, $menu->menuitems);
    }

    public function test_menu_tree_menu_items_returns_hierarchical_structure(): void
    {
        $menu = new Menu();
        $menu->Id = 'menu-tree-0000000001';
        $menu->Status = 'Published';
        $menu->Title = 'Tree Menu';
        $menu->save();

        $parent = new MenuItem();
        $parent->Id = 'menuitem-parent-0001';
        $parent->MenuId = $menu->Id;
        $parent->Title = 'Parent';
        $parent->Url = '/parent';
        $parent->Sequence = '1';
        $parent->save();

        $child = new MenuItem();
        $child->Id = 'menuitem-child-00001';
        $child->MenuId = $menu->Id;
        $child->ParentId = $parent->Id;
        $child->Title = 'Child';
        $child->Url = '/parent/child';
        $child->Sequence = '1';
        $child->save();

        $tree = $menu->treeMenuItems('');
        $this->assertCount(1, $tree);
        $this->assertEquals('Parent', $tree[0]->Title);
        $this->assertCount(1, $tree[0]->children);
        $this->assertEquals('Child', $tree[0]->children[0]->Title);
    }

    public function test_menu_item_can_be_created(): void
    {
        $item = new MenuItem();
        $item->Id = 'menuitem-create-0001';
        $item->MenuId = 'some-menu-id';
        $item->Title = 'Test Item';
        $item->Url = '/test-item';
        $item->save();

        $this->assertDatabaseHas('snv_cms_menuitem', [
            'Id' => 'menuitem-create-0001',
            'Title' => 'Test Item',
            'Url' => '/test-item',
        ]);
    }
}
