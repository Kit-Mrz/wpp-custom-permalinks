<?php

namespace Mrzkit\WppCustomPermalinks\Admin;

class CustomPermalinksAdmin
{
    /**
     * @var string Css 文件扩展后缀
     */
    private $css_file_suffix;

    /**
     * 初始化 WordPress hooks
     */
    public function init()
    {
        $this->css_file_suffix = '-' . CUSTOM_PERMALINKS_VERSION . '.min.css';

        // 在管理屏幕或脚本初始化时触发
        add_action('admin_init', array($this, 'privacy_policy'));
        // 在管理员中加载管理菜单之前触发
        add_action('admin_menu', array($this, 'admin_menu'));
        // 在 WordPress 完成加载后但在发送任何标头之前触发
        add_action('init', array($this, 'allow_redirection'));
        // 在插件页面下添加关于和高级设置页面链接
        add_filter('plugin_action_links_' . CUSTOM_PERMALINKS_BASENAME, array($this, 'settings_link'));
    }

    /**
     * @desc 在设置菜单中添加页面
     */
    public function admin_menu()
    {
        // 顶级菜单: Custom Permalinks
        add_menu_page(
            'Custom Permalinks',
            'Custom Permalinks',
            'cp_view_post_permalinks',
            'cp-post-permalinks',
            array($this, 'post_permalinks_page'),
            'dashicons-admin-links'
        );

        // 菜单: Post Types Permalinks
        $post_permalinks_hook = add_submenu_page(
            'cp-post-permalinks',
            'Post Types Permalinks',
            'Post Types Permalinks',
            'cp_view_post_permalinks',
            'cp-post-permalinks',
            array($this, 'post_permalinks_page')
        );

        // 菜单: Taxonomies Permalinks
        $taxonomy_permalinks_hook = add_submenu_page(
            'cp-post-permalinks',
            'Taxonomies Permalinks',
            'Taxonomies Permalinks',
            'cp_view_category_permalinks',
            'cp-taxonomy-permalinks',
            array($this, 'taxonomy_permalinks_page')
        );

        // 菜单: About
        $about_page = add_submenu_page(
            'cp-post-permalinks',
            'About Custom Permalinks',
            'About',
            'install_plugins',
            'cp-about-plugins',
            array($this, 'about_plugin')
        );

        add_action('load-' . $post_permalinks_hook, [CustomPermalinksPostTypesTable::class, 'instance']);

        add_action('load-' . $taxonomy_permalinks_hook, [CustomPermalinksPostTypesTable::class, 'instance']);

        add_action('admin_print_styles-' . $about_page . '', array($this, 'add_about_style'));
    }

    /**
     * @desc 添加 about 页面样式
     */
    public function add_about_style()
    {
        $pluginsUrl = plugins_url('/resources/assets/css/about-plugins' . $this->css_file_suffix, dirname(__DIR__) . '/resources/');

        wp_enqueue_style('custom-permalinks-about-style', $pluginsUrl, array(), CUSTOM_PERMALINKS_VERSION);
    }

    /**
     * @desc 调用另一个显示帖子类型永久链接页面的函数
     */
    public function post_permalinks_page()
    {
        CustomPermalinksPostTypesTable::output();

        // 过滤管理页脚中显示的 "Thank you" 文本
        add_filter('admin_footer_text', array($this, 'admin_footer_text'), 1);
    }

    /**
     * @desc 调用另一个显示分类永久链接页面的函数
     */
    public function taxonomy_permalinks_page()
    {
        CustomPermalinksTaxonomiesTable::output();

        // 过滤管理页脚中显示的 "Thank you" 文本
        add_filter('admin_footer_text', array($this, 'admin_footer_text'), 1);
    }

    /**
     * Add About Plugins Page.
     *
     * @return void
     * @since 1.2.11
     * @access public
     *
     */
    public function about_plugin()
    {
        new CustomPermalinksAbout();

        // 过滤管理页脚中显示的 "Thank you" 文本
        add_filter('admin_footer_text', array($this, 'admin_footer_text'), 1);
    }

    /**
     * @desc 在管理页面的页脚添加插件支持和关注消息
     * @return string
     */
    public function admin_footer_text()
    {
        $cp_footer_text = __('Custom Permalinks version', 'custom-permalinks') .
                          ' ' . CUSTOM_PERMALINKS_VERSION . ' ' .
                          __('by', 'custom-permalinks') .
                          ' <a href="https://www.yasglobal.com/" target="_blank">' .
                          __('Sami Ahmed Siddiqui', 'custom-permalinks') .
                          '</a>' .
                          ' - ' .
                          '<a href="https://wordpress.org/support/plugin/custom-permalinks" target="_blank">' .
                          __('Support forums', 'custom-permalinks') .
                          '</a>' .
                          ' - ' .
                          'Follow on Twitter:' .
                          ' <a href="https://twitter.com/samisiddiqui91" target="_blank">' .
                          __('Sami Ahmed Siddiqui', 'custom-permalinks') .
                          '</a>';

        return $cp_footer_text;
    }

    /**
     * @desc 在插件页面下添加关于和高级设置页面链接
     * @param array $links Contains the Plugin Basic Link (Activate/Deactivate/Delete).
     * @return mixed
     */
    public function settings_link($links)
    {
        $links = (array) $links;

        $about_link = '<a href="admin.php?page=cp-about-plugins" target="_blank">' . __('About', 'custom-permalinks') . '</a>';

        $support_link = '<a href="https://www.custompermalinks.com/#pricing-section" target="_blank">' . __('Premium Support', 'custom-permalinks') . '</a>';

        $contact_link = '<a href="https://www.custompermalinks.com/contact-us/" target="_blank">' . __('Contact', 'custom-permalinks') . '</a>';

        array_unshift($links, $contact_link);
        array_unshift($links, $support_link);
        array_unshift($links, $about_link);

        return $links;
    }

    /**
     * @desc 添加有关插件的隐私政策
     */
    public function privacy_policy()
    {
        if ( !function_exists('wp_add_privacy_policy_content')) {
            return;
        }

        $cp_privacy = esc_html__(
            'This plugin collect information about the site like URL, WordPress version etc. This plugin doesn\'t collect any user related information. To have any kind of further query please feel free to',
            'custom-permalinks'
        );
        $cp_privacy = $cp_privacy . ' <a href="https://www.custompermalinks.com/contact-us/" target="_blank">' . esc_html__('contact us', 'custom-permalinks') . '</a>';

        // Replaces double line breaks with paragraph elements
        $autop = wpautop($cp_privacy, false);

        // Sanitizes content for allowed HTML tags for post content
        $ksesPost = wp_kses_post($autop);

        // 声明用于向隐私政策指南添加内容的辅助函数
        wp_add_privacy_policy_content('Custom Permalinks', $ksesPost);
    }

    /**
     * @desc 缓冲输出以允许重定向，即使网站开始向浏览器发送输出
     */
    public function allow_redirection()
    {
        if (isset($_REQUEST['_custom_permalinks_post_nonce']) || isset($_REQUEST['_custom_permalinks_taxonomy_nonce'])) {
            ob_start();
        }
    }
}
