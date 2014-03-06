<h1><?php echo $post->title ?></h1>

<p style="float:left; width: 40%;">
	<?php echo anchor('journal/' .date('Y/m', $post->created_on) .'/'. $post->slug, null, 'target="_blank"') ?>
</p>

<p style="float:right; width: 40%; text-align: right;">
	<?php echo anchor('admin/journal/edit/'. $post->id, lang('global:edit'), ' target="_parent"') ?>
</p>

<iframe src="<?php echo site_url('journal/' .date('Y/m', $post->created_on) .'/'. $post->slug) ?>" width="99%" height="400"></iframe>
