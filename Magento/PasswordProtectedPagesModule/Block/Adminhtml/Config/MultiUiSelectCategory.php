<?php

declare(strict_types=1);

namespace AL\ProductPassword\Block\Adminhtml\Config;

use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Config\Block\System\Config\Form\Field;

class MultiUiSelectCategory extends Field
{
    /**
     * Retrieve Element HTML fragment
     *
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        $script = " <script>
                require([
                    'jquery',
                    'chosen'
                ], function ($, chosen) {
                    $('#" . $element->getId() . "').chosen({
                        width: '100%',
                        placeholder_text: '" . __('Select Options') . "'
                    });
                    $('#" . $element->getId() . "_inherit').change(function() {
                        $('#" . $element->getId() . "').prop('disabled', $(this).is(':checked'));
  						$('#" . $element->getId() . "').trigger('chosen:updated');
                    });
                })
            </script>";

        return parent::_getElementHtml($element) . $script;
    }
}
