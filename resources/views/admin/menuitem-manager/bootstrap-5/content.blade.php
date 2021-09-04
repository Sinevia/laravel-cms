
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqtree/1.4.12/jqtree.css" integrity="sha256-HXkFXoUJm+hZNZftCzYGMRpnrDf9JVQK6Zzsm5czcRo=" crossorigin="anonymous" />
<style>
    ul.jqtree-tree li > .jqtree-element {
        display: block;
        padding: 10px;
    }
</style>
<div class="card box-primary">
    <div class="card-header with-border">
        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminMenuManager(); ?>" class="btn btn-info">
            @include("cms::shared/icons/bootstrap/bi-chevron-left")
            Cancel
        </a>
        <button onclick="menuItemAdd();" id="ButtonNewMenuItem" disabled="disabled" class="btn btn-info float-right">
            @include("cms::shared.icons.bootstrap.bi-plus-circle")
            Add menu item
        </button>
        <button onclick="menuItemsSave();" id="ButtonSaveMenuItems" disabled="disabled" class="btn btn-success">
            @include("cms::shared/icons/bootstrap/bi-check-all")
            Save menu items
        </button>
    </div>
    <div class="card-body">
        <div id="tree1"></div>
    </div>
</div>

@include('cms::admin/menuitem-manager/bootstrap-5/menuitem-update-modal')


<script src="https://cdnjs.cloudflare.com/ajax/libs/jqtree/1.4.12/tree.jquery.js" integrity="sha256-MVNe3e6Cast71iAc+Jy+z9+BhDfh7y5iz8GBz8mBZ9M=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js" integrity="sha256-tSRROoGfGWTveRpDHFiWVz+UXt+xKNe90wwGn25lpw8=" crossorigin="anonymous"></script>
<script>var menuId = <?php echo json_encode($menu->Id); ?>;</script>
<script>var menuItemsSaveUrl = <?php echo json_encode(\Sinevia\Cms\Helpers\Links::adminMenuitemsSaveAjax(['menu_id' => $menu->Id])); ?>;</script>
<script>var menuItemsFetchUrl = <?php echo json_encode(\Sinevia\Cms\Helpers\Links::adminMenuitemsFetchAjax(['menu_id' => $menu->Id])); ?>;</script>
<script>
    var menuitems = [];  // Global
    $(function () {
        menuItemsFetch();
    });
    function menuItemsLoad() {
        $('#tree1').tree({
            data: menuitems,
            dragAndDrop: true,
            autoOpen: true,
            saveState: true,
            onCreateLi: function (node, $li) {
                // Append a link to the jqtree-element div.
                // The link has an url '#node-[id]' and a data property 'node-id'.
                var html = '';
                html += '<button class="menu-item-delete-button float-right btn btn-danger btn-sm" data-node-id="' + node.id + '">delete</button>';
                html += '<button class="menu-item-edit-button float-right btn btn-info btn-sm" data-node-id="' + node.id + '">edit</button>';
                $li.find('.jqtree-element').append(html);
            }
        });
        menuItemButtonsAddEvents();
    }
    function menuItemButtonsAddEvents() {
        $('.menu-item-edit-button').click(function () {
            var id = $(this).data('node-id');
            var node = $('#tree1').tree('getNodeById', id);
            console.log(node);
            showMenuItemUpdateModal(id, node.name, node.page_id, node.url, node.target);
        });
        $('.menu-item-delete-button').click(function () {
            var id = $(this).data('node-id');
            var node = $('#tree1').tree('getNodeById', id);
            var isConfirmed = confirm('Are you sure you want to delete menu item: "' + node.name + '"');
            if (isConfirmed === true) {
                console.log(node);
                $('#tree1').tree('removeNode', node);
                menuItemButtonsAddEvents();
                return true;
            }
            return false;
        });
    }
    function menuItemAdd() {
        var uniqueId = Math.random().toString(36).substring(2) + Date.now().toString(36);
        $('#tree1').tree('appendNode', {
            name: ('new_node ' + uniqueId),
            id: uniqueId
        }, null);
        menuItemButtonsAddEvents();
    }
    function menuItemsSave() {
        var data = $('#tree1').tree('toJson'); // JSON string
        $('#ButtonSaveMenuItems').html('Saving menu items to server ...');
        $.post(menuItemsSaveUrl, {menu_id: menuId, data: data}).then(function (response) {
            if (response.status === 'success') {
                $.notify("Saving menu items successful. Reloading from the server...", "success");
            } else {
                $.notify("Saving menu items failed. Reloading from the server...", "error");
            }
            $('#tree1').tree('destroy');
            menuItemsFetch();
        }).fail(function () {
            menuItemsFetch();
        });
    }
    function menuItemsFetch() {
        $('#ButtonSaveMenuItems').html('Loading menu items from the server ...').prop('disabled', true);
        $('#ButtonNewMenuItem').prop('disabled', true);
        $.get(menuItemsFetchUrl, {menu_id: menuId}).then(function (response) {
            if (response.status === 'success') {
                menuitems = [];
                menuitems = response.data.menuitems;
                menuItemsLoad();
                $('#ButtonSaveMenuItems').html('<i class="fas fa-save"></i> Save menu items').prop('disabled', false);
                $('#ButtonNewMenuItem').prop('disabled', false);
            } else {
                $.notify("Fetching menu items unsuccessful. Please refresh the page.", "error");
            }
        }).fail(function () {
            menuItems = [];
            menuItemsLoad();
            $.notify("Fetching menu items FAILED. Please refresh the page.", "error");
            $('#ButtonSaveMenuItems').html('fetching  menu items FAILED. Please, refresh page').prop('disabled', true);
            $('#ButtonNewMenuItem').prop('disabled', true);
        });
    }
</script>
