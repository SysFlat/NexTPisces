<div class="comments" id="comments">
    <?php $this->comments()->to($comments);?>
    <?php if ($comments->have()): ?>
        <h3><?php $this->commentsNum(_t('暂无评论'), _t('仅有 1 条评论'), _t('已有 %d 条评论'));?></h3>

	<?php function threadedComments($comments, $options) {
		$commentClass = '';
		if ($comments->authorId) {
			if ($comments->authorId == $comments->ownerId) {
				$commentClass .= ' comment-by-author';
			} else {
				$commentClass .= ' comment-by-user';
			}
		}
	 
		$commentLevelClass = $comments->levels > 0 ? ' comment-child' : ' comment-parent';
	?>
	 
	<li id="li-<?php $comments->theId(); ?>" class="comment-body<?php 
	if ($comments->levels > 0) {
		echo ' comment-child';
		$comments->levelsAlt(' comment-level-odd', ' comment-level-even');
	} else {
		echo ' comment-parent';
	}
	$comments->alt(' comment-odd', ' comment-even');
	echo $commentClass;
	?>">
	
	
	<div id="<?php $comments->theId(); ?>">
		<div class="comment-author">
		<span itemprop="image"><?php $number=$comments->mail;
			if(preg_match('|^[1-9]\d{4,11}@qq\.com$|i',$number)){
			echo '<img src="https://q2.qlogo.cn/headimg_dl? bs='.$number.'&dst_uin='.$number.'&dst_uin='.$number.'&;dst_uin='.$number.'&spec=100&url_enc=0&referer=bu_interface&term_type=PC" width="46px" height="46px" style="border-radius: 50%;float: left;margin-top: 0px;margin-right: 10px;margin-bottom:-2px">'; 
			}else{
			echo '<img src="https://lorempixel.com/46/46/" width="46px" height="46px" style="border-radius: 50%;float: left;margin-top: 0px;margin-right: 10px;margin-bottom:-2px">';
			}
			?>
		</span>
			<cite class="fn"><?php $comments->author(); ?></cite>
			<?php CommentApprove_Plugin::identify($comments->mail);?>
		</div>
		<div class="comment-meta">
			<a href="<?php $comments->permalink(); ?>"><?php $comments->date('Y-m-d H:i'); ?></a>
			<span class="comment-reply"><?php $comments->reply(); ?></span>
		</div>
        <div class="comment-content">
            <span>
                <?php get_commentReply_at($comments->coid); ?>
                <?php $cos = preg_replace('#</?[p|P][^>]*>#','',$comments->content);echo $cos;?>
            </span>
        </div>
	</div>
	
	<?php if ($comments->children) { ?>
		<div class="comment-children">
			<?php $comments->threadedComments($options); ?>
		</div>
	<?php } ?>
	</li>
	<?php } ?>		
		
		
        <?php $comments->listComments();?>
        <?php $comments->pageNav('&laquo; ', ' &raquo;', 5, '...', array('wrapTag' => 'nav', 'wrapClass' => 'pagination', 'itemTag' => '', 'prevClass' => 'extend prev', 'nextClass' => 'extend next', 'currentClass' => 'page-number current'));?>
    <?php endif;?>
    <?php if ($this->allow('comment')): ?>
        <div id="<?php $this->respondId();?>" class="respond">
            <div class="cancel-comment-reply">
                <?php $comments->cancelReply();?>
            </div>
            <h3 id="response" ><?php _e('添加新评论');?></h3>
            <form method="post" action="<?php $this->commentUrl()?>" id="comment-form">
                <div>
                    <?php if ($this->user->hasLogin()): ?>
                        <p><?php _e('登录身份：');?><a href="<?php $this->options->profileUrl();?>"><?php $this->user->screenName();?></a>. <a href="<?php $this->options->logoutUrl();?>" title="Logout"><?php _e('退出');?> &raquo;</a></p>
                    <?php else: ?>
                        <p class="comment-about">
                            <label for="author" class="required"><?php _e('称呼');?></label>
                            <input type="text" name="author" id="author" class="text" value="<?php $this->remember('author');?>"/>
                        </p>
                        <p class="comment-about">
                            <label for="mail"<?php if ($this->options->commentsRequireMail): ?> class="required"<?php endif;?>><?php _e('邮箱');?></label>
                            <input type="email" name="mail" id="mail" class="text" value="<?php $this->remember('mail');?>"/>
                        </p>
                        <p class="comment-about">
                            <label for="url"<?php if ($this->options->commentsRequireURL): ?> class="required"<?php endif;?>><?php _e('网站');?></label>
                            <input type="url" name="url" id="url" class="text" placeholder="<?php _e('http://example.com');?>" value="<?php $this->remember('url');?>"/>
                        </p>
                    <?php endif;?>
                    <p>
                        <textarea rows="8" cols="50" name="text" class="text-area"><?php $this->remember('text');?></textarea>
                    </p>
                </div>
                <div class="col2">
                    <p>
                        <button type="submit" class="submit"><?php _e('提交评论');?></button>
                    </p>
                </div>
                <div class="clear"></div>
            </form>
        </div>
    <?php else: ?>
    <?php endif;?>
</div>
