<div class="content_sidebar">
	<?php if ($sidebar['docs']) { ?>
	<h4>Methods list</h4>
	<div class="methods_list">
		<ul>
			<?php foreach ($sidebar['docs'] as $key => $docs) { ?>
				
			<li>
				<a data-toggle="collapse" href="#<?=strtolower($key)?>" aria-expanded="false" aria-controls="collapseExample"><?=$key?> <span class="badge pull-right"><?=count($docs)?></span></a>
				
				<div class="collapse" id="<?=strtolower($key)?>">
				<ul>
					<?php foreach ($docs as $k => $d) { ?>
					<li><a href="/docs/<?=$d['method']?>"><?=$d['method']?></a></li>
					<?php } ?>
				</ul>
				</div>
				
			</li>
			<?php } ?>
			
		</ul>
	</div>
	<?php } ?>
</div>