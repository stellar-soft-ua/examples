import React, { ChangeEvent, memo, useCallback, useRef } from 'react';
import { useTranslation } from 'react-i18next';
import { motion } from 'framer-motion';
import { useOnClickOutside } from 'hooks';
import { CountryState } from 'utils/countries';
import { SearchInput } from '../SearchInput';
import { DropdownMenuItem } from '../DropdownMenuItem';
import styles from './styles.module.scss';

type Props = {
	show: boolean;
	options: Array<CountryState>;
	selectedOption: string;
	searchValue: string;
	onOptionClick: (option: string) => void;
	onSearchChange: (search: string) => void;
	onClickOutside: (event: Event) => void;
};

export const DropdownMenu = memo(
	({
		show,
		options,
		selectedOption,
		searchValue,
		onOptionClick,
		onSearchChange,
		onClickOutside,
	}: Props) => {
		const { t } = useTranslation();

		const containerRef = useRef<HTMLDivElement | null>(null);

		useOnClickOutside(containerRef, (event: Event) => {
			onClickOutside(event);
		});

		const hasOptions = options.length > 0;

		const animationVariants = {
			initial: {
				height: 0,
				overflow: 'hidden',
				opacity: 0,
			},
			show: {
				height: 'auto',
				overflow: 'auto',
				opacity: 1,
			},
			hide: {
				height: 0,
				overflow: 'hidden',
				opacity: 0,
			},
		};

		const handleSearchChange = useCallback(
			(e: ChangeEvent<HTMLInputElement>) => {
				onSearchChange(e.currentTarget.value);
			},
			[onSearchChange]
		);

		return (
			<motion.div
				initial={'initial'}
				animate={show ? 'show' : 'hide'}
				variants={animationVariants}
				transition={{ duration: 0.3 }}
				className={styles.container}
				ref={containerRef}
			>
				<SearchInput value={searchValue} onChange={handleSearchChange} />
				{hasOptions ? (
					options.map((option) => {
						return (
							<DropdownMenuItem
								key={option.name}
								title={option.name}
								selected={selectedOption === option.name}
								onOptionClick={() => onOptionClick(option.name)}
							/>
						);
					})
				) : (
					<div className={styles.notFoundSection}>
						<p className={styles.title}>
							{t('billing_page_add_card_section_card_not_found')}
						</p>
					</div>
				)}
			</motion.div>
		);
	}
);
