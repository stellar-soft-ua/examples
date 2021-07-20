<?php

namespace App\View\Components\Properties;

use App\Models\Property\Property;
use Illuminate\View\Component;

class PropertyOwnership extends Component
{
    /**
     * @var string
     */
    public $badgeColor = '';

    /**
     * @var string
     */
    public $label;

    /**
     * Create a new component instance.
     *
     * @param string $label
     * @param int $status
     */
    public function __construct(string $label, int $status)
    {
        $this->label = $label;
        $this->badgeColor = $this->getColorForBadge($status);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.properties.property-ownership');
    }

    /**
     * @param $status
     * @return string
     */
    private function getColorForBadge($status): string
    {
        switch ($status) {
            case Property::OWNERSHIP_STATUS_INCOMPLETE: return 'badge_black'; break;
            case Property::OWNERSHIP_STATUS_PENDING: return 'badge_red'; break;
            default: return '';
        }
    }
}
