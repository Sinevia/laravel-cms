<?php if ($paginator->hasPages()) { ?>
    <nav>
        <ul class="pagination">
            <?php if ($paginator->onFirstPage()) { ?>
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                </li>
            <?php } else { ?>
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            <?php } ?>

            <?php foreach ($elements as $element) { ?>
                <?php if (is_string($element)) { ?>
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                <?php } ?>

                <?php if (is_array($element)) { ?>
                    <?php foreach ($element as $page => $url) { ?>
                        <?php if ($page == $paginator->currentPage()) { ?>
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        <?php } else { ?>
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            <?php } ?>

            <?php if ($paginator->hasMorePages()) { ?>
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            <?php } else { ?>
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                </li>
            <?php } ?>
        </ul>
    </nav>
<?php } ?>
