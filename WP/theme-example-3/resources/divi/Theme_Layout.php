<?php

class Theme_Layout
{

    public function getThemeDiviLayouts()
    {
        $layouts = [
            [
                'name'            => __('Breit', 'theme'),
                'type'            => 'regular',
                'adminStyle'      => '',
                'speciality'      => [],
                'definition'      => '1_1 col-lg-12',
                'oldAdminClasses' => [
                    'et_pb_layout_column',
                ],
            ],
            [
                'name'            => __('Schmal', 'theme'),
                'type'            => 'regular',
                'adminStyle'      => '',
                'speciality'      => [],
                'definition'      => '1_1 col-xl-8 offset-xl-2 col-lg-10 offset-lg-1',
                'oldAdminClasses' => [
                    'et_pb_layout_column',
                ],
            ],
            [
                'name'            => __('Zwei-Spaltig', 'theme'),
                'type'            => 'regular',
                'adminStyle'      => '',
                'speciality'      => [],
                'definition'      => '1_2 col-lg-6,1_2 col-lg-6',
                'oldAdminClasses' => [
                    'et_pb_layout_column',
                ],
            ],
            [
                'name'            => __('Drei-Spaltig', 'theme'),
                'type'            => 'regular',
                'adminStyle'      => '',
                'speciality'      => [],
                'definition'      => '1_3 col-lg-4,1_3 col-lg-4,1_3 col-lg-4',
                'oldAdminClasses' => [
                    'et_pb_layout_column',
                ],
            ],
        ];

        return $layouts;
    }

    // TODO check to move these functions to the framework...getNewDiviLayouts
    public function getNewAdminCss()
    {
        $newAdminCss = '#et-fb-settings-column ul.et-fb-columns-layout li {overflow:hidden;}
        #et-fb-settings-column ul.et-fb-columns-layout li::after {white-space: nowrap;}';
        $regularColumns = array_filter($this->getThemeDiviLayouts(), function ($v) {
            return $v['type'] === 'regular';
        });


        foreach ($regularColumns as $regularColumn) {
            $newAdminCss .= '#et-fb-settings-column ul.et-fb-columns-layout li[data-layout="' . $regularColumn['definition'] . '"] {
                ' . $regularColumn['adminStyle'] . '
            }
            #et-fb-settings-column ul.et-fb-columns-layout li[data-layout="' . $regularColumn['definition'] . '"]::after {
                content: "' . $regularColumn['name'] . '"; } {
            }';
        }

        return $newAdminCss;
    }

    public function getOldDiviLayouts()
    {
        $oldDiviLayouts = '<% if ( typeof et_pb_specialty !== \'undefined\' && et_pb_specialty === \'on\' ) { %>
            <% } else if ( typeof view !== \'undefined\' && typeof view.model.attributes.specialty_columns !== \'undefined\' ) { %>
            <% } else { %>';
        $regularColumns = array_filter($this->getThemeDiviLayouts(), function ($v) {
            return $v['type'] === 'regular';
        });
        foreach ($regularColumns as $regularColumn) {
            $oldDiviLayouts .= '<li data-layout=' . $regularColumn['definition'] . '>';
            foreach ($regularColumn['oldAdminClasses'] as $adminClasses) {
                $oldDiviLayouts .= '<div class="' . $adminClasses . '"></div>';
            }
            $oldDiviLayouts .= '</li>';
        }
        $oldDiviLayouts .= '<%
            }
            %>';

        return $oldDiviLayouts;
    }

    public function getNewDiviLayouts()
    {

        $newRegularColumns = [];
        $regularColumns = array_filter($this->getThemeDiviLayouts(), function ($v) {
            return $v['type'] === 'regular';
        });
        foreach ($regularColumns as $regularColumn) {
            $newRegularColumns[] = $regularColumn['definition'];
        }
        $columns = [
            'specialty' => [
            ],
            'regular'   => $newRegularColumns,
        ];


        return $columns;
    }

}
