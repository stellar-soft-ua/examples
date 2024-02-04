import type {FC} from 'react';
import {Fragment} from 'react';
import classNames from 'classnames';

import {FilledRightChevron} from '@/assets/icons';

import BreadcrumbItem from './BreadcrumbItem';

type BreadcrumbItem = {
  value: number | string;
  title: string;
};

interface BreadcrumbProps {
  className?: string;
  activeItem: number | string;
  items: BreadcrumbItem[];
  onItemClick: (value: number | string) => unknown;
}

const Breadcrumb: FC<BreadcrumbProps> = ({items, activeItem, onItemClick, className}) => {
  return (
    <div className={classNames('flex items-center gap-x-2', className)}>
      {items.map((tab, index) => (
        <Fragment key={tab.value}>
          {index !== 0 && (
            <FilledRightChevron color="var(--colors-blue-4)" width="2rem" height="1.5rem" />
          )}
          <BreadcrumbItem
            key={tab.value}
            title={tab.title}
            isActive={activeItem === tab.value}
            onClick={() => onItemClick(tab.value)}
          />
        </Fragment>
      ))}
    </div>
  );
};

export default Breadcrumb;
