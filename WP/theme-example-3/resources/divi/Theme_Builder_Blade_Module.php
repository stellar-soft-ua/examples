<?php

use THEME\Framework\Templating\Blade;

abstract class Theme_Builder_Blade_Module extends Theme_Builder_Module
{
    /**
     * Render the template located under ./templates/[MODULE_NAME].blade.php.
     * The defined fields are available inside the template by default.
     * You can add additional or edit default fields by overriding the get_additional_blade_data() method.
     *
     * @param string $render_slug
     * @return mixed
     */
    public function render_blade_template($render_slug)
    {
        $templatesDir = __DIR__ . '/templates';
        $templateName = get_class($this);

        $templateVars = array_merge(
            $this->get_default_blade_data($render_slug),
            $this->get_additional_blade_data()
        );

        try {
            return Blade::instance($templatesDir)->view()->make($templateName, $templateVars)->render();
        } catch (InvalidArgumentException $exception) {
            return '<!-- Template ' . $templateName . ' not found -->';
        }
    }

    /**
     * Passes the content of all fields to the template by default.
     *
     * All other props are available under $props.
     *
     * @param string $render_slug
     * @return array
     */
    private function get_default_blade_data($render_slug)
    {
        $module_class = esc_attr(ET_Builder_Element::add_module_order_class(
            $this->props['module_class'], $render_slug)
        );

        $fields = $this->get_fields();
        $vars = [];

        foreach ($fields as $field => $config) {
            if (array_key_exists($field, $this->props)) {
                $vars[$field] = $this->props[$field];
            }
        }

        $vars['props'] = (array)$this->props;
        $vars['module_class'] = trim($module_class);

        return $vars;
    }

    /**
     * An optional array of variables that should be passed to the module template.
     *
     * @return array
     */
    public function get_additional_blade_data()
    {
        return [];
    }

    /**
     * Automatically uses the blade template to render the module.
     *
     * @param array $attrs
     * @param null $content
     * @param string $render_slug
     * @return string
     */
    public function render($attrs, $content = null, $render_slug)
    {
        return $this->render_blade_template($render_slug);
    }
}
