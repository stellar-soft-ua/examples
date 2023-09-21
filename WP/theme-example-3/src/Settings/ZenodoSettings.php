<?php

namespace THEME\Theme\Settings;

use THEME\Framework\Admin\Fields\AjaxButton;
use THEME\Framework\Admin\Fields\HeadlineField;
use THEME\Framework\Admin\Fields\SelectField;
use THEME\Framework\Admin\Fields\TextField;
use THEME\Framework\Admin\SettingsPage;
use THEME\Theme\Commands\ZenodoPull;

class ZenodoSettings extends SettingsPage
{
    public function init()
    {
        $this->title = __('Zenodo');
        $this->capability = 'edit_pages';
    }

    public function fields()
    {
        $this->addField((new SelectField('theme_zenodo_api_environment', 'API Umgebung'))
            ->setDefaultValue('sandbox')
            ->setOptions([
                'sandbox' => 'Sandbox',
                'live'    => 'Live'
            ])
        );

        $this->addField((new TextField('theme_zenodo_api_key', __('API Key', 'theme')))
            ->setType('password')
        );

        $this->addField((new HeadlineField('Synchronisierung')));

        $this->addField((new AjaxButton('theme_zenodo_pull_all', 'Alle Publikationen importieren', __('Publikationen', 'theme')))
            ->setCommand(ZenodoPull::class)
        );

        $this->addField((new AjaxButton('theme_zenodo_pull_new', 'Nur Änderungen importieren'))
            ->setCommand(ZenodoPull::class, [], ['only-new' => true])
        );
    }
}
