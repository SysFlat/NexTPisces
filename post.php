<?php if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}
?>
<?php $this->need('header.php'); ?>
<main id="main" class="main">
    <div class="main-inner">
        <div class="content-wrap">
            <div id="content" class="content">
                <div id="posts" class="posts-expand">
                    <article class="post post-type-normal " itemscope itemtype="http://schema.org/Article">
                        <header class="post-header">
                            <h1 class="post-title" itemprop="name headline">
                                <?php $this->title() ?>
                            </h1>
                            <div class="post-meta">
								 <span class="post-time">
									发表于
									<time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date('Y-m-d h:i:sa'); ?></time>
								</span>
								
								<span class="post-category">
								  &nbsp; | &nbsp; 分类于
									<span itemprop="about" itemscope itemtype="https://schema.org/Thing">
										<?php $this->category(' , '); ?>
									</span>
								</span>
								<span class="post-comments-count">
									&nbsp; | &nbsp;
									<a rel="nofollow" href="<?php $this->permalink() ?>#comments"><?php $this->commentsNum('暂无评论', '1 条评论', '%d 条评论'); ?></a>
							   </span>
							   <span>&nbsp; | &nbsp;<?php get_post_view($this);_e(' 次浏览'); ?></span>
                            </div>
                        </header>
                        <div class="post-body" itemprop="articleBody">
                            <?php $this->content(); ?>
                        </div>
		<blockquote class="blockquote-center" style = "font-weight:bold;font-size:20px;color: #333;padding: 18px;">完</blockquote>
		<div style="padding: 10px 0; margin: 20px auto; width: 100%; font-size:18px; text-align: center;">
			<button id="rewardButton" disable="enable" onclick="var qr = document.getElementById('QR'); if (qr.style.display === 'none') {qr.style.display='block';} else {qr.style.display='none'}">
			<span>打赏</span></button>
			<div id="QR" style="display: none;">
				<div id="wechat" style="display: inline-block">
					<a class="fancybox" rel="group">
						<img id="wechat_qr" src="<?php echo $this->options->next_wechat(); ?>" alt="WeChat Pay"></a>
					<p>微信打赏</p>
				</div>
				<div id="alipay" style="display: inline-block">
					<a class="fancybox" rel="group">
						<img id="alipay_qr" src="<?php echo $this->options->next_alipay(); ?>" alt="Alipay"></a>
					<p>支付宝打赏</p>
				</div>
			</div>
		</div>		
        <div class="post-well" style="background-color:#f6f6f6;padding:10px;margin-bottom: 10px;white-space: nowrap;">
            <p>文章版权：<a style="color:#15A7F0;" href="<?php $this->options->siteUrl() ?>"><?php $this->options->title() ?> - <?php $this->options->description() ?> </a></p>
            <p>本文链接：<a  style="color:#15A7F0;"href="<?php $this->permalink() ?>"><?php $this->permalink() ?></a></p>
            <p>版权声明：本文为作者原创，转载请注明文章原始出处 !</p>
        </div>		
                        <footer class="post-footer">
                            <div class="post-nav">
                                <div class="post-nav-next post-nav-item">
                                    <?php $this->theNext('<i class="fa fa-chevron-left"></i>%s', ''); ?>
                                </div>
                                <div class="post-nav-prev post-nav-item">
                                    <?php $this->thePrev('%s<i class="fa fa-chevron-right"></i>', ''); ?>
                                </div>
                            </div>
                        </footer>
                    </article>

                </div>
            </div>
            <?php $this->need('comments.php'); ?>
        </div>
        <?php $this->need('sidebar.php'); ?>
    </div>
</main>

<?php $this->need('footer.php'); ?>
