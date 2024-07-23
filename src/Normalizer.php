<?php

namespace istogram\WpDashboardNormalizer;

use Roots\Acorn\Application;

class Normalizer
{
    /**
     * The application instance.
     *
     * @var \Roots\Acorn\Application
     */
    protected $app;

    /**
     * Create a new Normalizer instance.
     *
     * @param  \Roots\Acorn\Application  $app
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;

        if (config('normalizer.enabled')) {
            $this->normalize();
        }
    }

    public function normalize()
    {
        $this->setAdminColor();

        if (config('normalizer.color_scheme_picker') === false) {
            $this->removeColorSchemePicker();
        }

        if (config('normalizer.welcome_panel') === false) {
            $this->removeWelcomePanel();
        }

        if (config('normalizer.admin_notices') === false) {
            $this->removeAdminNotices();
        }

        if (config('normalizer.wordpress_logo') === false) {
            $this->removeWordpressLogo();
        }

        if (config('normalizer.wordpress_updates_link') === false) {
            $this->removeWordpressUpdatesLink();
        }

        if (config('normalizer.admin_menu_comments_link') === false) {
            $this->removeAdminMenuCommentsLink();
        }

        if (config('normalizer.admin_new_content_link') === false) {
            $this->removeAdminNewContentLink();
        }

        if (config('normalizer.footer_brand_text') === false) {
            $this->removeFooterBrandText();
        }

        if (config('normalizer.footer_version_text') === false) {
            $this->removeFooterVersionText();
        }

        if (config('normalizer.admin_bar.from_frontend') === false) {
            $this->removeAdminBarFromFrontEnd();
        }
    }

    public function setAdminColor()
    {
        add_filter('get_user_option_admin_color', function () {
            return config('normalizer.admin_color');
        });
    }

    public function removeColorSchemePicker()
    {
        add_action('admin_head-profile.php', function() {
            remove_action("admin_color_scheme_picker", "admin_color_scheme_picker");
        });
    }

    public function removeWelcomePanel()
    {
        add_action('admin_init', function () {
            remove_action('welcome_panel', 'wp_welcome_panel');
        });
    }

    public function removeAdminNotices()
    {
        add_action('admin_init', function () {
            remove_all_actions('admin_notices');
        });
    }

    public function removeWordpressLogo()
    {
        add_action('wp_before_admin_bar_render', function() {
            global $wp_admin_bar;
            $wp_admin_bar->remove_menu('wp-logo');
        });
    }

    public function removeWordpressUpdatesLink()
    {
        add_action('admin_menu', function () {
            remove_submenu_page('index.php', 'update-core.php');
        });
    }

    public function removeAdminMenuCommentsLink()
    {
        add_action('wp_before_admin_bar_render', function() {
            global $wp_admin_bar;
            $wp_admin_bar->remove_menu('comments');
        });
    }

    public function removeAdminNewContentLink()
    {
        add_action('wp_before_admin_bar_render', function() {
            global $wp_admin_bar;
            $wp_admin_bar->remove_node('new-content');
        });
    }

    public function removeFooterBrandText()
    {
        add_filter('admin_footer_text', '__return_empty_string', 11);
    }

    public function removeFooterVersionText()
    {
        add_filter('update_footer', '__return_empty_string', 11);
    }

    public function removeAdminBarFromFrontEnd()
    {
        add_filter('show_admin_bar', '__return_false');
    }
}
