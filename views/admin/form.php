<section class="title">
	<?php if ($this->method == 'create'): ?>
	<h4><?php echo lang('journal:create_title') ?></h4>
<?php else: ?>
	<h4><?php echo sprintf(lang('journal:edit_title'), $post->title) ?></h4>
<?php endif ?>
</section>

<section class="item">
	<div class="content">

		<?php echo form_open_multipart() ?>

		<div class="tabs">

			<ul class="tab-menu">
				<li><a href="#journal-content-tab"><span><?php echo lang('journal:content_label') ?></span></a></li>
				<?php if ($stream_fields): ?><li><a href="#journal-custom-fields"><span><?php echo lang('global:custom_fields') ?></span></a></li><?php endif; ?>
				<li><a href="#journal-options-tab"><span><?php echo lang('journal:options_label') ?></span></a></li>
			</ul>

			<!-- Content tab -->
			<div class="form_inputs" id="journal-content-tab">
				<fieldset>
				
					<ul>

						<li>
							<label for="title"><?php echo lang('global:title') ?> <span>*</span></label>
							<div class="input"><?php echo form_input('title', htmlspecialchars_decode($post->title), 'maxlength="100" id="title"') ?></div>
						</li>
						
						<li>
							<label for="slug"><?php echo lang('global:slug') ?> <span>*</span></label>
							<div class="input"><?php echo form_input('slug', $post->slug, 'maxlength="100" class="width-20"') ?></div>
						</li>
						
						<li>
							<label for="status"><?php echo lang('journal:status_label') ?></label>
							<div class="input"><?php echo form_dropdown('status', array('draft' => lang('journal:draft_label'), 'live' => lang('journal:live_label')), $post->status) ?></div>
						</li>

						<!-- intro -->
						<li class="editor">
							<label for="teaser"><?php echo lang('journal:intro_label') ?> <span>*</span></label><br>
							<div class="input small-side">
								<?php 
							
								echo form_dropdown('type_teaser', array(
									'html' => 'html',
									'markdown' => 'markdown',
									'wysiwyg-simple' => 'wysiwyg-simple',
									'wysiwyg-advanced' => 'wysiwyg-advanced',
									), $post->type_teaser) ?>
								</div>
								
								<div class="edit-content">
									<?php echo form_textarea(array('id' => 'teaser', 'name' => 'teaser', 'value' => $post->teaser, 'rows' => 15, 'class' => $post->type_teaser)) ?>
								</div>
							</li>

							<!-- /intro -->
							<li class="editor">
								<label for="body"><?php echo lang('journal:content_label') ?> <span>*</span></label><br>
								<div class="input small-side">
									<?php 
								
									echo form_dropdown('type_body', array(
										'html' => 'html',
										'markdown' => 'markdown',
										'wysiwyg-simple' => 'wysiwyg-simple',
										'wysiwyg-advanced' => 'wysiwyg-advanced',
										), $post->type_body) ?>
									</div>
									
									<div class="edit-content">
										<?php echo form_textarea(array('id' => 'body', 'name' => 'body', 'value' => $post->body, 'rows' => 30, 'class' => $post->type_body)) ?>
									</div>
								</li>

							</ul>
							<?php echo form_hidden('preview_hash', $post->preview_hash)?>
						</fieldset>
					</div>

					<?php if ($stream_fields): ?>

					<div class="form_inputs" id="journal-custom-fields">
						<fieldset>
							<ul>

								<?php foreach ($stream_fields as $field) echo $this->load->view('admin/partials/streams/form_single_display', array('field' => $field), true) ?>

							</ul>
						</fieldset>
					</div>

				<?php endif; ?>

				<!-- Options tab -->
				<div class="form_inputs" id="journal-options-tab">
					<fieldset>
						<ul>
							
							<li>
								<label for="category_id"><?php echo lang('journal:category_label') ?></label>
								<div class="input">
									<?php echo form_dropdown('category_id', array(lang('journal:no_category_select_label')) + $categories, @$post->category_id) ?>
									[ <?php echo anchor('admin/journal/categories/create', lang('journal:new_category_label'), 'target="_blank"') ?> ]
								</div>
							</li>
							
							<?php if ( ! module_enabled('keywords')): ?>
							<?php echo form_hidden('keywords'); ?>
						<?php else: ?>
						<li>
							<label for="keywords"><?php echo lang('global:keywords') ?></label>
							<div class="input"><?php echo form_input('keywords', $post->keywords, 'id="keywords"') ?></div>
						</li>
					<?php endif; ?>
					
					<li class="date-meta">
						<label><?php echo lang('journal:date_label') ?></label>
						
						<div class="input datetime_input">
							<?php echo form_input('created_on', date('Y-m-d', $post->created_on), 'maxlength="10" id="datepicker" class="text width-20"') ?> &nbsp;
							<?php echo form_dropdown('created_on_hour', $hours, date('H', $post->created_on)) ?> :
							<?php echo form_dropdown('created_on_minute', $minutes, date('i', ltrim($post->created_on, '0'))) ?>
						</div>
					</li>
				
					<?php if ( ! module_enabled('comments')): ?>
					<?php echo form_hidden('comments_enabled', 'no'); ?>
				<?php else: ?>
				<li>
					<label for="comments_enabled"><?php echo lang('journal:comments_enabled_label');?></label>
					<div class="input">
						<?php echo form_dropdown('comments_enabled', array(
							'no' => lang('global:no'),
							'1 day' => lang('global:duration:1-day'),
							'1 week' => lang('global:duration:1-week'),
							'2 weeks' => lang('global:duration:2-weeks'),
							'1 month' => lang('global:duration:1-month'),
							'3 months' => lang('global:duration:3-months'),
							'always' => lang('global:duration:always'),
							), $post->comments_enabled ? $post->comments_enabled : '3 months') ?>
						</div>
					</li>
				<?php endif; ?>
			</ul>
		</fieldset>
	</div>

</div>

<input type="hidden" name="row_edit_id" value="<?php if ($this->method != 'create'): echo $post->id; endif; ?>" />

<div class="buttons">
	<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel'))) ?>
</div>

<?php echo form_close() ?>

</div>
</section>
