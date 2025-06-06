<p><?php echo $total ?> found</p>
<nav>
	<ul class="pagination">
		<?php
			foreach($linkItems as $item) {
				if(is_null($item->url)) {
		?>
			<li class="page-item disabled">
                <span class="page-link"><?php echo $item->label ?></span>
            </li>
		<?php
				} elseif($item->active) {
		?>
		<li class="page-item active">
			<a class="page-link" href="<?php echo $item->url ?>">
                <?php echo $item->label ?> <span class="sr-only">(current)</span>
            </a>
		</li>
		<?php
				} else {
		?>
			<li class="page-item">
                <a class="page-link" href="<?php echo $item->url ?? "" ?>">
                    <?php echo $item->label ?>
                </a>
            </li>
		<?php
				}
			}
		?>
	</ul>
</nav>
