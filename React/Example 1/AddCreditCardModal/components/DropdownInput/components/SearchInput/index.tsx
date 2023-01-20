import React, { ChangeEvent, memo } from 'react';
import { useTranslation } from 'react-i18next';
import { SearchIcon } from 'images/desktop/common';
import styles from './styles.module.scss';

type Props = {
	value: string;
	onChange: (e: ChangeEvent<HTMLInputElement>) => void;
};

export const SearchInput = memo(({ value, onChange }: Props) => {
	const { t } = useTranslation();

	return (
		<div className={styles.container}>
			<SearchIcon className={styles.icon} />
			<input
				value={value}
				className={styles.input}
				placeholder={t('billing_page_add_card_section_card_search_title')}
				onChange={onChange}
			/>
		</div>
	);
});
