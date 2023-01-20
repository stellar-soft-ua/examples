import React, { memo } from 'react';
import clsx from 'clsx';
import { CheckmarkIcon } from 'images/common/creatorTools';
import styles from './styles.module.scss';

type Props = {
	title: string;
	selected: boolean;
	onOptionClick: () => void;
};

export const DropdownMenuItem = memo(({ title, selected, onOptionClick }: Props) => {
	const containerClass = clsx(styles.container, selected && styles.selectedContainer);

	return (
		<div className={containerClass} onClick={onOptionClick}>
			<p className={styles.title}>{title}</p>
			{selected && <CheckmarkIcon />}
		</div>
	);
});
