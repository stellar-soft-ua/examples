import type {FC} from 'react';
import classNames from 'classnames';

interface BreadcrumbItemProps {
  title: string;
  isActive: boolean;
  onClick: () => unknown;
}

const BreadcrumbItem: FC<BreadcrumbItemProps> = ({title, isActive, onClick}) => (
  <button
    className={classNames(
      'cursor-pointer rounded-[1rem] p-2 transition-colors duration-200',
      isActive
        ? 'bg-primary-light text-primary-deep'
        : 'bg-transparent text-red-2 hover:bg-primary-extra-light hover:text-primary-deep'
    )}
    onClick={onClick}
  >
    <span className="text-[1.2rem] leading-[1.5rem]">{title}</span>
  </button>
);

export default BreadcrumbItem;
