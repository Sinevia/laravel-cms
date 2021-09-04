<div class="card box-primary">
    <div class="card-header with-border">
        <div>
            <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminMenuManager(); ?>" class="btn btn-info">
                @include("cms::shared/icons/bootstrap/bi-chevron-left")
                Cancel
            </a>
            <button type="button" class="btn btn-success float-end" style="margin:0px 10px;"  onclick="FORM_MENU_EDIT.submit();">
                @include("cms::shared/icons/bootstrap/bi-check-all")
                Save
            </button>
            <button type="button" class="btn btn-success float-end" style="margin:0px 10px;" onclick="$('#form_action').val('save');
                    FORM_MENU_EDIT.submit();">
                @include("cms::shared/icons/bootstrap/bi-check")
                Apply
            </button>
        </div>
    </div>
    <div class="card-body">
        <form name="FORM_MENU_EDIT" action="" method="post">
            <!-- START: Status -->
            <div class="form-group">
                <label>
                    Status
                    <sup>required</sup>
                </label>
                <select class="form-control" name="status">
                    <option value=""></option>
                    <?php $selected = ($status == \Sinevia\Cms\Models\Menu::STATUS_DRAFT) ? 'selected="selected"' : ''; ?>
                    <option value="<?php echo \Sinevia\Cms\Models\Menu::STATUS_DRAFT ?>" <?php echo $selected ?> >Draft</option>
                    <?php $selected = ($status == \Sinevia\Cms\Models\Menu::STATUS_PUBLISHED) ? 'selected="selected"' : ''; ?>
                    <option value="<?php echo \Sinevia\Cms\Models\Menu::STATUS_PUBLISHED ?>" <?php echo $selected ?> >Published</option>
                    <?php $selected = ($status == \Sinevia\Cms\Models\Menu::STATUS_UNPUBLISHED) ? 'selected="selected"' : ''; ?>
                    <option value="<?php echo \Sinevia\Cms\Models\Menu::STATUS_UNPUBLISHED ?>" <?php echo $selected ?> >Unpublished</option>
                    <?php $selected = ($status == \Sinevia\Cms\Models\Menu::STATUS_DELETED) ? 'selected="selected"' : ''; ?>
                    <option value="<?php echo \Sinevia\Cms\Models\Menu::STATUS_DELETED ?>" <?php echo $selected ?> >Deleted</option>
                </select>
            </div>
            <!-- END: Status -->
            <!-- START: Name -->
            <div class="form-group">
                <label>
                    Title
                    <sup>required</sup>
                </label>
                <input class="form-control" name="title" type="text" value="<?php echo htmlentities($title); ?>" />
                <p class="text-info">
                    Friendly title of the menu. This is for internal use and not displayed publicly
                </p>
            </div>
            <!-- END: Name -->
            
            @csrf
            <input type="hidden" name="action" id="form_action" value="save-and-exit">
        </form>
    </div>
</div>
