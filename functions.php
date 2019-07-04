<?php
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

function themeConfig($form)
{

    $siteUrl = Helper::options()->siteUrl;

    $next_name = new Typecho_Widget_Helper_Form_Element_Text('next_name', NULL, '', _t('侧边栏显示的昵称'));
    $next_name->input->setAttribute('class', 'w-100 mono');
    $form->addInput($next_name);

    $next_gravatar = new Typecho_Widget_Helper_Form_Element_Text('next_gravatar', NULL, '', _t('侧边栏头像'), _t('填写图片地址'));
    $next_gravatar->input->setAttribute('class', 'w-100 mono');
    $form->addInput($next_gravatar);
	
	//ICP备案号
    $next_icp = new Typecho_Widget_Helper_Form_Element_Text('next_icp', NULL, '', _t('ICP备案号'));
    $next_icp->input->setAttribute('class', 'w-100 mono');
    $form->addInput($next_icp);

	//支付宝
    $next_alipay = new Typecho_Widget_Helper_Form_Element_Text('next_alipay', NULL, '', _t('支付宝二维码地址'));
    $next_icp->input->setAttribute('class', 'w-100 mono');
    $form->addInput($next_alipay);
	
	//微信
    $next_wechat = new Typecho_Widget_Helper_Form_Element_Text('next_wechat', NULL, '', _t('微信二维码地址'));
    $next_icp->input->setAttribute('class', 'w-100 mono');
    $form->addInput($next_wechat);
	
    $next_tips = new Typecho_Widget_Helper_Form_Element_Text('next_tips', NULL, '一个高端大气上档次的网站', _t('站点描述'), _t('将显示在侧边栏的昵称下方'));
    $form->addInput($next_tips);

    $next_cdn = new Typecho_Widget_Helper_Form_Element_Text('next_cdn', NULL, $siteUrl, _t('cdn镜像地址'), _t('静态文件cdn镜像加速地址，加速js和css，如七牛，又拍云等<br>格式参考：' . $siteUrl . '<br>不用请留空或者保持默认'));
    $form->addInput($next_cdn);

    $sidebarFlinks = new Typecho_Widget_Helper_Form_Element_Radio('sidebarFlinks',
        array('show' => _t('显示'),
            'hide' => _t('不显示'),
        ),
        'hide', _t('侧边栏友链设置'), _t('安装了 Hanny 的Links插件才可显示'));

    $form->addInput($sidebarFlinks);

    $sidebarNav = new Typecho_Widget_Helper_Form_Element_Checkbox('sidebarNav',
        array('main' => _t('首页'),
            'archive' => _t('归档'),
            'categories' => _t('分类'),
            'tags' => _t('标签'),
            'about' => _t('关于'),
            'search' => _t('搜索'),
        ),
        array('main', 'archive', 'tags', 'search',), _t('侧边导航栏设置'));

    $form->addInput($sidebarNav->multiMode());

    $sidebarOthers = new Typecho_Widget_Helper_Form_Element_Checkbox('sidebarOthers',
        array('ShowFeed' => _t('显示RSS订阅'),
        ),
        array('ShowFeed'), _t('其他设置'));

    $form->addInput($sidebarOthers->multiMode());
}

function getGravatar($email, $s = 40, $d = 'mm', $g = 'g')
{
    $hash = md5($email);
    $avatar = "//cdn.v2ex.com/gravatar/$hash?s=$s&d=$d&r=$g";
    return $avatar;
}

function getTagCount()
{
    $tags = Typecho_Widget::widget('Widget_Metas_Tag_Cloud');
    // 获取标签数目
    $count = 0;
    while ($tags->next()):
        $count++;
    endwhile;
    return $count;
}

function getIconName($slug)
{
    // 得到页面缩略名对应的字体图标名
    $names = array('archive' => 'archive', 'about' => 'user', 'categories' => 'folder-open', 'tags' => 'tags', 'links' => 'users');
    return $names[$slug];
}

function themeInit($archive)
{
    //归档列表全部输出
    if ($archive->is('archive') && !$archive->is('search')) {
        $archive->parameter->pageSize = 20; // 自定义条数
    }
}
/*
* 记录文章浏览量
*/
function get_post_view($archive)
{
    $cid    = $archive->cid;
    $db     = Typecho_Db::get();
    $prefix = $db->getPrefix();
    if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
        echo 0;
        return;
    }
    $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
    if ($archive->is('single')) {
       $db->query($db->update('table.contents')->rows(array('views' => (int) $row['views'] + 1))->where('cid = ?', $cid));
    }
    echo $row['views'];
}

//评论添加回复标记
function get_commentReply_at($coid)
{
    $db   = Typecho_Db::get();
    $prow = $db->fetchRow($db->select('parent')->from('table.comments')
                                 ->where('coid = ? AND status = ?', $coid, 'approved'));
    $parent = $prow['parent'];
    if ($parent != "0") {
        $arow = $db->fetchRow($db->select('author')->from('table.comments')
                                     ->where('coid = ? AND status = ?', $parent, 'approved'));
        $author = $arow['author'];
        $href   = '回复 <span style="color:#ff8300;">' . $author . '</span>：';
        echo $href;
    } else {
        echo '';
    }
}