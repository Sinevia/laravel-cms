<!-- START: Menu Item Update Modal Dialog -->
<div class="modal fade" id="ModalMenuItemUpdate">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Update menu item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Title</label>
                    <input name="title" value="" class="form-control" />
                </div>
                <div class="form-group mt-3">
                    <label>Link to page</label>
                    <select  name="page_id" class="form-control">
                        <option value="">No page selected</option>
                        <?php foreach ($pages as $page) {?>
                            <option value="{{$page->Id}}">
                                {{ $page->getTitle() }}
                            </option>
                        <?php }?>
                    </select>
                </div>
                <div class="form-group mt-3">
                    <label>Link to URL</label>
                    <input name="url" value="" class="form-control" />
                </div>
                <div class="form-group mt-3">
                    <label>Open link in:</label>
                    <select  name="target" class="form-control">
                        <option>No target selected</option>
                        <option value="_self">Same Window</option>
                        <option value="_blank">New Window</option>
                    </select>
                </div>
               <input name="menu_item_id" type="hidden" />
            </div>
            <div class="modal-footer" style="display:block;">
                <a id="modal-close" href="#" class="btn btn-info" data-dismiss="modal">
                    @include("cms::shared/icons/bootstrap/bi-chevron-left")
                    Cancel
                </a>
                <a id="modal-close" href="#" class="btn btn-success float-end" data-dismiss="modal" onclick="saveMenuItemUpdateModal();">
                    @include("cms::shared/icons/bootstrap/bi-check-circle")
                    Update menu item
                </a>
            </div>
        </div>
    </div>
</div>
<script>
    function showMenuItemUpdateModal(menuItemId, title, pageId, url, target) {
        $('#ModalMenuItemUpdate input[name=title]').val(title);
        $('#ModalMenuItemUpdate input[name=menu_item_id]').val(menuItemId);
        $('#ModalMenuItemUpdate select[name=page_id]').val(pageId);
        $('#ModalMenuItemUpdate input[name=url]').val(url);
        $('#ModalMenuItemUpdate select[name=target]').val(target);
        $('#ModalMenuItemUpdate').modal('show');
    }
    function saveMenuItemUpdateModal() {
        var title = $('#ModalMenuItemUpdate input[name=title]').val();
        var pageId = $('#ModalMenuItemUpdate select[name=page_id]').val();
        var url = $('#ModalMenuItemUpdate input[name=url]').val();
        var menuItemId = $('#ModalMenuItemUpdate input[name=menu_item_id]').val();
        var target = $('#ModalMenuItemUpdate select[name=target]').val();
        var node = $('#tree1').tree('getNodeById', menuItemId);
        $('#tree1').tree('updateNode', node, {
            name: title,
            title: title,
            page_id: pageId,
            url: url,
            target: target
        });
        menuItemsLoad();
        $('#ModalMenuItemUpdate').modal('hide');
    }
</script>
<!-- END: Menu Item Update Modal Dialog -->
