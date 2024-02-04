import type {StoryFn, Meta} from '@storybook/react';
import {useArgs} from '@storybook/client-api';

import Breadcrumb from './Breadcrumb';

const items = [
  {value: 1, title: 'Home'},
  {value: 2, title: 'Category'},
  {value: 3, title: 'Sub category'},
  {value: 4, title: 'Parameters'},
];

export default {
  title: 'Components/Breadcrumb',
  component: Breadcrumb,
  parameters: {
    layout: 'centered',
  },
  argTypes: {
    activeItem: {control: {type: 'number', min: 1, max: 4}},
  },
} as Meta<typeof Breadcrumb>;

const Template: StoryFn<typeof Breadcrumb> = (args) => {
  const [_, updateArgs] = useArgs();

  const onItemClick = (value) => {
    updateArgs({...args, activeItem: value});
  };

  return <Breadcrumb {...args} onItemClick={onItemClick} />;
};

export const Primary = Template.bind({});
Primary.args = {
  items,
  activeItem: 1,
};
