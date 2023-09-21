<?php

namespace THEME\Theme\Settings;

use THEME\Framework\Admin\Fields\HeadlineField;
use THEME\Framework\Admin\Fields\HtmlField;
use THEME\Framework\Admin\Fields\MediaField;
use THEME\Framework\Admin\Fields\TextField;
use THEME\Framework\Admin\SettingsPage;

class ThemeSettings extends SettingsPage
{
    public function init()
    {
        $this->title      = __('Settings');
        $this->rootPage   = 'themes.php';
        $this->capability = 'edit_theme_options';
    }

    public function fields()
    {
        $this->addField(new HeadlineField(__('Soziale Medien')));

        $this->addField((new TextField('theme_theme_social_heading', 'Überschrift Soziale Medien'))
            ->makeTranslatable()
        );

        $this->addField((new TextField('theme_theme_social_facebook', 'Facebook'))
            ->setType('url')
        );

        $this->addField((new TextField('theme_theme_social_twitter', 'Twitter'))
            ->setType('url')
        );

        $this->addField((new TextField('theme_theme_social_linkedin', 'LinkedIn'))
            ->setType('url')
        );

        $this->addField((new MediaField('theme_theme_aplus_logo', 'a+ Logo'))
            ->makeTranslatable()
            ->setDisplayHeight(80)
        );

        $this->addField((new TextField('theme_theme_aplus_link', 'a+ Link'))
            ->makeTranslatable()
            ->setType('url')
        );

        /**
        $this->addField(new HeadlineField(__('Seite Teilen')));

        $this->addField((new HtmlField('theme_theme_sharing_email_body', 'E-Mail Text'))->makeTranslatable());
         **/
    }
}
